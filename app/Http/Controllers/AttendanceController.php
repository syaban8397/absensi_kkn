<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Services\AttendanceGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('attendances.morning');
    }

    public function morning(Request $request, AttendanceGeneratorService $generator): View|RedirectResponse
    {
        return $this->showForm($request, $generator, Attendance::PERIOD_PAGI);
    }

    public function evening(Request $request, AttendanceGeneratorService $generator): View|RedirectResponse
    {
        return $this->showForm($request, $generator, Attendance::PERIOD_SORE);
    }

    public function history(Request $request, AttendanceGeneratorService $generator): View|RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $generator->ensureTodayIsGenerated();

        $history = $request->user()
            ->attendances()
            ->latest('attendance_date')
            ->orderByRaw("FIELD(period, 'sore', 'pagi')")
            ->paginate(20);

        $summary = [
            'hadir' => $request->user()->attendances()->where('status', Attendance::STATUS_HADIR)->count(),
            'izin' => $request->user()->attendances()->where('status', Attendance::STATUS_IZIN)->count(),
            'pulang' => $request->user()->attendances()->where('status', Attendance::STATUS_PULANG)->count(),
            'alfa' => $request->user()->attendances()->where('status', Attendance::STATUS_ALFA)->count(),
        ];

        return view('attendances.history', [
            'history' => $history,
            'summary' => $summary,
        ]);
    }

    private function showForm(Request $request, AttendanceGeneratorService $generator, string $period): View|RedirectResponse
    {
        if ($request->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $generator->ensureTodayIsGenerated();

        $today = today()->toDateString();

        $attendance = $request->user()
            ->attendances()
            ->whereDate('attendance_date', $today)
            ->where('period', $period)
            ->firstOrFail();

        $morningAttendance = $request->user()
            ->attendances()
            ->whereDate('attendance_date', $today)
            ->where('period', Attendance::PERIOD_PAGI)
            ->first();

        $periodOpen = Attendance::isWithinWindow($period);
        $windowLabel = Attendance::windowLabel($period);
        $windowMessage = $periodOpen
            ? 'Form absensi sedang dibuka.'
            : 'Form hanya bisa diisi pada jam '.$windowLabel.'. Jika tidak diisi sampai batas waktu selesai, status tetap Alfa.';

        $canPulang = true;
        $pulangMessage = null;

        if ($period === Attendance::PERIOD_SORE) {
            if (! $morningAttendance?->attendance_at) {
                $canPulang = false;
                $pulangMessage = 'Status Pulang membutuhkan data absen pagi terlebih dahulu.';
            } else {
                $remainingMinutes = max(0, 420 - $morningAttendance->attendance_at->diffInMinutes(now()));

                if ($remainingMinutes > 0) {
                    $canPulang = false;
                    $hours = intdiv($remainingMinutes, 60);
                    $minutes = $remainingMinutes % 60;
                    $pulangMessage = 'Status Pulang aktif minimal 7 jam setelah absen pagi. Sisa waktu: '.$hours.' jam '.$minutes.' menit.';
                }
            }
        }

        return view('attendances.form', [
            'today' => $today,
            'period' => $period,
            'periodLabel' => $period === Attendance::PERIOD_PAGI ? 'Pagi' : 'Sore',
            'attendance' => $attendance,
            'morningAttendance' => $morningAttendance,
            'statuses' => Attendance::statusesForPeriod($period),
            'canPulang' => $canPulang,
            'pulangMessage' => $pulangMessage,
            'periodOpen' => $periodOpen,
            'windowLabel' => $windowLabel,
            'windowMessage' => $windowMessage,
        ]);
    }

    public function store(Request $request, AttendanceGeneratorService $generator): RedirectResponse
    {
        abort_unless($request->user()->isPeserta(), 403);

        $generator->ensureTodayIsGenerated();

        $validated = $request->validate([
            'period' => ['required', 'in:pagi,sore'],
            'status' => ['required', 'in:hadir,izin,sakit,alfa,pulang'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        if (! Attendance::isWithinWindow($validated['period'])) {
            return back()->withErrors([
                'period' => 'Absensi '.ucfirst($validated['period']).' hanya bisa diisi pada jam '.Attendance::windowLabel($validated['period']).'. Jika tidak diisi sampai batas waktu selesai, status otomatis tetap Alfa.',
            ])->withInput();
        }

        $today = today()->toDateString();

        if ($validated['period'] === Attendance::PERIOD_PAGI && $validated['status'] === Attendance::STATUS_PULANG) {
            return back()->withErrors([
                'status' => 'Status Pulang hanya boleh dipilih pada absensi sore.',
            ])->withInput();
        }

        if ($validated['period'] === Attendance::PERIOD_SORE && $validated['status'] === Attendance::STATUS_PULANG) {
            $morning = $request->user()
                ->attendances()
                ->whereDate('attendance_date', $today)
                ->where('period', Attendance::PERIOD_PAGI)
                ->first();

            if (! $morning || ! $morning->attendance_at) {
                return back()->withErrors([
                    'status' => 'Kamu harus mengisi absen pagi dulu sebelum memilih status Pulang.',
                ])->withInput();
            }

            if ($morning->attendance_at->diffInMinutes(now()) < 420) {
                return back()->withErrors([
                    'status' => 'Absen pulang baru bisa dilakukan minimal 7 jam setelah absen pagi.',
                ])->withInput();
            }
        }

        $attendance = Attendance::where('user_id', $request->user()->id)
            ->whereDate('attendance_date', $today)
            ->where('period', $validated['period'])
            ->firstOrFail();

        $attendance->update([
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
            'attendance_at' => now(),
        ]);

        $route = $validated['period'] === Attendance::PERIOD_PAGI
            ? 'attendances.morning'
            : 'attendances.evening';

        return redirect()
            ->route($route)
            ->with('status', 'Absensi '.ucfirst($validated['period']).' berhasil disimpan.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Services\AttendanceGeneratorService;
use App\Services\AttendanceReportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(
        Request $request,
        AttendanceGeneratorService $generator,
        AttendanceReportService $reportService
    ): View {
        $generator->ensureTodayIsGenerated();

        $date = $request->query('date', today()->toDateString());

        $summaryRows = $reportService->summary($date);

        $attendances = Attendance::query()
            ->with('user')
            ->whereDate('attendance_date', $date)
            ->orderBy(User::select('name')->whereColumn('users.id', 'attendances.user_id'))
            ->orderByRaw("FIELD(period, 'pagi', 'sore')")
            ->get();

        return view('admin.dashboard', [
            'date' => $date,
            'summaryRows' => $summaryRows,
            'attendances' => $attendances,
            'morningAttendances' => $attendances->where('period', Attendance::PERIOD_PAGI)->values(),
            'eveningAttendances' => $attendances->where('period', Attendance::PERIOD_SORE)->values(),
        ]);
    }

    public function update(Request $request, Attendance $attendance): RedirectResponse
    {
        $allowedStatuses = array_keys(Attendance::statusesForPeriod($attendance->period));

        $validated = $request->validate([
            'status' => ['required', Rule::in($allowedStatuses)],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $attendance->update([
            'status' => $validated['status'],
            'note' => $validated['note'] ?? null,
            'attendance_at' => $validated['status'] === Attendance::STATUS_ALFA ? null : now(),
        ]);

        return back()->with('status', 'Absensi '.$attendance->user->name.' periode '.$attendance->periodLabel().' berhasil diubah admin tanpa aturan tunggu 7 jam.');
    }
}

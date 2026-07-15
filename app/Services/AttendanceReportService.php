<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Support\Collection;

class AttendanceReportService
{
    public function summary(string $date): Collection
    {
        return User::query()
            ->peserta()
            ->with(['attendances' => fn ($query) => $query->orderBy('attendance_date')->orderBy('period')])
            ->orderBy('name')
            ->get()
            ->map(function (User $user) use ($date) {
                $todayRows = $user->attendances
                    ->filter(fn (Attendance $attendance): bool => $attendance->attendance_date->toDateString() === $date)
                    ->sortBy(fn (Attendance $attendance): int => $attendance->period === Attendance::PERIOD_PAGI ? 1 : 2)
                    ->map(fn (Attendance $attendance) => $attendance->periodLabel().': '.$attendance->statusLabel())
                    ->values()
                    ->implode(' | ');

                return [
                    'nama' => $user->name,
                    'status_kehadiran_hari' => $todayRows !== '' ? $todayRows : '-',
                    'hadir' => $user->attendances->where('status', Attendance::STATUS_HADIR)->count(),
                    'izin' => $user->attendances->where('status', Attendance::STATUS_IZIN)->count(),
                    'pulang' => $user->attendances->where('status', Attendance::STATUS_PULANG)->count(),
                    'alfa' => $user->attendances->where('status', Attendance::STATUS_ALFA)->count(),
                ];
            });
    }
}

<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use Carbon\CarbonInterface;

class AttendanceGeneratorService
{
    public function ensureTodayIsGenerated(): void
    {
        $now = now();

        if ($now->lt($now->copy()->startOfDay()->addMinute())) {
            return;
        }

        $this->ensureDateIsGenerated($now);
    }

    public function ensureDateIsGenerated(CarbonInterface $date): void
    {
        $day = $date->toDateString();

        User::query()
            ->peserta()
            ->select(['id'])
            ->chunkById(100, function ($participants) use ($day) {
                foreach ($participants as $participant) {
                    foreach ([Attendance::PERIOD_PAGI, Attendance::PERIOD_SORE] as $period) {
                        Attendance::firstOrCreate(
                            [
                                'user_id' => $participant->id,
                                'attendance_date' => $day,
                                'period' => $period,
                            ],
                            [
                                'status' => Attendance::STATUS_ALFA,
                            ]
                        );
                    }
                }
            });
    }
}

<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    public const PERIOD_PAGI = 'pagi';
    public const PERIOD_SORE = 'sore';

    public const STATUS_HADIR = 'hadir';
    public const STATUS_IZIN = 'izin';
    public const STATUS_SAKIT = 'sakit';
    public const STATUS_ALFA = 'alfa';
    public const STATUS_PULANG = 'pulang';

    public const PAGI_START = '05:00';
    public const PAGI_END = '11:00';
    public const SORE_START = '13:00';
    public const SORE_END = '22:00';

    protected $fillable = [
        'user_id',
        'attendance_date',
        'period',
        'status',
        'note',
        'attendance_at',
    ];

    protected function casts(): array
    {
        return [
            'attendance_date' => 'date',
            'attendance_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function statuses(): array
    {
        return [
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_IZIN => 'Izin',
            self::STATUS_SAKIT => 'Sakit',
            self::STATUS_ALFA => 'Alfa',
            self::STATUS_PULANG => 'Pulang',
        ];
    }

    public static function statusesForPeriod(string $period): array
    {
        if ($period === self::PERIOD_PAGI) {
            return [
                self::STATUS_HADIR => 'Hadir',
                self::STATUS_IZIN => 'Izin',
                self::STATUS_SAKIT => 'Sakit',
                self::STATUS_ALFA => 'Alfa',
            ];
        }

        return self::statuses();
    }

    public static function windowForPeriod(string $period): array
    {
        return match ($period) {
            self::PERIOD_PAGI => [self::PAGI_START, self::PAGI_END],
            self::PERIOD_SORE => [self::SORE_START, self::SORE_END],
            default => ['00:00', '00:00'],
        };
    }

    public static function windowLabel(string $period): string
    {
        [$start, $end] = self::windowForPeriod($period);

        return $start.' - '.$end;
    }

    public static function isWithinWindow(string $period, ?CarbonInterface $time = null): bool
    {
        $time ??= now();

        [$start, $end] = self::windowForPeriod($period);

        $startAt = $time->copy()->setTimeFromTimeString($start);
        $endAt = $time->copy()->setTimeFromTimeString($end);

        return $time->betweenIncluded($startAt, $endAt);
    }

    public function statusLabel(): string
    {
        return self::statuses()[$this->status] ?? ucfirst($this->status);
    }

    public function periodLabel(): string
    {
        return ucfirst($this->period);
    }

    public function windowLabelForPeriod(): string
    {
        return self::windowLabel($this->period);
    }
}

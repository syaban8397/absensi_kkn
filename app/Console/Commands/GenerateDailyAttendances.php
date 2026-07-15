<?php

namespace App\Console\Commands;

use App\Services\AttendanceGeneratorService;
use Illuminate\Console\Command;

class GenerateDailyAttendances extends Command
{
    protected $signature = 'attendances:generate-daily {date? : Format YYYY-MM-DD, kosongkan untuk hari ini}';

    protected $description = 'Membuat absensi pagi dan sore untuk semua peserta KKN.';

    public function handle(AttendanceGeneratorService $generator): int
    {
        $date = $this->argument('date')
            ? now()->parse($this->argument('date'))
            : now();

        $generator->ensureDateIsGenerated($date);

        $this->info('Absensi harian berhasil dibuat untuk tanggal '.$date->toDateString().'.');

        return self::SUCCESS;
    }
}

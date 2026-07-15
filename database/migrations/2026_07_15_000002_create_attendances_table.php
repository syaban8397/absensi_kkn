<?php

use App\Models\Attendance;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('attendance_date')->index();
            $table->enum('period', [Attendance::PERIOD_PAGI, Attendance::PERIOD_SORE])->index();
            $table->enum('status', [
                Attendance::STATUS_HADIR,
                Attendance::STATUS_IZIN,
                Attendance::STATUS_SAKIT,
                Attendance::STATUS_ALFA,
                Attendance::STATUS_PULANG,
            ])->default(Attendance::STATUS_ALFA)->index();
            $table->text('note')->nullable();
            $table->timestamp('attendance_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'attendance_date', 'period'], 'attendances_user_date_period_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

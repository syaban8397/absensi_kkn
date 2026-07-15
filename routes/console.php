<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('attendances:generate-daily')->dailyAt('00:01')->timezone('Asia/Jakarta');

<?php

namespace App\Http\Controllers\Admin;

use App\Exports\AttendanceReportExport;
use App\Http\Controllers\Controller;
use App\Services\AttendanceGeneratorService;
use App\Services\AttendanceReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function index(Request $request, AttendanceGeneratorService $generator, AttendanceReportService $reportService): View
    {
        $generator->ensureTodayIsGenerated();

        $date = $request->query('date', today()->toDateString());

        return view('reports.index', [
            'date' => $date,
            'rows' => $reportService->summary($date),
        ]);
    }

    public function pdf(Request $request, AttendanceGeneratorService $generator, AttendanceReportService $reportService): Response
    {
        $generator->ensureTodayIsGenerated();

        $date = $request->query('date', today()->toDateString());
        $rows = $reportService->summary($date);

        $pdf = Pdf::loadView('reports.pdf', [
            'date' => $date,
            'rows' => $rows,
        ])->setPaper('a4', 'landscape');

        return $pdf->download('laporan-absensi-kkn-'.$date.'.pdf');
    }

    public function excel(Request $request, AttendanceGeneratorService $generator, AttendanceReportService $reportService): BinaryFileResponse
    {
        $generator->ensureTodayIsGenerated();

        $date = $request->query('date', today()->toDateString());
        $rows = $reportService->summary($date);

        return Excel::download(new AttendanceReportExport($rows), 'laporan-absensi-kkn-'.$date.'.xlsx');
    }
}

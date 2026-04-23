<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exports\LoginHistoryExport;
use App\Http\Controllers\Controller;
use App\Jobs\Excel\GenerateLoginHistoryExcelJob as ExcelGenerateLoginHistoryExcelJob;
use App\Jobs\Pdf\GenerateLoginHistoryPdfJob as PdfGenerateLoginHistoryPdfJob;
use App\Models\LoginHistory;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ManageLoginHistoryController extends Controller
{
    public function index()
    {
        return view('backend.general_pages.login_history');
    }

    public function export(Request $request)
{
    $format    = $request->get('format', 'excel');
    $sort      = in_array($request->sort, ['login_time', 'ip_address', 'email', 'name']) ? $request->sort : 'login_time';
    $direction = in_array($request->direction, ['asc', 'desc']) ? $request->direction : 'desc';

    $query = LoginHistory::with('user')
        ->when(!empty($request->search), function ($query) use ($request) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                })->orWhere('ip_address', 'like', "%{$search}%");
            });
        })
        ->when(!empty($request->date_from), function ($query) use ($request) {
            $query->whereDate('login_time', '>=', $request->date_from);
        })
        ->when(!empty($request->date_to), function ($query) use ($request) {
            $query->whereDate('login_time', '<=', $request->date_to);
        })
        ->when(!empty($request->device_type), function ($query) use ($request) {
            $deviceType = $request->device_type;
            $query->where(function ($q) use ($deviceType) {
                switch ($deviceType) {
                    case 'mobile':
                        $q->where('user_agent', 'like', '%Mobile%')
                            ->orWhere('user_agent', 'like', '%Android%')
                            ->orWhere('user_agent', 'like', '%iPhone%');
                        break;
                    case 'tablet':
                        $q->where('user_agent', 'like', '%iPad%')
                            ->orWhere('user_agent', 'like', '%Tablet%');
                        break;
                    case 'desktop':
                        $q->where('user_agent', 'not like', '%Mobile%')
                            ->where('user_agent', 'not like', '%Android%')
                            ->where('user_agent', 'not like', '%iPhone%')
                            ->where('user_agent', 'not like', '%iPad%')
                            ->where('user_agent', 'not like', '%Tablet%');
                        break;
                }
            });
        })
        ->when(in_array($sort, ['email', 'name']), function ($query) use ($sort, $direction) {
            $query->join('users', 'login_histories.user_id', '=', 'users.id')
                ->select('login_histories.*')
                ->orderBy("users.{$sort}", $direction);
        }, function ($query) use ($sort, $direction) {
            $query->orderBy($sort, $direction);
        });

    $total = $query->count();

    if ($format === 'pdf') {

        if ($total >= 500) {
            
            PdfGenerateLoginHistoryPdfJob::dispatch(
                auth()->user(),
                $request->only(['search', 'date_from', 'date_to', 'device_type', 'sort', 'direction'])
            );

            return back()->with('success', 'Your PDF is being generated. You will be notified when it is ready.');
        }

        $logins = $query->get();

        $pdf = Pdf::loadView('backend.users.pdf_login_history', [
            'logins'       => $logins,
            'filters'      => $request->only(['search', 'date_from', 'date_to', 'device_type']),
            'generatedAt'  => now(),
            'totalRecords' => $logins->count(),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);

        return $pdf->download('login_history_' . date('Y_m_d') . '.pdf');
    }

    // Default: Excel
    $fileName = 'login_history_report_' . now()->format('Y_m_d_His') . '.xlsx';

    if ($total >= 500) {
        $filePath = 'excels/' . $fileName;

        Excel::queue(
            new LoginHistoryExport(
                $request->only(['search', 'date_from', 'date_to', 'device_type', 'sort', 'direction']),
                $request->from_date,
                $request->to_date
            ),
            $filePath,
            'public'
        )->chain([
            new ExcelGenerateLoginHistoryExcelJob(auth()->user()->email, $filePath)
        ]);

        return back()->with('success', 'Your Excel file is being generated. You will be notified when it is ready.');
    }

    return Excel::download(
        new LoginHistoryExport($query->get(), $request->from_date, $request->to_date),
        $fileName
    );
    }
}

<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exports\ExportLoginHistory;
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

    public function exportPdf(Request $request)
    {
        $query = LoginHistory::with('user');

        if (!empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                })->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if (!empty($request->date_from)) {
            $query->whereDate('login_time', '>=', $request->date_from);
        }

        if (!empty($request->date_to)) {
            $query->whereDate('login_time', '<=', $request->date_to);
        }

        if (!empty($request->device_type)) {
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
        }

        $allowedSorts = ['login_time', 'ip_address', 'email', 'name'];
        if (!in_array($request->sort, $allowedSorts)) {
            $request->sort = 'login_time';
        }

        if (!in_array($request->direction, ['asc', 'desc'])) {
            $request->direction = 'desc'; // as  default
        }

        if (in_array($request->sort, ['email', 'name'])) {
            $query->join('users', 'login_histories.user_id', '=', 'users.id')
                ->select('login_histories.*')
                ->orderBy("users.{$request->sort}", $request->direction);
        } else {
            $query->orderBy($request->sort, $request->direction);
        }

        $total = $query->count();

        if ($total < 500) {

            $logins = $query->get();

            $pdf = Pdf::loadView('backend.users.pdf_login_history', [
                'logins' => $logins,
                'filters' => $request->only(['search', 'date_from', 'date_fo', 'device_type']),
                'generatedAt' => now(),
                'totalRecords' => $logins->count()
            ]);
            $pdf->setPaper('A4', 'portrait');
            $pdf->setOption('isHtml5ParserEnabled', true);

            $filename = 'login_history_' . date('Y_m_d_') . '.pdf';

            return $pdf->download($filename);
        } else {

            $filters = $request->only(['search', 'date_from', 'date_to', 'device_type', 'sort', 'direction']);

            PdfGenerateLoginHistoryPdfJob::dispatch(auth()->user(), $filters);

            return back()->with('success', 'Your PDF is being generated. You will be notified when it is ready.');
        }
    }

    public function exportExcel(Request $request)
    {

        $query = LoginHistory::with('user');

        if (!empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                })->orWhere('ip_address', 'like', "%{$search}%");
            });
        }


        if (!empty($request->date_from)) {
            $query->whereDate('login_time', '>=', $request->date_from);
        }

        if (!empty($request->date_to)) {
            $query->whereDate('login_time', '<=', $request->date_to);
        }

        if (!empty($request->device_type)) {
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
        }

        // Sorting
        $allowedSorts = ['login_time', 'ip_address', 'email', 'name'];
        if (!in_array($request->sort, $allowedSorts)) {
            $request->sort = 'login_time';
        }

        if (!in_array($request->direction, ['asc', 'desc'])) {
            $request->direction = 'desc'; // as default
        }

        if (in_array($request->sort, ['email', 'name'])) {
            $query->join('users', 'login_histories.user_id', '=', 'users.id')
                ->select('login_histories.*')
                ->orderBy("users.{$request->sort}", $request->direction);
        } else {
            $query->orderBy($request->sort, $request->direction);
        }


        $total = $query->count();


        if ($total < 500) {

            $logins = $query->get();

            return Excel::download(
                new ExportLoginHistory($logins, $request->from_date, $request->to_date),
                'login_history_report_' . now()->format('Y_m_d_His') . '.xlsx'
            );
        } else {

            $user = auth()->user();
            $filters = $request->only(['search', 'date_from', 'date_to', 'device_type', 'sort', 'direction']);
            $fileName = 'login_history_report_' . now()->format('Y_m_d_His') . '.xlsx';
            $filePath = 'excels/' . $fileName;

            Excel::queue(new ExportLoginHistory($filters, $request->from_date, $request->to_date), $filePath, 'public')
                ->chain([
                    new ExcelGenerateLoginHistoryExcelJob($user->email, $filePath)
                ]);


            return back()->with('success', 'Your Excel file is being generated. You will be notified when it is ready.');
        }
    }
}

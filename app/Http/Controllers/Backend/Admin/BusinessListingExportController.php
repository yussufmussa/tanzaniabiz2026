<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Exports\BusinessListingExport;
use App\Http\Controllers\Controller;
use App\Models\Business\BusinessListing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BusinessListingExportController extends Controller
{
    public function export(Request $request)
    {
        $format = $request->get('format', 'excel');

        $listings = BusinessListing::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%');
            })
            ->when($request->statusFilter && $request->statusFilter !== 'all', function ($query) use ($request) {
                $query->where('status', $request->statusFilter === 'active' ? 1 : 0);
            })
            ->orderBy('name', 'asc')
            ->with(['category', 'city', 'user'])
            ->get();

        if ($format === 'pdf') {
            $generatedAt = now();
            $totalRecords = $listings->count();

            $pdf = Pdf::loadView('backend.business.export_to_pdf',compact('listings', 'generatedAt', 'totalRecords')
            );

            return $pdf->download('business_listings_' . date('Y_m_d') . '.pdf');
        }

        return Excel::download(new BusinessListingExport($listings),'business_listings_' . date('Y_m_d') . '.xlsx');
    }
}

<?php

namespace App\Jobs\Pdf;

use App\Mail\Pdf\PdfIsReadyMail;
use App\Models\LoginHistory;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GenerateLoginHistoryPdfJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $filters;

    public function __construct($user, array $filters = [])
    {
        $this->user    = $user;
        // Normalize and validate early in the constructor,
        // so the stored filters are always safe
        $this->filters = array_merge([
            'search'      => null,
            'date_from'   => null,
            'date_to'     => null,
            'device_type' => null,
            'sort'        => 'login_time',
            'direction'   => 'desc',
        ], $filters);

        // Whitelist sort & direction here so the stored payload is safe
        if (!in_array($this->filters['sort'], ['login_time', 'ip_address', 'email', 'name'])) {
            $this->filters['sort'] = 'login_time';
        }

        if (!in_array($this->filters['direction'], ['asc', 'desc'])) {
            $this->filters['direction'] = 'desc';
        }
    }

    public function handle(): void
    {
        $query = LoginHistory::with('user');

        if (!empty($this->filters['search'])) {
            $search = $this->filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($sub) use ($search) {
                    $sub->where('email', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%");
                })->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('login_time', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('login_time', '<=', $this->filters['date_to']);
        }

        if (!empty($this->filters['device_type'])) {
            $deviceType = $this->filters['device_type'];
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

        if (in_array($this->filters['sort'], ['email', 'name'])) {
            $query->join('users', 'login_histories.user_id', '=', 'users.id')
                ->select('login_histories.*')
                ->orderBy("users.{$this->filters['sort']}", $this->filters['direction']);
        } else {
            $query->orderBy($this->filters['sort'], $this->filters['direction']);
        }

        $logins = $query->get();

        $pdf = Pdf::loadView('backend.users.pdf_login_history', [
            'logins'       => $logins,
            'filters'      => Arr::only($this->filters, ['search', 'date_from', 'date_to', 'device_type']),
            'generatedAt'  => now(),
            'totalRecords' => $logins->count(),
        ]);
        $pdf->setPaper('A4', 'portrait');
        $pdf->setOption('isHtml5ParserEnabled', true);

        $filename = 'login_history_' . now()->format('Y_m_d_His') . '.pdf';
        $filePath = 'pdfs/' . $filename;

        Storage::disk('public')->put($filePath, $pdf->output());

        try {
            Mail::to($this->user->email)->send(new PdfIsReadyMail($filePath));
        } catch (\Throwable $th) {
            Log::error('PDF ready email failed to send: ' . $th->getMessage());
        }
    }
}

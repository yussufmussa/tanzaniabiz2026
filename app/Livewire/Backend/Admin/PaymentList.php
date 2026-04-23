<?php

namespace App\Livewire\Backend\Admin;

use App\Models\Order;
use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use BeyondCode\QueryDetector\Outputs\Log;
use Illuminate\Support\Facades\Log as FacadesLog;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filters
    public $search = '';
    public $paymentStatusFilter = 'all';
    public $paymentMethodFilter = 'all';
    public $currencyFilter = 'all';
    public $amountRange = 'all';
    public $from_date = '';
    public $to_date = '';

    public $selectedPayment = null;
    public $showDetailModal = false;


    protected $queryString = [
        'search' => ['except' => ''],
        'paymentStatusFilter' => ['except' => 'all'],
        'paymentMethodFilter' => ['except' => 'all'],
        'currencyFilter' => ['except' => 'all'],
    ];



    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function resetFilters()
    {
        $this->search = '';
        $this->paymentStatusFilter = 'all';
        $this->paymentMethodFilter = 'all';
        $this->currencyFilter = 'all';
        $this->amountRange = 'all';
        $this->from_date = '';
        $this->to_date = '';
        $this->resetPage();
    }

    public function setQuickFilter($days){
        $today = now();

        $fromDate = $today->copy()->subDays($days)->format('Y-m-d');

        $this->from_date = $fromDate;
        $this->to_date = $today->format('Y-m-d');

    }

    public function viewOrder($paymentId)
    {

        // FacadesLog::info('order_id commng from blade' . $paymentId);

        // $orderId = Payment::where('order_id', $paymentId)->first();

        // FacadesLog::info('order_id ' . $orderId->id);

        return dd($this->selectedPayment = Order::with([
            'user',
            'shippingAddress',
            'shippingZone',
            'orderItem.product',
        ])->findOrFail($paymentId));

        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedPayment = null;
    }

    public function generateReceipt($paymentId)
    {
        $payment = Payment::with(['user',  'order'])->findOrFail($paymentId);

        if ($payment->payment_status !== 'Completed') {

            $this->dispatch('StatusUpdated', [
                'type' => 'error',
                'message' => 'Payment Receipt can only be generated for completed payments.'
            ]);

            return;
        }
        

        $pdf = Pdf::loadView('backend.admin.payments.receipt', compact('payment'));

        // $pdf->setPaper([0, 0, 226.76, 600], 'portrait'); 
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'DejaVu Sans'); 
        $pdf->setOption('enable_remote', true); 

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'receipt_' . $payment->payment_reference . '.pdf');
    }

    private function getFilteredPayments()
    {
        $query = Payment::with(['user', 'order']);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('payment_reference', 'like', '%' . $this->search . '%')
                    ->orWhereHas('order', function ($orderQuery) {
                        $orderQuery->where('order_number', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('user', function ($userQuery) {
                        $userQuery->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            });
        }

        if ($this->paymentStatusFilter !== 'all') {
            $query->where('payment_status', $this->paymentStatusFilter);
        }

        if ($this->paymentMethodFilter !== 'all') {
            $query->where('payment_method', $this->paymentMethodFilter);
        }

        if ($this->currencyFilter !== 'all') {
            $query->where('currency', $this->currencyFilter);
        }

        if ($this->amountRange !== 'all') {
            switch ($this->amountRange) {
                case '0-10000':
                    $query->whereBetween('amount', [0, 10000]);
                    break;
                case '10000-50000':
                    $query->whereBetween('amount', [10000, 50000]);
                    break;
                case '50000-100000':
                    $query->whereBetween('amount', [50000, 100000]);
                    break;
                case '100000+':
                    $query->where('amount', '>=', 100000);
                    break;
            }
        }

        if ($this->from_date) {
            $query->whereDate('created_at', '>=', $this->from_date);
        }

        if ($this->to_date) {
            $query->whereDate('created_at', '<=', $this->to_date);
        }

        return $query->latest();
    }

    public function render()
    {
        $payments = $this->getFilteredPayments()->paginate(15);

        $totalPayments = Payment::count();
        
        $successfulAmount = Payment::where('payment_status', 'Completed')
                                ->sum('amount');
        
        $pendingAmount = Payment::where('payment_status', 'Pending')
                        ->orWhere('payment_status',null)
                            ->sum('amount');
        
        $failedAmount = Payment::where('payment_status', 'Failed')->sum('amount');

        $currency = Payment::selectRaw('currency, COUNT(*) as count')
            ->groupBy('currency')
            ->orderByDesc('count')
            ->first()
            ->currency;

        $filteredTotal = $this->getFilteredPayments()->sum('amount');

        return view('livewire.backend.admin.payment-list', [
            'payments' => $payments,
            'totalPayments' => $totalPayments,
            'successfulAmount' => $successfulAmount,
            'pendingAmount' => $pendingAmount,
            'failedAmount' => $failedAmount,
            'currency' => $currency,
            'filteredTotal' => $filteredTotal,
        ]);
    }
}

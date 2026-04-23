<?php

namespace App\Livewire\Backend\Admin;

use App\Mail\SendOrderUpdate;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use Livewire\WithPagination;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class OrderList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $paymentStatusFilter = 'all';
    public $dateFilter = 'all';
    public $from_date = null;
    public $to_date = null;
    public $perPage = 10;

    // For viewing order details
    public $selectedOrder = null;
    public $showDetailModal = false;

    // For editing order
    public $editingOrderId = null;
    public $status = '';
    public $payment_status = '';
    public $payment_method = '';
    public $notes = '';

    protected $queryString = ['search', 'statusFilter', 'paymentStatusFilter'];

    protected $rules = [
        'status' => 'required|in:pending,processing,shipped,delivered',
        'payment_status' => 'required|in:pending,paid,failed',
        'payment_method' => 'nullable|string',
        'notes' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPaymentStatusFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
       
         $this->reset([
            'search',
            'statusFilter',
            'paymentStatusFilter',
            'from_date',
            'to_date',
        ]);

        $this->resetPage();
    }

    public function viewOrder($orderId)
    {
        $this->selectedOrder = Order::with([
            'user',
            'shippingAddress',
            'shippingZone',
            'orderItem.product',
        ])->findOrFail($orderId);

        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedOrder = null;
    }

    public function editOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        $this->editingOrderId = $orderId;
        $this->status = $order->status;
        $this->payment_status = $order->payment_status;
        $this->payment_method = $order->payment_method;
        $this->notes = $order->notes;
    }

    public function updateOrder()
    {
        $this->validate();

        $order = Order::findOrFail($this->editingOrderId);

        $order->update([
            'status' => $this->status,
            'payment_status' => $this->payment_status,
            'notes' => $this->notes,
        ]);

        try {
            
            Mail::to($order->user->email)->send(new SendOrderUpdate($order));

        } catch (\Throwable $th) {

            Log::info('there was an error sending order update email' .$th->getMessage());
        
        }

        $this->cancelEdit();

        $this->dispatch('StatusUpdated', [
            'type' => 'success',
            'message' => 'Order updated successfully.'
        ]);
        

    }

    public function setQuickFilter($days){

        $today = now();

        $fromDate = $today->copy()->subDays($days)->format('Y-m-d');

        $this->from_date = $fromDate;
        $this->to_date = $today->format('Y-m-d');

    }

    public function cancelEdit()
    {
        $this->editingOrderId = null;
        $this->reset(['status', 'payment_status', 'payment_method', 'notes']);
    }

    public function deleteOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        $order->delete();

        $this->dispatch('StatusUpdated', [
            'type' => 'success',
            'message' => 'Order is cancelled.'
        ]);
    }

    public function generateShippingLabel($orderId)
    {
        $order = Order::with(['user', 'shippingAddress'])->findOrFail($orderId);

        $pdf = Pdf::loadView('backend.admin.orders.shipping_label', compact('order'));

        $pdf->setPaper([0, 0, 288, 432], 'portrait');

        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'defaultFont' => 'Arial',
            'dpi' => 96,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'shipping_label_' . $order->order_number . '.pdf');
    }

    public function generateInvoice($orderId)
    {
        $order = Order::with(['user', 'shippingAddress', 'orderItem.product'])->findOrFail($orderId);

        $pdf = Pdf::loadView('backend.admin.orders.invoice', compact('order'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice_' . $order->order_number . '.pdf');
    }

    public function generateReceipt($orderId)
    {
        $order = Order::with(['user', 'shippingAddress', 'orderItem.product'])->findOrFail($orderId);

        if ($order->payment_status !== 'paid') {

            $this->dispatch('StatusUpdated', [
                'type' => 'error',
                'message' => 'Order Receipt can only be generated for paid orders.'
            ]);

            return;
        }

        $verifyUrl = route('order.verify', $order->order_number);
        

        $pdf = Pdf::loadView('backend.admin.orders.receipt', compact('order', 'verifyUrl'));

        $pdf->setPaper([0, 0, 226.76, 600], 'portrait'); 
        $pdf->setOption('isRemoteEnabled', true);
        $pdf->setOption('defaultFont', 'DejaVu Sans'); 
        $pdf->setOption('enable_remote', true); 

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'receipt_' . $order->order_number . '.pdf');
    }

    public function render()
    {
        $orders = Order::with(['user', 'shippingAddress', 'orderItem'])
            ->when($this->search, function ($query) {
                $query->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->when($this->paymentStatusFilter !== 'all', function ($query) {
                $query->where('payment_status', $this->paymentStatusFilter);
            })
            ->when(filled($this->from_date), function ($query) {
               $query->where('created_at', '>=', $this->from_date);
            })
            ->when(filled($this->to_date), function ($query) {
               $query->where('created_at', '<=', $this->to_date);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.backend.admin.order-list', [
            'orders' => $orders,
        ]);
    }
}

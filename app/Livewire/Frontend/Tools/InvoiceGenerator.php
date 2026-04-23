<?php

namespace App\Livewire\Frontend\Tools;

use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;


class InvoiceGenerator extends Component
{
    use WithFileUploads;

    public $currency = 'TZS'; // only 3 currencies

    public $invoice = [
        'number' => '',
        'date' => '',
        'due_date' => '',
        'payment_terms' => '',
    ];

    // Single textbox blocks (like your screenshot)
    public $from_text = '';
    public $bill_to_text = '';
    public $ship_to_text = '';

    public $payment_details = '';
    public $terms = '';

    public $items = [];

    public $discount_type = 'off'; // off|percent|flat
    public $discount_value = 0;

    public $tax_type = 'off'; // off|percent|flat
    public $tax_value = 0;

    public $amount_paid = 0;

    public ?TemporaryUploadedFile $logo = null;
    public ?string $logo_preview_data_url = null; // base64 preview (optional)


    public function mount()
    {
        $today = now()->toDateString();
        $this->invoice['date'] = $today;
        $this->invoice['due_date'] = $today;

        $this->items = [$this->blankItem()];

        // optional: preload sample placeholders
        // $this->from_text = "Your Business Name\n+255 ...\nemail@...\nAddress...";
    }

    private function blankItem(): array
    {
        return [
            'description' => '',
            'qty' => 1,
            'unit_price' => 0,
        ];
    }

    public function addItem(): void
    {
        $this->items[] = $this->blankItem();
    }

    public function removeItem(int $index): void
    {
        if (count($this->items) <= 1) {
            $this->items[0] = $this->blankItem();
            return;
        }
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function rules(): array
    {
        return [
            'currency' => ['required', Rule::in(['TZS', 'USD', 'EUR'])],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2MB

            'invoice.number' => ['nullable', 'string', 'max:50'],
            'invoice.date' => ['required', 'date'],
            'invoice.due_date' => ['required', 'date', 'after_or_equal:invoice.date'],
            'invoice.payment_terms' => ['nullable', 'string', 'max:2000'],

            'from_text' => ['required', 'string', 'max:2000'],
            'bill_to_text' => ['required', 'string', 'max:2000'],
            'ship_to_text' => ['nullable', 'string', 'max:2000'],

            'payment_details' => ['nullable', 'string', 'max:2000'],
            'terms' => ['nullable', 'string', 'max:2000'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.description' => ['required', 'string', 'max:250'],
            'items.*.qty' => ['required', 'numeric', 'min:0'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],

            'discount_type' => ['required', Rule::in(['off', 'percent', 'flat'])],
            'discount_value' => ['required', 'numeric', 'min:0'],

            'tax_type' => ['required', Rule::in(['off', 'percent', 'flat'])],
            'tax_value' => ['required', 'numeric', 'min:0'],


            'amount_paid' => ['required', 'numeric', 'min:0'],
        ];
    }

    private function n($v): float
    {
        return ($v === '' || $v === null) ? 0.0 : (float)$v;
    }

    public function getSubtotalProperty(): float
    {
        $sum = 0.0;
        foreach ($this->items as $it) {
            $sum += $this->n($it['qty'] ?? 0) * $this->n($it['unit_price'] ?? 0);
        }
        return max(0.0, $sum);
    }

    public function getDiscountAmountProperty(): float
    {
        $sub = $this->subtotal;
        $v = $this->n($this->discount_value);

        return match ($this->discount_type) {
            'percent' => max(0.0, min($sub, $sub * ($v / 100))),
            'flat' => max(0.0, min($sub, $v)),
            default => 0.0,
        };
    }

    public function getTaxableBaseProperty(): float
    {
        return max(0.0, $this->subtotal - $this->discountAmount);
    }

    public function getTaxAmountProperty(): float
    {
        $base = $this->taxableBase;
        $v = $this->n($this->tax_value);

        return match ($this->tax_type) {
            'percent' => max(0.0, $base * ($v / 100)),
            'flat' => max(0.0, $v),
            default => 0.0,
        };
    }


    public function getTotalProperty(): float
    {
        return max(0.0, $this->taxableBase + $this->taxAmount);
    }

    public function getBalanceDueProperty(): float
    {
        return max(0.0, $this->total - max(0.0, $this->n($this->amount_paid)));
    }

    /**
     * If opened with ?load=<id> we ask browser to load that invoice from localStorage
     */
    public function loadFromQuery(?string $id): void
    {
        if (!$id) return;
        $this->dispatch('invoice-request-load', id: $id);
    }

    public function loadFromDevice(array $payload): void
    {
        if (!in_array(($payload['currency'] ?? ''), ['TZS', 'USD', 'EUR'], true)) return;

        $this->currency = $payload['currency'] ?? 'TZS';
        $this->invoice = $payload['invoice'] ?? $this->invoice;

        $this->from_text = $payload['from_text'] ?? '';
        $this->bill_to_text = $payload['bill_to_text'] ?? '';
        $this->ship_to_text = $payload['ship_to_text'] ?? '';

        $this->payment_details = $payload['payment_details'] ?? '';
        $this->terms = $payload['terms'] ?? '';

        $this->items = $payload['items'] ?? [$this->blankItem()];

        $this->discount_type = $payload['discount_type'] ?? 'off';
        $this->discount_value = $payload['discount_value'] ?? 0;

        $this->tax_type = $payload['tax_type'] ?? 'off';
        $this->tax_value = $payload['tax_value'] ?? 0;


        $this->amount_paid = $payload['amount_paid'] ?? 0;
    }

    public function updatedLogo(): void
    {
        $this->validateOnly('logo');

        if ($this->logo) {
            // preview without storing
            $this->logo_preview_data_url = $this->logo->temporaryUrl();
        } else {
            $this->logo_preview_data_url = null;
        }
    }


    public function saveAndPrepareDownload(): void
    {
        $this->validate();

        $logoDataUrl = null;

        $payload = [
            'id' => now()->format('YmdHis') . '-' . substr(bin2hex(random_bytes(6)), 0, 12),
            'saved_at' => now()->toISOString(),

            'currency' => $this->currency,
            'invoice' => $this->invoice,

            'logo_data_url' => $logoDataUrl,

            'from_text' => $this->from_text,
            'bill_to_text' => $this->bill_to_text,
            'ship_to_text' => $this->ship_to_text,

            'payment_details' => $this->payment_details,
            'terms' => $this->terms,

            'items' => $this->items,

            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'tax_type' => $this->tax_type,
            'tax_value' => $this->tax_value,
            'amount_paid' => $this->amount_paid,
        ];


      if ($this->logo) {
    $mime = $this->logo->getMimeType();
    $bytes = file_get_contents($this->logo->getRealPath());
    $logoDataUrl = 'data:' . $mime . ';base64,' . base64_encode($bytes);
}

        $this->dispatch('invoice-save-and-download', payload: $payload);
    }


    public function render()
    {
        return view('livewire.frontend.tools.invoice-generator');
    }
}

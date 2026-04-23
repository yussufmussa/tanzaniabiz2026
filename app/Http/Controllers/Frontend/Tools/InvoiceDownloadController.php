<?php

namespace App\Http\Controllers\Frontend\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class InvoiceDownloadController extends Controller
{

    public function  index()  {

        return view('frontend.tools.index');
        
    }
    public function __invoke(Request $request)
{
    // Validate payload coming from hidden form (JSON string)
    $data = $request->validate([
        'payload' => ['required', 'string', 'max:200000'],
    ], [
        'payload.required' => 'Something went wrong. Please try again.',
        'payload.string'   => 'Invalid invoice data.',
        'payload.max'      => 'Invoice is too large. Remove some items and try again.',
    ]);

    $payload = json_decode($data['payload'], true);

    if (!is_array($payload)) {
        abort(422, 'Invalid invoice payload.');
    }

    // Custom readable messages
    $messages = [
        'currency.required' => 'Select a currency.',
        'currency.in'       => 'Currency must be TZS, USD, or EUR.',

        'invoice.date.required' => 'Invoice date is required.',
        'invoice.date.date'     => 'Invoice date must be a valid date.',
        'invoice.due_date.required' => 'Due date is required.',
        'invoice.due_date.date'     => 'Due date must be a valid date.',
        'invoice.due_date.after_or_equal' => 'Due date must be the same as or after the invoice date.',

        'from_text.required' => 'The "From" box is required.',
        'bill_to_text.required' => 'The "Bill To" box is required.',

        'items.required' => 'Add at least one line item.',
        'items.array'    => 'Line items are invalid.',
        'items.min'      => 'Add at least one line item.',

        'items.*.description.required' => 'Each line item must have a description.',
        'items.*.qty.required'         => 'Each line item must have a quantity.',
        'items.*.qty.numeric'          => 'Quantity must be a number.',
        'items.*.qty.min'              => 'Quantity cannot be negative.',
        'items.*.unit_price.required'  => 'Each line item must have a rate.',
        'items.*.unit_price.numeric'   => 'Rate must be a number.',
        'items.*.unit_price.min'       => 'Rate cannot be negative.',

        'discount_type.in' => 'Discount type is invalid.',
        'discount_value.numeric' => 'Discount value must be a number.',
        'discount_value.min'     => 'Discount cannot be negative.',

        'tax_type.in' => 'Tax type is invalid.',
        'tax_value.numeric' => 'Tax value must be a number.',
        'tax_value.min'     => 'Tax cannot be negative.',

        'shipping_type.in' => 'Shipping type is invalid.',
        'shipping_value.numeric' => 'Shipping must be a number.',
        'shipping_value.min'     => 'Shipping cannot be negative.',

        'amount_paid.numeric' => 'Amount paid must be a number.',
        'amount_paid.min'     => 'Amount paid cannot be negative.',
    ];

    // Server-side validation for the NEW shape
    $validator = Validator::make($payload, [
        'currency' => ['required', 'in:TZS,USD,EUR'],

        'logo_data_url' => ['nullable', 'string', 'max:3000000'], // allow base64

        'invoice' => ['required', 'array'],
        'invoice.number' => ['nullable', 'string', 'max:50'],
        'invoice.date' => ['required', 'date'],
        'invoice.due_date' => ['required', 'date', 'after_or_equal:invoice.date'],
        'invoice.payment_terms' => ['nullable', 'string', 'max:2000'],
        'invoice.po_number' => ['nullable', 'string', 'max:50'],

        'from_text' => ['required', 'string', 'max:2000'],
        'bill_to_text' => ['required', 'string', 'max:2000'],
        'ship_to_text' => ['nullable', 'string', 'max:2000'],

        'payment_details' => ['nullable', 'string', 'max:2000'],
        'terms' => ['nullable', 'string', 'max:2000'],

        'items' => ['required', 'array', 'min:1'],
        'items.*.description' => ['required', 'string', 'max:250'],
        'items.*.qty' => ['required', 'numeric', 'min:0'],
        'items.*.unit_price' => ['required', 'numeric', 'min:0'],

        'discount_type' => ['required', 'in:off,percent,flat'],
        'discount_value' => ['required', 'numeric', 'min:0'],

        'tax_type' => ['required', 'in:off,percent,flat'],
        'tax_value' => ['required', 'numeric', 'min:0'],

        'shipping_type' => ['required', 'in:off,flat'],
        'shipping_value' => ['required', 'numeric', 'min:0'],

        'amount_paid' => ['required', 'numeric', 'min:0'],
    ], $messages);

    if ($validator->fails()) {
        // Make errors readable and useful
        $readable = collect($validator->errors()->messages())
            ->map(function ($msgs, $key) {
                // Convert items.0.qty -> Item 1 qty
                if (preg_match('/^items\.(\d+)\.(.+)$/', $key, $m)) {
                    $index = (int)$m[1] + 1;
                    $field = str_replace('_', ' ', $m[2]);
                    return array_map(fn($msg) => "Item {$index} {$field}: {$msg}", $msgs);
                }
                return $msgs;
            })
            ->flatten()
            ->values()
            ->all();

        // If this was posted by JS/fetch you get JSON; for normal post you can show a simple page
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Please fix the highlighted fields.',
                'errors' => $validator->errors(),
                'readable_errors' => $readable,
            ], 422);
        }

        return back()->withErrors($validator)->withInput();
    }

    // Safe math helpers
    $n = fn($v) => ($v === '' || $v === null) ? 0.0 : (float)$v;

    $subtotal = 0.0;
    foreach ($payload['items'] as $it) {
        $subtotal += $n($it['qty']) * $n($it['unit_price']);
    }
    $subtotal = max(0.0, $subtotal);

    $discountAmount = 0.0;
    $dv = $n(Arr::get($payload, 'discount_value', 0));
    $dt = Arr::get($payload, 'discount_type', 'off');
    if ($dt === 'percent') $discountAmount = min($subtotal, $subtotal * ($dv / 100));
    if ($dt === 'flat') $discountAmount = min($subtotal, $dv);
    $discountAmount = max(0.0, $discountAmount);

    $taxableBase = max(0.0, $subtotal - $discountAmount);

    $taxAmount = 0.0;
    $tv = $n(Arr::get($payload, 'tax_value', 0));
    $tt = Arr::get($payload, 'tax_type', 'off');
    if ($tt === 'percent') $taxAmount = $taxableBase * ($tv / 100);
    if ($tt === 'flat') $taxAmount = $tv;
    $taxAmount = max(0.0, $taxAmount);

    $shippingAmount = 0.0;
    $sv = $n(Arr::get($payload, 'shipping_value', 0));
    $st = Arr::get($payload, 'shipping_type', 'off');
    if ($st === 'flat') $shippingAmount = $sv;
    $shippingAmount = max(0.0, $shippingAmount);

    $total = max(0.0, $taxableBase + $taxAmount + $shippingAmount);

    $paid = max(0.0, $n(Arr::get($payload, 'amount_paid', 0)));
    $balanceDue = max(0.0, $total - $paid);

    $viewData = [
        'currency' => $payload['currency'],
        'invoice' => $payload['invoice'],

        'logo_data_url' => $payload['logo_data_url'] ?? null,

        'from_text' => $payload['from_text'],
        'bill_to_text' => $payload['bill_to_text'],
        'ship_to_text' => $payload['ship_to_text'] ?? '',

        'payment_details' => $payload['payment_details'] ?? '',
        'terms' => $payload['terms'] ?? '',

        'items' => $payload['items'],

        'discountAmount' => $discountAmount,
        'taxAmount' => $taxAmount,
        'shippingAmount' => $shippingAmount,
        'subtotal' => $subtotal,
        'total' => $total,
        'amount_paid' => $paid,
        'balance_due' => $balanceDue,
    ];

    $fileName = 'invoice-' . (Arr::get($payload, 'invoice.number') ?: now()->format('Ymd-His')) . '.pdf';

    // Update to your new PDF view path
    $pdf = app('dompdf.wrapper')->loadView('frontend.tools.invoice_pdf', $viewData);

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->output();
    }, $fileName);
}

}

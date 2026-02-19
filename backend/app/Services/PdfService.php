<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class PdfService
{
    public function generateInvoice(Invoice $invoice): Response
    {
        $pdf = Pdf::loadView('pdf.invoice', [
            'invoice' => $invoice,
            'order' => $invoice->order,
            'user' => $invoice->user,
        ]);

        $filename = "invoice_{$invoice->invoice_number}.pdf";

        return $pdf->download($filename);
    }

    public function generateMou(Order $order): Response
    {
        $pdf = Pdf::loadView('pdf.mou', [
            'order' => $order,
            'user' => $order->user,
        ]);

        $filename = "mou_{$order->order_number}.pdf";

        return $pdf->download($filename);
    }
}

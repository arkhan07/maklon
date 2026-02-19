<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Services\PdfService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(private PdfService $pdfService) {}

    public function index(Request $request): JsonResponse
    {
        $invoices = $request->user()
            ->invoices()
            ->with(['order.product'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15);

        return response()->json($invoices);
    }

    public function show(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);

        $invoice->load(['order.product', 'order.legalItems', 'order.orderMaterials.material', 'payments']);

        return response()->json(['invoice' => new InvoiceResource($invoice)]);
    }

    public function download(Request $request, Invoice $invoice)
    {
        $this->authorize('view', $invoice);

        $invoice->load(['order.product', 'order.user.profile', 'order.legalItems', 'order.orderMaterials.material']);

        return $this->pdfService->generateInvoice($invoice);
    }
}

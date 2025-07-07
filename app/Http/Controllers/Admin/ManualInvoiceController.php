<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManualInvoiceController extends Controller
{
    public function index()
    {
        $invoices = \App\Models\ManualInvoice::with('items')->orderByDesc('created_at')->get();
        return view('admin.manual_invoice.index', compact('invoices'));
    }

    public function create()
    {
        return view('admin.manual_invoice.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'user_name' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $total = 0;
        foreach ($validated['items'] as $item) {
            $total += ($item['quantity'] * $item['price']);
        }

        $invoice = \App\Models\ManualInvoice::create([
            'user_name' => $validated['user_name'],
            'alamat' => $validated['alamat'],
            'telepon' => $validated['telepon'],
            'tanggal' => $validated['tanggal'],
            'total' => $total,
        ]);

        foreach ($validated['items'] as $item) {
            $invoice->items()->create([
                'product_name' => $item['product_name'],
                'variant' => $item['variant'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['quantity'] * $item['price'],
            ]);
        }

        return redirect()->route('admin.manual-invoice.index')
            ->with('success', 'Invoice manual berhasil disimpan.');
    }

    public function show($id)
    {
        // Dummy detail
        return 'Detail invoice manual ID: ' . $id;
    }

    public function download($id)
    {
        $invoice = \App\Models\ManualInvoice::with('items')->findOrFail($id);
        // Mapping data agar sesuai dengan template invoice-pdf.blade.php
        $order = (object) [
            'order_number' => 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT),
            'created_at' => \Carbon\Carbon::parse($invoice->tanggal),
            'user_name' => $invoice->user_name,
            'alamat' => $invoice->alamat,
            'telepon' => $invoice->telepon,
            'total' => $invoice->total,
            'items' => $invoice->items->map(function($item) {
                return (object) [
                    'product_name' => $item->product_name,
                    'variant_info' => $item->variant ? [['type' => 'Varian', 'name' => $item->variant]] : [],
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                ];
            }),
            // Dummy status agar template tidak error
            'payment_status' => 'paid',
            'status' => 'completed',
        ];
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('ecatalog.invoice-pdf', compact('order'));
        return $pdf->download('invoice-manual-'.$order->order_number.'.pdf');
    }

    public function destroy($id)
    {
        $invoice = \App\Models\ManualInvoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('admin.manual-invoice.index')->with('success', 'Invoice manual berhasil dihapus.');
    }
} 
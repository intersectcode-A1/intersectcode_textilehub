<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryLog;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InventoryLogController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryLog::with(['product', 'user']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                  ->orWhereHas('product', function($productQuery) use ($search) {
                      $productQuery->where('nama', 'like', '%' . $search . '%');
                  });
            });
        }

        // Filter by product
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by reference type
        if ($request->filled('reference_type')) {
            $query->where('reference_type', $request->reference_type);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        
        // Validate sort field
        $allowedSortFields = ['created_at', 'type', 'quantity', 'stock_before', 'stock_after'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'created_at';
        }
        
        // Validate sort order
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }
        
        $query->orderBy($sortField, $sortOrder);

        $perPage = $request->get('per_page', 20);
        $logs = $query->paginate($perPage)->withQueryString();

        // Get summary data
        $summary = $this->getSummary($request);
        
        // Get products for filter dropdown
        $products = Product::orderBy('nama')->get();

        return view('admin.inventory_logs.index', compact('logs', 'summary', 'products'));
    }

    public function show($id)
    {
        $log = InventoryLog::with(['product', 'user'])->findOrFail($id);
        return view('admin.inventory_logs.show', compact('log'));
    }

    public function create()
    {
        $products = Product::orderBy('nama')->get();
        return view('admin.inventory_logs.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'reference_type' => 'nullable|string|max:50',
            'reference_id' => 'nullable|integer'
        ]);

        try {
            if ($request->type === 'in') {
                InventoryLog::logIncoming(
                    $request->product_id,
                    $request->quantity,
                    $request->description,
                    $request->reference_type,
                    $request->reference_id,
                    null
                );
            } else {
                InventoryLog::logOutgoing(
                    $request->product_id,
                    $request->quantity,
                    $request->description,
                    $request->reference_type,
                    $request->reference_id,
                    null
                );
            }

            return redirect()->route('inventory-logs.index')->with('success', 'Log inventory berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $log = InventoryLog::with('product')->findOrFail($id);
        $products = Product::orderBy('nama')->get();
        return view('admin.inventory_logs.edit', compact('log', 'products'));
    }

    public function update(Request $request, $id)
    {
        $log = InventoryLog::findOrFail($id);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
            'reference_type' => 'nullable|string|max:50',
            'reference_id' => 'nullable|integer'
        ]);

        // Hitung stok sebelum dan sesudah
        $product = Product::findOrFail($request->product_id);
        $stockBefore = $log->stock_before;
        $stockAfter = $stockBefore;
        if ($request->type === 'in') {
            $stockAfter = $stockBefore + ($request->quantity - $log->quantity);
        } else {
            $stockAfter = $stockBefore - ($request->quantity - $log->quantity);
        }

        $log->update([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'description' => $request->description,
            'reference_type' => $request->reference_type,
            'reference_id' => $request->reference_id,
        ]);

        return redirect()->route('inventory-logs.index')->with('success', 'Log inventory berhasil diperbarui.');
    }

    public function export(Request $request)
    {
        $query = InventoryLog::with(['product', 'user']);

        // Apply filters
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=inventory_logs.csv',
        ];

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'Tanggal',
                'Produk',
                'Tipe',
                'Jumlah',
                'Stok Sebelum',
                'Stok Sesudah',
                'Keterangan',
                'Referensi',
                'User'
            ]);

            // Add data rows
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->created_at->format('d/m/Y H:i'),
                    $log->product->nama ?? 'Produk tidak ditemukan',
                    $log->type_label,
                    $log->formatted_quantity,
                    $log->stock_before,
                    $log->stock_after,
                    $log->description ?? $log->reference_description,
                    $log->reference_type . ($log->reference_id ? ' #' . $log->reference_id : ''),
                    $log->user->name ?? 'System'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id)
    {
        $log = InventoryLog::findOrFail($id);
        $log->delete();
        return redirect()->route('inventory-logs.index')->with('success', 'Log inventory berhasil dihapus.');
    }

    private function getSummary(Request $request)
    {
        $query = InventoryLog::query();

        // Apply same filters as main query
        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('reference_type')) {
            $query->where('reference_type', $request->reference_type);
        }

        $incoming = $query->clone()->where('type', 'in')->sum('quantity');
        $outgoing = $query->clone()->where('type', 'out')->sum('quantity');
        $totalTransactions = $query->clone()->count();

        return [
            'incoming' => $incoming,
            'outgoing' => $outgoing,
            'net_change' => $incoming - $outgoing,
            'total_transactions' => $totalTransactions
        ];
    }
} 
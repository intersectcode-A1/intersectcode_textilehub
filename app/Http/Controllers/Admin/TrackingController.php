<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $trackings = Tracking::with('histories')->get();
        return view('admin.tracking.index', compact('trackings'));
    }

    public function search(Request $request)
    {
        $tracking = Tracking::where('resi', $request->resi)->with('histories')->first();

        if (!$tracking) {
            return back()->with('error', 'Nomor resi tidak ditemukan.');
        }

        return view('admin.tracking.show', compact('tracking'));
    }
}

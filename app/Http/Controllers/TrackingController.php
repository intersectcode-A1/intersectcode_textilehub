<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use App\Models\TrackingHistory;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $trackings = Tracking::with('histories')->get();
        return view('tracking.index', compact('trackings'));
    }

    public function search(Request $request)
    {
        $tracking = Tracking::where('resi', $request->resi)->with('histories')->first();

        if (!$tracking) {
            return back()->with('error', 'Nomor resi tidak ditemukan.');
        }

        return view('tracking.show', compact('tracking'));
    }
}

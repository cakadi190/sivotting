<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman beranda
     *
     * @return void
     */
    public function index()
    {
        # Set Date
        $now = now();
        $month = $now->month;
        $nextYear = $now->year + 1;
        $lastYear = $now->year - 1;

        if($month >= 8) {
            $period = "{$now->year}/{$nextYear}";
        } else {
            $period = "{$lastYear}/{$now->year}";
        }

        # Parse
        return view('welcome', compact('period'));
    }

    public function vote(Candidate $query)
    {
        # Get Query
        $data = $query->get();
        $candidate = $data->groupBy('period');

        # Set Date
        $now = now();
        $month = $now->month;
        $nextYear = $now->year + 1;
        $lastYear = $now->year - 1;

        if($month >= 8) {
            $period = "{$now->year}/{$nextYear}";
        } else {
            $period = "{$lastYear}/{$now->year}";
        }

        # Parse
        return view('vote', compact('candidate', 'period'));
    }

    /**
     * Action to add votting
     *
     * @return void
     */
    public function votting($id, Vote $query, Request $request)
    {
        try {
            $data = collect([]);
            $data->put('ip_address', $request->ip);
            $data->put('candidate', $id);
            $query->create($data->toArray());

            # Set Date
            $now = now();
            $month = $now->month;
            $nextYear = $now->year + 1;
            $lastYear = $now->year - 1;

            if($month >= 8) {
                $period = "{$now->year}/{$nextYear}";
            } else {
                $period = "{$lastYear}/{$now->year}";
            }

            return view('success', compact('period'));
        } catch (\Exception $e) {
            return back()->with('danger', 'Maaf, sistem sedang bermasalah! Coba lagi beberapa saat. Kesalahannya adalah: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;

class ElectronResultController extends Controller
{
    /**
     * Resulting the election data
     *
     * @return void
     */
    public function __invoke()
    {
        # Get Data Candidate
        $data = Candidate::get();
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

        # Return view
        return view('admin.result', compact('candidate', 'period'));
    }
}

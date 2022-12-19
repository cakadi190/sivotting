<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CandidateManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Candidate $query)
    {
        # Get Data
        $query = $query->select('id', 'name', 'photo', 'period');
        $query = $query->get();
        $query = $query->groupBy('period');

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

        # Parse it
        return view('admin.candidate.index', compact('period', 'query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.candidate.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Candidate $query)
    {
        # Validate first
        $request->validate([
            'name'    => 'required|max:255',
            'photo'   => 'required|file|max:2048|mimes:jpg,png,jpeg',
            'vision'  => 'required|max:750',
            'mission' => 'required|max:750',
        ]);

        # If Passed
        $bag = collect($request->except('_token', 'photo'));

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

        $bag->put('period', $period);

        # Handle upload
        if($request->file('photo')){
            $file      = $request->file('photo');
            $filename  = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $bag->put('photo', $filename);
        }

        # Add to database
        try {
            $query->create($bag->toArray());
            return redirect()->route('admin.candidate.index')->with('success', 'Berhasil menambahkan data kandidat');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal menambahkan data kandidat. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Candidate $query)
    {
        # Check and validate
        $data = $query->find($id);
        if(!$data) return redirect()->route('admin.candidate.index')->with('warning', 'Maaf, kelas tidak dapat ditemukan!');

        # if passed
        return view('admin.candidate.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Candidate $query)
    {
        # Check and validate
        $data = $query->find($id);
        if(!$data) return redirect()->route('admin.candidate.index')->with('warning', 'Maaf, kelas tidak dapat ditemukan!');

        # if passed
        return view('admin.candidate.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Candidate $query)
    {
        # Validate first
        $request->validate([
            'name'    => 'required|max:255',
            'photo'   => 'file|max:2048|mimes:jpg,png,jpeg',
            'vision'  => 'required|max:750',
            'mission' => 'required|max:750',
        ]);

        # If Passed
        $bag   = collect($request->except('_token', 'photo'));
        $model = $query->find($id);

        # Handle upload
        if($request->file('photo')) {
            $photo = public_path("image/{$model->photo}");

            if(File::exists($photo)) {
                File::delete($photo);
            }

            $file      = $request->file('photo');
            $filename  = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('image'), $filename);
            $bag->put('photo', $filename);
        }

        # Add to database
        try {
            $model->update($bag->toArray());
            return redirect()->route('admin.candidate.index')->with('success', 'Berhasil menambahkan data kandidat');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal menambahkan data kandidat. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Candidate $query)
    {
        if(!$id) return redirect()->route('admin.candidate.index')->with('warning', 'Anda harus menyertakan ID!');

        try {
            $model = $query->find($id);
            $photo = public_path("image/{$model->photo}");

            if(File::exists($photo)) {
                File::delete($photo);
            }

            $model->delete();
            return redirect()->route('admin.candidate.index')->with('success', 'Berhasil menghapus data kandidat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal menghapus data kandidat. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }
}

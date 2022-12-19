<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Classroom $query)
    {
        # Get all data
        $query = $query->all();

        # Parse to view
        return view('admin.classroom.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.classroom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Classroom $query)
    {
        $request->validate([
            'classname' => 'required|max:255'
        ]);

        $enable = filter_var($request->enable, FILTER_VALIDATE_BOOLEAN);
        $bag = collect($request->only('classname'))->put('enable', $enable);

        try {
            $query->create($bag->toArray());
            return redirect()->route('admin.classroom.index')->with('success', 'Berhasil menambahkan data kelas');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal menambahkan data kelas. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('admin.classroom.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Classroom $query)
    {
        # Check and validate
        $data = $query->find($id);
        if(!$data) return redirect()->route('admin.classroom.index')->with('warning', 'Maaf, kelas tidak dapat ditemukan!');

        # if passed
        return view('admin.classroom.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Classroom $query)
    {
        $request->validate([
            'classname' => 'required|max:255'
        ]);

        $enable = filter_var($request->enable, FILTER_VALIDATE_BOOLEAN);
        $bag = collect($request->only('classname'))->put('enable', $enable);

        try {
            $model = $query->find($id);
            $model->update($bag->toArray());
            return redirect()->route('admin.classroom.index')->with('success', 'Berhasil memperbaharui data kelas');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal memperbaharui data kelas. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Classroom $query)
    {
        if(!$id) return redirect()->route('admin.classroom.index')->with('warning', 'Anda harus menyertakan ID!');

        try {
            $query->find($id)->delete();
            return redirect()->route('admin.classroom.index')->with('success', 'Berhasil menghapus data kelas!');
        } catch (\Exception $e) {
            return redirect()->route('admin.classroom.index')->with('warning', "Gagal menghapus data kelas. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }

    /**
     * Truncating Voter Data - Menghapus semua rekaman pemilih.
     *
     * @param Classroom $query Model binding kelas
     * @return void
     */
    public function truncating(Classroom $query)
    {
        # Find Voter
        $search = $query->get();

        # if found, let's delete
        if($search->count() >= 0) {
            $query->truncate();
            return redirect()->route('admin.classroom.index')->with('success', 'Berhasil menghapus semua data pemilih.');
        }

        # Return nothing if not found
        return redirect()->route('admin.classroom.index')->with('warning', 'Tidak ada yang perlu dihapus.');
    }
}

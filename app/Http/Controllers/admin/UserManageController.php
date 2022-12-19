<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class UserManageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $query)
    {
        # Getting all users
        $query = $query->select('id', 'name', 'classroom', 'email', 'gender', 'updated_at', 'role');
        $query = $query->get();
        $query = $query->groupBy('role');

        return view('admin.user.index', compact('query'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        # Get Classroom Data
        $class = Classroom::where('enable', true)->get();

        # Return view
        return view('admin.user.create', compact('class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $query)
    {
        $request->validate([
            'role'      => 'required|in:admin,voter',
            'id'        => 'required_if:role,voter|max:10',
            'email'     => 'required_if:role,admin',
            'name'      => 'required|max:255',
            'classroom' => 'required_if:role,voter',
            'gender'    => 'required_if:role,voter|in:l,p'
        ]);

        $bag = collect($request->except('_token'));

        if($request->role == 'admin') {
            $bag->put('email', $request->email);
            $bag->put('password', bcrypt($request->password));
        } else {
            $bag->put('email', '');
            $bag->put('password', '');
        }

        # Add to database
        try {
            $query->create($bag->toArray());
            return redirect()->route('admin.user.index')->with('success', 'Berhasil menambahkan data pengguna');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal menambahkan data pengguna. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
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
        return redirect()->route('admin.user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, User $query)
    {
        # Check and validate
        $user = $query->find($id);
        if(!$user) return redirect()->route('admin.user.index')->with('warning', 'Maaf, pemilih / pengelola tidak dapat ditemukan!');

        # If is passed
        # Get Classroom Data
        $class = Classroom::where('enable', true)->get();
        return view('admin.user.edit', compact('user', 'class', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, User $query)
    {
        $request->validate([
            'id'        => 'required_if:role,voter|max:10',
            'email'     => 'required_if:role,admin',
            'name'      => 'required|max:255',
            'classroom' => 'required_if:role,voter',
            'gender'    => 'required_if:role,voter|in:l,p'
        ]);

        $bag = collect($request->except('_token'));

        if($request->role == 'admin') {
            $bag->put('email', $request->email);
            if($request->password) $bag->put('password', bcrypt($request->password));
        }

        try {
            $model = $query->find($id);
            $model->update($bag->toArray());
            return redirect()->route('admin.user.index')->with('success', 'Berhasil memperbaharui data pengguna');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal memperbaharui data pengguna. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, User $query)
    {
        if(!$id) return redirect()->route('admin.user.index')->with('warning', 'Anda harus menyertakan ID!');

        try {
            $query->find($id)->delete();
            return redirect()->route('admin.user.index')->with('success', 'Berhasil menghapus data pengguna!');
        } catch (\Exception $e) {
            return redirect()->back()->with('warning', "Gagal menghapus data pengguna. Ada kesalahan seperti ini \"{$e->getMessage()}\".");
        }
    }

    /**
     * Truncating Voter Data - Menghapus semua rekaman pemilih.
     *
     * @param User $query Model binding pengguna
     * @return void
     */
    public function truncating(User $query)
    {
        # Find Voter
        $search = $query->where('role', 'voter');

        # if found, let's delete
        if($search->count() >= 0) {
            $search->delete();
            return redirect()->route('admin.user.index')->with('success', 'Berhasil menghapus semua data pemilih.');
        }

        # Return nothing if not found
        return redirect()->route('admin.user.index')->with('warning', 'Tidak ada yang perlu dihapus.');
    }
}

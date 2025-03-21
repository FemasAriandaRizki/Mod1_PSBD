<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class AdminController extends Controller
{
    public function create()
    {
        return view('admin.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
        ]);

        // Gunakan '123' jika password tidak diisi
        $password = $request->password ? $request->password : '123';

        DB::insert(
            'INSERT INTO admin(id_admin,nama_admin, alamat, username, password) VALUES (:id_admin, :nama_admin, :alamat, :username, :password)',
            [
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $password,
            ]
        );
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil disimpan');
    }

    // public function show all values from a table
    // public function index()
    // {
    //     $datas = DB::select('select * from admin WHERE deleted_at IS NULL ORDER BY id_admin ASC');
    //     // $datas = Admin::all();
    //     // $datas = Admin::whereNull('deleted_at')->orderBy('nama_admin', 'asc')->get();
    //     // $datas = Admin::onlyTrashed()->get(); // Mengambil data yang sudah dihapus
    //     // $datas = Admin::withTrashed()->get(); // Mengambil semua data (termasuk yang sudah dihapus)
    //     return view('admin.index')->with('datas', $datas);
    // }

    public function index(Request $request)
    {
        $query = DB::table('admin')->whereNull('deleted_at');

        if ($request->has('search')) {
            $query->where('nama_admin', 'like', '%' . $request->search . '%');
        }

        $datas = $query->orderBy('id_admin', 'ASC')->get();

        return view('admin.index', compact('datas'));
    }

    // public function edit a row from a table
    public function edit($id)
    {
        $data = DB::table('admin')->where('id_admin', $id)->first();
        return view('admin.edit')->with('data', $data);
    }

    // public function to update the table value
    public function update($id, Request $request)
    {
        $request->validate([
            'id_admin' => 'required',
            'nama_admin' => 'required',
            'alamat' => 'required',
            'username' => 'required',
        ]);

        // Ambil password lama jika tidak diisi
        $admin = DB::table('admin')->where('id_admin', $id)->first();
        $password = $request->password ? $request->password : ($admin->password ?? '123');

        DB::update(
            'UPDATE admin SET id_admin = :id_admin, nama_admin =
    :nama_admin, alamat = :alamat, username = :username, password =
    :password WHERE id_admin = :id',
            [
                'id' => $id,
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $password,
            ]
        );
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil diubah');
    }

    public function delete($id)
    {
        // DB::delete('DELETE FROM admin WHERE id_admin = :id_admin', ['id_admin' => $id]);
        Admin::where('id_admin', $id)->delete(); // Soft delete: hanya mengisi kolom deleted_at
        return redirect()->route('admin.index')->with('success', 'Data Admin berhasil dihapus');
    }

    public function trash()
    {
        $datas = Admin::onlyTrashed()->orderBy('deleted_at', 'asc')->get();
        return view('admin.trash', compact('datas'));
    }

    public function restore($id)
    {
        Admin::onlyTrashed()->where('id_admin', $id)->restore();
        return redirect()->route('admin.trash')->with('success', 'Data berhasil dikembalikan');
    }

    public function forceDelete($id)
    {
        Admin::onlyTrashed()->where('id_admin', $id)->forceDelete();
        return redirect()->route('admin.trash')->with('success', 'Data berhasil dihapus permanen');
    }

    public function restoreAll()
    {
        Admin::onlyTrashed()->restore();
        return redirect()->route('admin.trash')->with('success', 'Semua data berhasil dikembalikan');
    }
}

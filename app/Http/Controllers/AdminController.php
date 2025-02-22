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
            'password' => 'required',
            'nomor_telepon' => 'required|numeric',
        ]);
        DB::insert(
            'INSERT INTO admin(id_admin,nama_admin, alamat, username, password, nomor_telepon) VALUES (:id_admin, :nama_admin, :alamat, :username, :password, :nomor_telepon)',
            [
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
                'nomor_telepon' => $request->nomor_telepon,
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
            'password' => 'required',
            'nomor_telepon' => 'required|numeric',
        ]);
        DB::update(
            'UPDATE admin SET id_admin = :id_admin, nama_admin =
    :nama_admin, alamat = :alamat, username = :username, password =
    :password, nomor_telepon = :nomor_telepon WHERE id_admin = :id',
            [
                'id' => $id,
                'id_admin' => $request->id_admin,
                'nama_admin' => $request->nama_admin,
                'alamat' => $request->alamat,
                'username' => $request->username,
                'password' => $request->password,
                'nomor_telepon' => $request->nomor_telepon,
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
}

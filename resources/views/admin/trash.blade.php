@extends('admin.layout') @section('content')
<div class="card mt-4">
    <div class="card-body">
        <h5 class="card-title fw-bolder mb-3">Trash (Data Terhapus)</h5>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Admin</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>Username</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                <tr>
                    <td>{{ $data->id_admin }}</td>
                    <td>{{ $data->nama_admin }}</td>
                    <td>{{ $data->alamat }}</td>
                    <td>{{ $data->username }}</td>
                    <td>{{ $data->nomor_telepon }}</td>
                    <td>
                        <form
                            action="{{ route('admin.restore', $data->id_admin) }}"
                            method="POST"
                            style="display: inline"
                        >
                            @csrf
                            <button
                                type="submit"
                                class="btn btn-warning btn-sm"
                            >
                                Restore
                            </button>
                        </form>
                        <form
                            action="{{ route('admin.forceDelete', $data->id_admin) }}"
                            method="POST"
                            style="display: inline"
                            onsubmit="return confirm('Yakin ingin menghapus permanen?');"
                        >
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">
                                Hapus Permanen
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('admin.index') }}" class="btn btn-primary mt-3"
            >Kembali</a
        >
    </div>
</div>
@endsection

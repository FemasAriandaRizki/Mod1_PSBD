@extends('admin.layout') @section('content')
<h4 class="mt-5 mb-3">Data Sampah</h4>

<button
    type="button"
    class="btn btn-success"
    data-bs-toggle="modal"
    data-bs-target="#restoreAllModal"
>
    Pulihkan Semua Data
</button>

<div class="modal fade" id="restoreAllModal" tabindex="-1" aria-labelledby="restoreAllModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="restoreAllModalLabel">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.restoreAll') }}" method="POST">
                @csrf
                <div class="modal-body">
                    Apakah anda yakin ingin memulihkan semua data yang terhapus?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Ya</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif

<table class="table table-hover mt-3">
    <thead>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Username</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $data)
        <tr>
            <td>{{ $data->id_admin }}</td>
            <td>{{ $data->nama_admin }}</td>
            <td>{{ $data->alamat }}</td>
            <td>{{ $data->username }}</td>
            <td>
                <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#restoreModal{{ $data->id_admin }}"
                >
                    Pulihkan
                </button>

                <!-- Modal -->
                <div
                    class="modal fade"
                    id="restoreModal{{ $data->id_admin }}"
                    tabindex="-1"
                    aria-labelledby="restoreModalLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="restoreModalLabel">
                                    Konfirmasi
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <form
                                method="POST"
                                action="{{ route('admin.restore', $data->id_admin) }}"
                            >
                                @csrf
                                <div class="modal-body">
                                    Apakah anda yakin ingin memulihkan data ini?
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Tutup
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Ya
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <button
                    type="button"
                    class="btn btn-danger"
                    data-bs-toggle="modal"
                    data-bs-target="#hapusModal{{ $data->id_admin }}"
                >
                    Hapus Permanen
                </button>

                <!-- Modal -->
                <div
                    class="modal fade"
                    id="hapusModal{{ $data->id_admin }}"
                    tabindex="-1"
                    aria-labelledby="hapusModalLabel"
                    aria-hidden="true"
                >
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="hapusModalLabel">
                                    Konfirmasi
                                </h5>
                                <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal"
                                    aria-label="Close"
                                ></button>
                            </div>
                            <form
                                method="POST"
                                action="{{ route('admin.forceDelete', $data->id_admin) }}"
                            >
                                @csrf
                                <div class="modal-body">
                                    Apakah anda yakin ingin menghapus permanen data ini?
                                </div>
                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary"
                                        data-bs-dismiss="modal"
                                    >
                                        Tutup
                                    </button>
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                    >
                                        Ya
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('admin.index') }}" class="btn btn-primary mt-2">Kembali</a>

@endsection

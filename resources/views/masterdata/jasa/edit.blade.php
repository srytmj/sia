@extends('layout')

@section('content')
    <!-- [ Main Content ] start -->
    <section class="pcoded-main-container">
        <div class="pcoded-content">
            <!-- [ breadcrumb ] start -->
            <div class="page-header">
                <div class="page-block">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="page-header-title">
                                <h5 class="m-b-10">Edit Data Role</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('jasa.index') }}"><i
                                            class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Edit Role</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                <!-- Edit Role Form start -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Edit Jasa: {{ $jasa->nama }}</h5>
                        </div>
                        <div class="card-body">
                            <form id="editRoleForm" action="{{ route('jasa.update', $jasa->id_jasa) }}" method="POST">
                                @csrf
                                @method('PUT')
                                {{-- nama --}}
                                <div class="form-group">
                                    <label for="nama">Nama Jasa:</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama', $jasa->nama) }}" required>
                                </div>
                                {{-- harga --}}
                                <div class="form-group">
                                    <label for="nama">Harga :</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama', $jasa->harga) }}" required>
                                </div>

                                {{-- detail --}}
                                <div class="form-group">
                                    <label for="nama">Detail :</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        value="{{ old('nama', $jasa->detail) }}" required>
                                </div>

                                <!-- Add other jasa fields here -->
                                <div class="text-right"> <!-- Align "Update Role" button to the right -->
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Edit Role Form end -->

                <!-- DataTable for User Access Menu start -->
                <div class="col-sm-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Jasa Detail</h5>
                            <div class="card-header-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addmodal">Tambah
                                    Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="userAccessMenuTable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Id detail</th>
                                            <th>Barang</th>
                                            <th>Kuantitas</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            {{-- @foreach ($barang as $option)
                                                <th value="{{ $option->id_barang }}">{{ $option->barang }}</th>
                                            @endforeach --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jasa_detail as $item)
                                            <tr>
                                                <td>{{ $item->id_jasa_detail }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->kuantitas . ' ' . $item->satuan }}</td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button type="button" class="btn btn-warning edit-button"
                                                        data-toggle="modal" data-target="#editmodal"
                                                        data-table="jasa_detail" data-id="{{ $item->id_jasa_detail }}">
                                                        Edit
                                                    </button>
                                                </td>
                                                <td>
                                                    <!-- Tombol Delete -->
                                                    <button type="button" class="btn btn-danger delete-button"
                                                        data-toggle="modal" data-target="#deletemodal"
                                                        data-table="jasa_detail" data-id="{{ $item->id_jasa_detail }}">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-right mt-3"> <!-- Align "Kembali" button to the right -->
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DataTable for User Access Menu end -->

            </div>
        </div>
    </section>

    @include('masterdata/jasa/detail/modal')

    @include('masterdata/jasa/detail/edit')

    @include('masterdata/jasa/detail/delete')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

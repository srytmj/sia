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
                                <li class="breadcrumb-item"><a href="{{ route('pembelian.index') }}"><i
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
                            <h5>Detail Pembelian : </h5>
                        </div>
                        <div class="card-body">
                            <form id="editRoleForm" action="{{ route('pembelian.update', $pembelian->id_pembelian) }}" method="POST">
                                @csrf
                                @method('PUT')
                                {{-- perusahaan kalo dia admin --}}
                                @if (auth()->user()->id === 1)
                                    <div class="form-group">
                                        <label for="id_perusahaan">Perusahaan:</label>
                                        <select class="form-control" id="id_perusahaan" name="id_perusahaan" required>
                                            <option value="" selected hidden>Select Perusahaan</option>
                                            @foreach ($perusahaans as $option)
                                                <option value="{{ $option->id_perusahaan }}"
                                                    {{ $option->id_perusahaan == $pembelian->id_perusahaan ? 'selected' : '' }}>
                                                    {{ $option->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <input type="hidden" name="id_perusahaan" value="{{ auth()->user()->id_perusahaan }}">
                                @endif

                                <input type="text" value="{{$pembelian->id_pembelian}}" hidden>

                                {{-- Supplier --}}
                                <div class="form-group">
                                    <label for="id_supplier">Supplier :</label>
                                    <select class="form-control" id="id_supplier" name="id_supplier" required>
                                        <option value="" selected hidden>Select Perusahaan</option>
                                        @foreach ($suppliers as $option)
                                            <option value="{{ $option->id_supplier }}" {{ $option->id_supplier == $pembelian->id_supplier ? 'selected' : '' }}>{{ $option->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Add other pembelian fields here -->
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
                                            <th>harga satuan</th>
                                            <th>subtotal</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                            {{-- @foreach ($barang as $option)
                                                <th value="{{ $option->id_barang }}">{{ $option->barang }}</th>
                                            @endforeach --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pembelian_detail as $item)
                                            <tr>
                                                <td>{{ $item->id_pembelian_detail }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->kuantitas }}</td>
                                                <td>{{ $item->harga }}</td>
                                                <td>{{ $item->subtotal }}</td>
                                                <td>
                                                    <!-- Tombol Edit -->
                                                    <button type="button" class="btn btn-warning edit-button"
                                                        data-toggle="modal" data-target="#editmodal"
                                                        data-table="pembelian_detail" data-id="{{ $item->id_pembelian_detail }}">
                                                        Edit
                                                    </button>
                                                </td>
                                                <td>
                                                    <!-- Tombol Delete -->
                                                    <button type="button" class="btn btn-danger delete-button"
                                                        data-toggle="modal" data-target="#deletemodal"
                                                        data-table="pembelian_detail" data-id="{{ $item->id_pembelian_detail }}">
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

    {{-- @include('transaksi/pembelian/detail/modal') --}}

    {{-- @include('transaksi/pembelian/detail/edit') --}}

    @include('transaksi/pembelian/detail/delete')

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection

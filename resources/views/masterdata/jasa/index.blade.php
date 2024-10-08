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
                                <h5 class="m-b-10">Data from Table: {{ ucfirst($table) }}</h5>
                            </div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="#!">Data Table</a></li>
                                <li class="breadcrumb-item"><a href="#!">Basic Initialization</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ breadcrumb ] end -->

            <!-- [ Main Content ] start -->
            <div class="row">
                
                <!-- DataTable for User Access Menu start -->
                <div class="col-sm-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data {{ ucfirst($table) }}</h5>
                            <div class="card-header-right">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#addmodal">Tambah Data</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="userAccessMenuTable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nama Jasa</th>
                                            <th>detail</th>
                                            <th>harga</th>
                                            @if (auth()->user()->id === 1)
                                                <th>Perusahaan</th>
                                            @endif
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jasas as $item)
                                        <tr>
                                            <td>{{ $item->id_jasa }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ $item->detail }}</td>
                                            <td>{{ $item->harga }}</td>
                                            @if (auth()->user()->id === 1)
                                                <td>{{ $item->nama_perusahaan }}</td>
                                            @endif
                                            <td>
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('jasa.edit', $item->id_jasa) }}" class="btn btn-warning">
                                                    Detail
                                                </a>
                                            </td>
                                            <td>
                                                <!-- Tombol Delete -->
                                                <button type="button" class="btn btn-danger delete-button"
                                                    data-toggle="modal" data-target="#deletemodal"
                                                    data-table="{{ $table }}" data-id="{{ $item->id_jasa }}">
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
    <!-- [ Main Content ] end -->

    @include('masterdata/' . $table . '/modal')

    @include('masterdata/' . $table . '/delete')

@endsection

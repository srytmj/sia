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
                            <form id="editRoleForm" action="{{ route('pembelian.update', $pembelian->id_pembelian) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="text" value="{{ $pembelian->id_pembelian }}" hidden>

                                {{-- perusahaan kalo dia admin --}}
                                @if (auth()->user()->id === 1)
                                    <!-- Adjust condition as needed -->
                                    @if ($pembelian->status !== 'pending')
                                        <input type="hidden"
                                            name="id_perusahaan"value="{{ auth()->user()->id_perusahaan }}">
                                        <label for="id_perusahaan">Perusahaan:</label>
                                        <select class="form-control" id="id_perusahaan" name="id_perusahaan" required
                                            disabled>
                                            <option value="" selected hidden>Select Perusahaan</option>
                                            @foreach ($perusahaans as $option)
                                                <option value="{{ $option->id_perusahaan }}"
                                                    {{ $option->id_perusahaan == $pembelian->id_perusahaan ? 'selected' : '' }}>
                                                    {{ $option->id_perusahaan }}. {{ $option->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <div class="form-group">
                                            <label for="id_perusahaan">Perusahaan:</label>
                                            <select class="form-control" id="id_perusahaan" name="id_perusahaan" required>
                                                <option value="" selected hidden>Select Perusahaan</option>
                                                @foreach ($perusahaans as $option)
                                                    <option value="{{ $option->id_perusahaan }}"
                                                        {{ $option->id_perusahaan == $pembelian->id_perusahaan ? 'selected' : '' }}>
                                                        {{ $option->id_perusahaan }}. {{ $option->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                @else
                                @endif

                                {{-- Supplier --}}
                                <div class="form-group">
                                    <label for="id_supplier">Supplier :</label>
                                    @if ($pembelian->status !== 'pending')
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="supplier_name"
                                                value="{{ $pembelian->nama_supplier }}" readonly>
                                        </div>
                                    @else
                                        <!-- Adjust condition as needed -->
                                        <select class="form-control" id="id_supplier" name="id_supplier" required>
                                            <option value="" selected hidden>Select Supplier</option>
                                            @foreach ($suppliers->groupBy('id_perusahaan') as $id_perusahaan => $supplierGroup)
                                                <optgroup label="Perusahaan ID: {{ $id_perusahaan }}">
                                                    @foreach ($supplierGroup as $supplier)
                                                        <option value="{{ $supplier->id_supplier }}"
                                                            {{ $supplier->id_supplier == $pembelian->id_supplier ? 'selected' : '' }}>
                                                            {{ $supplier->nama }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                @if ($pembelian->status == 'belum lunas')
                                    <!-- Adjust condition as needed -->
                                    <div class="form-group">
                                        <label for="kredit">Belum Dibayar:</label>
                                        <input type="text" class="form-control" id="kredit"
                                            value="{{ rupiah($pembelian->kredit) }}" readonly>
                                    </div>
                                @endif

                                <!-- Save Data button -->
                                @if ($pembelian->status == 'pending')
                                    <!-- Adjust condition as needed -->
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                @endif
                            </form>
                            @if ($pembelian->status == 'belum lunas')
                                <form id="pelunasanForm"
                                    {{-- action="{{ route('pembeliandetail.pelunasan', $pembelian->id_pembelian) }}" --}}
                                    method="POST" style="display:inline;">
                                    @csrf
                                    <input type="text" name="id_pembelian" value="{{ $pembelian->id_pembelian }}"required>
                                    <input type="text" name="kredit" value="{{ $pembelian->kredit }}" required>
                                    <!-- Ensure this value is set -->

                                    <button id="pelunasanButton" type="submit" class="btn btn-success">Lunas</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Edit Role Form end -->

                <!-- DataTable for Jasa Detail start -->
                <div class="col-sm-12 mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h5>Data Detail Pembelian</h5>
                            @if ($pembelian->status == 'pending')
                                <!-- Adjust condition as needed -->
                                <div class="card-header-right">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#addmodal">Tambah Data</button>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <div class="dt-responsive table-responsive">
                                <table id="userAccessMenuTable" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Barang</th>
                                            <th>Kuantitas</th>
                                            <th>Harga Satuan</th>
                                            <th>Subtotal</th>
                                            @if ($pembelian->status == 'pending')
                                                <!-- Adjust condition as needed -->
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach ($pembeliandetails as $item)
                                            @php
                                                $total += $item->subtotal;
                                            @endphp
                                            <tr>
                                                {{-- <td>{{ $item->id_pembelian_detail }}</td> --}}
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->kuantitas }}</td>
                                                <td>{{ rupiah($item->harga) }}</td>
                                                <td>{{ rupiah($item->subtotal) }}</td>
                                                @if ($pembelian->status == 'pending')
                                                    <!-- Adjust condition as needed -->
                                                    <td>
                                                        <!-- Edit Button -->
                                                        <button type="button" class="btn btn-warning edit-button"
                                                            data-toggle="modal" data-target="#editmodal"
                                                            data-table="pembelian_detail"
                                                            data-id="{{ $item->id_pembelian_detail }}">
                                                            Edit
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <!-- Delete Button -->
                                                        <button type="button" class="btn btn-danger delete-button"
                                                            data-toggle="modal" data-target="#deletemodal"
                                                            data-table="pembelian_detail"
                                                            data-id="{{ $item->id_pembelian_detail }}">
                                                            Delete
                                                        </button>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                            <td><strong>{{ rupiah($total, 2) }}</strong></td>
                                            @if ($pembelian->status == 'pending')
                                                <!-- Adjust condition as needed -->
                                                <td colspan="2"></td>
                                            @endif
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DataTable for Jasa Detail end -->

                {{-- Payment method --}}
                {{-- @if ($pembelian->status !== 'lunas' && $pembelian->status !== 'belum lunas') --}}

                <div class="col-sm-12 mt-4">
                    @if ($pembelian->status !== 'lunas' && $pembelian->status !== 'belum lunas')
                        <div class="card">
                            <div class="card-body">
                                <form id="saveForm" method="POST" action="/transaksi/pembeliandetaildetail">
                                    @csrf
                                    <input type="hidden" name="id_pembelian" value="{{ $pembelian->id_pembelian }}">
                                    <input type="hidden" name="id_supplier" value="{{ $pembelian->id_supplier }}">
                                    <input type="hidden" name="id_perusahaan" value="{{ $pembelian->id_perusahaan }}">

                                    <!-- Payment Options -->
                                    <div class="form-group">
                                        <label for="payment_option">Jenis Pembayaran:</label>
                                        <select class="form-control" id="payment_option" name="payment_option" required>
                                            <option value="" selected hidden>Select Payment Option</option>
                                            <option value="tunai" {{ $payment_option == 'tunai' ? 'selected' : '' }}>
                                                Tunai
                                            </option>
                                            <option value="kredit" {{ $payment_option == 'kredit' ? 'selected' : '' }}>
                                                Kredit
                                            </option>
                                        </select>
                                    </div>

                                    <!-- Total Value (hidden) -->
                                    <input type="text" id="total" name="total" value="{{ $total }}">

                                    <div id="credit_fields" style="display: none;">
                                        <div class="form-group">
                                            <label for="dibayar_dimuka">Dibayar Dimuka:</label>
                                            <input type="number" class="form-control" id="dibayar_dimuka"
                                                name="dibayar_dimuka" />
                                        </div>
                                        <div class="form-group">
                                            {{-- <label>Dibayar Tunai:</label> --}}
                                            <h3 id="total_value">Dibayar Kredit: {{ rupiah($total) }}</h3>
                                        </div>
                                    </div>


                                    <div id="tunai_fields" style="display: none">
                                        <div class="form-group">
                                            <h3 id="total_value">Dibayar Tunai: {{ rupiah($total) }}</h3>
                                            {{-- <input type="text" id="dibayar_dimuka" name="dibayar_dimuka"> --}}
                                        </div>
                                    </div>

                                    <div class="text-right mt-3">
                                        @if ($pembelian->status !== 'lunas')
                                            <!-- Adjust condition as needed -->
                                            <button type="button" class="btn btn-primary" id="saveButton">Create
                                                Data</button>

                                            {{-- <a href="{{ route('pembeliandetail.storepembelian') }}" class="btn btn-primary data">Simpan Data</a> --}}
                                        @endif
                                        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                                    </div>

                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('transaksi/pembelian/detail/modal')
    @include('transaksi/pembelian/detail/modal')
    @include('transaksi/pembelian/detail/delete')
    @include('transaksi/pembelian/detail/edit')


    <script>
        $(document).ready(function() {
            function updatePaymentFields() {
                var paymentType = $('#payment_option').val();
                var total = parseFloat($('#total').val());
                var dibayarDimuka = parseFloat($('#dibayar_dimuka').val() || 0);

                if (paymentType === 'kredit') {
                    $('#credit_fields').show();
                    $('#tunai_fields').hide();
                } else if (paymentType === 'tunai') {
                    $('#credit_fields').hide();
                    $('#tunai_fields').show();
                } else {
                    $('#credit_fields').hide();
                    $('#tunai_fields').hide();
                }
            }

            // Initialize fields based on current selection
            updatePaymentFields();

            // Update fields on payment type change
            $('#payment_option').change(function() {
                updatePaymentFields();
            });

            // Validate credit input to ensure it does not exceed total
            $('#dibayar_dimuka').on('input', function() {
                var credit = parseFloat($(this).val() || 0);
                var total = parseFloat($('#total').val());

                if (credit > total) {
                    alert('Dibayar Dimuka tidak boleh lebih dari Total.');
                    $(this).val(total); // Set input to max value
                }
            });


            // Handling form submission and error
            $('.btn-primary data').on('click', function(e) {
                e.preventDefault();

                var paymentType = $('#payment_option').val();
                if (!paymentType) {
                    alert('Silakan pilih jenis pembayaran.');
                    return;
                }

                var credit = parseFloat($('#dibayar_dimuka').val() || 0);
                var total = parseFloat($('#total').val());

                if (paymentType === 'kredit' && credit > total) {
                    alert('Dibayar Dimuka tidak boleh lebih dari Total.');
                    return;
                }

                // If everything is valid, proceed with the form submission
                $.ajax({
                    url: $(this).closest('form').attr('action'),
                    method: 'POST',
                    data: $(this).closest('form').serialize(),
                    success: function(response) {
                        alert('Data berhasil disimpan!');
                        window.location.href = response
                            .redirect_url; // Assuming response contains redirect URL
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan saat menyimpan data: ' + xhr.responseText);
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const dibayarDimukaInput = document.getElementById('dibayar_dimuka');
            const totalValueElement = document.getElementById('total_value');
            const totalAmount = parseFloat('{{ $total }}'); // Replace with your total value if needed

            function updateTotal() {
                const dibayarDimuka = parseFloat(dibayarDimukaInput.value) || 0;
                const remainingTotal = totalAmount - dibayarDimuka;
                totalValueElement.textContent = formatRupiah(remainingTotal);
            }

            function formatRupiah(amount) {
                return 'Kredit : Rp ' + amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
            }

            dibayarDimukaInput.addEventListener('input', updateTotal);
        });

        $(document).ready(function() {
            $('#saveButton').click(function() {
                var form = $('#saveForm');
                var formData = form.serialize();

                $.ajax({
                    url: '{{ route('pembeliandetail.save') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        $('#addmodal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error details:', xhr); // Log full error object
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });
        });

        $(document).ready(function() {
            $('#pelunasanButton').click(function() {
                var form = $('#pelunasanForm');
                var formData = form.serialize();
                var idPembelian = $('input[name="id_pembelian"]').val(); // Get id_pembelian value
                var kredit = $('input[name="kredit"]').val(); // Get total value

                if (!idPembelian || !kredit) {
                    alert('ID Pembelian and kredit fields are required.');
                    return; // Stop execution if validation fails
                }

                $.ajax({
                    url: '{{ url('transaksi/pembelian-detail') }}/' + idPembelian +
                    '/pelunasan', // Correct URL with id_pembelian
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Ensure CSRF token is included
                    },
                    success: function(response) {
                        location.reload();
                    },
                    error: function(xhr) {
                        console.error('Error details:', xhr); // Log full error object
                        alert('An error occurred: ' + xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection

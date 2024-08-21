<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data {{ $table }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="newForm" method="POST" action="/transaksi/pembelian">
                    @csrf
                    {{-- perusahaan kalo dia admin --}}
                    @if (auth()->user()->id === 1)
                        <div class="form-group">
                            <label for="id_perusahaan">Perusahaan:</label>
                            <select class="form-control" id="id_perusahaan" name="id_perusahaan" required>
                                <option value="" selected hidden>Select Perusahaan</option>
                                @foreach ($perusahaans as $option)
                                    <option value="{{ $option->id_perusahaan }}" selected>{{ $option->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="id_perusahaan" value="{{ auth()->user()->id_perusahaan }}">
                    @endif

                    {{-- Supplier --}}
                    <div class="form-group">
                        <label for="id_supplier">Supplier :</label>
                        <select class="form-control" id="id_supplier" name="id_supplier" required>
                            <option value="" selected hidden>Select Perusahaan</option>
                            @foreach ($suppliers as $option)
                                <option value="{{ $option->id_supplier }}">{{ $option->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- jenis transaksi --}}
                    {{-- <div>
                        <label for="jenis_transaksi">Jenis Transaksi:</label>
                        <br>
                        <input type="radio" id="kredit" name="jenis_transaksi" value="kredit">
                        <label for="kredit">kredit</label>
                        <input type="radio" id="tunai" name="jenis_transaksi" value="tunai">
                        <label for="tunai">tunai</label>
                    </div> --}}

                    {{-- barang --}}
                    {{-- <div class="col-xl-4 col-md-6 mb-5">
                        <h5>Multi Select</h5>
                        <hr>
                        <p>The select below is declared with the<code>multiple</code> attribute</p>
                        <select class="js-example-basic-multiple col-sm-12" multiple="multiple">
                            @foreach ($barangs as $option)
                                <option value="{{ $option->id_barang }}">{{ $option->nama }}</option>
                            @endforeach
                        </select>
                    </div> --}}

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmDataButton">Create Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $(document).ready(function() {
        // Handle form submission for creating new data
        $('#confirmDataButton').click(function() {
            // Get form data
            var form = $('#newForm');
            var formData = form.serialize(); // Serialize form data

            // Send AJAX request
            $.ajax({
                url: 'pembelian' , // Adjust the URL if necessary'
                method: 'POST',
                data: formData,
                success: function(response) {
                    // Handle success
                    $('#addmodal').modal('hide');
                    location.reload(); // Reload the page to see the new data
                },
                error: function(xhr) {
                    // Handle error
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>

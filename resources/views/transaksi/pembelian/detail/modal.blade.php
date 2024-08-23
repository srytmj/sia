<!-- Include CSRF token in meta tag if not already present -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Jasa Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newForm" method="POST" action="/transaksi/pembeliandetaildetail">
                    @csrf
                    <div class="form-group">
                        <label for="id_barang">Barang :</label>
                        <select class="form-control" id="id_barang" name="id_barang" required>
                            <option value="" selected hidden>Select Barang</option>
                            @foreach ($barangs as $option)
                                <option value="{{ $option->id_barang }}">{{ $option->nama }}</option> <!-- Ensure the correct field name here -->
                            @endforeach
                        </select>
                    </div>

                    {{-- Kuantitas --}}
                    <div class="form-group">
                        <label for="kuantitas">Kuantitas :</label>
                        <input type="integer" class="form-control" id="kuantitas" name="kuantitas" required>
                    </div>
                    
                    {{-- Harga --}}
                    <div class="form-group">
                        <label for="harga">Harga :</label>
                        <input type="integer" class="form-control" id="harga" name="harga" required>
                    </div>

                    <input type="id_pembelian" value="{{ $id_pembelian }}" id="id_pembelian" name="id_pembelian" hidden>
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
        $('#confirmDataButton').click(function() {
            var form = $('#newForm');
            var formData = form.serialize();

            $.ajax({
                url: '{{ route("pembeliandetail.store") }}',
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
</script>





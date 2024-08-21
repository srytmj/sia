<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data {{ $table }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="addform" method="POST" action="{{ route('coa.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nama_akun">Nama Akun:</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="kelompok_akun">kelompok_akun Akun:</label>
                        <select class="form-control" id="kelompok_akun" name="kelompok_akun" required>
                            <option value="" selected hidden>Select Kelompok</option>
                            @foreach ($kelompokAkun as $option)
                                <option value="{{ $option->nama_kelompok_akun }}">{{ $option->nama_kelompok_akun }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="posisi_dr_cr">Posisi Debit/Kredit:</label>
                        <br>
                        <input type="radio" id="Debit" name="posisi_dr_cr" value="Debit">
                        <label for="Debit">Debit</label><br>
                        <input type="radio" id="Kredit" name="posisi_dr_cr" value="Kredit">
                        <label for="Kredit">Kredit</label><br>
                    </div>
                    <div class="form-group">
                        <label for="saldo_awal">Saldo Awal:</label>
                        <br>
                        <input type="radio" id="1" name="saldo_awal" value="1">
                        <label for="1">Ya</label><br>
                        <input type="radio" id="0" name="saldo_awal" value="0">
                        <label for="0">Tidak</label><br>
                    </div>
                    <div class="form-group">
                        <label for="id_perusahaan">Perusahaan:</label>
                        <select class="form-control" id="id_perusahaan" name="id_perusahaan" required>
                            <option value="" selected hidden>Select Perusahaan</option>
                            @foreach ($perusahaan as $option)
                                <option value="{{ $option->id_perusahaan }}">{{ $option->nama }}</option>
                            @endforeach
                        </select>
                    </div>
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
    $(document).ready(function() {
        // Handle form submission for creating new data
        $('#confirmDataButton').click(function() {
            // Get form data
            var form = $('#addform'); // Updated ID
            var formData = form.serialize(); // Serialize form data

            // Send AJAX request
            $.ajax({
                url: '{{ route("coa.store") }}', // Use route helper for URL
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
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


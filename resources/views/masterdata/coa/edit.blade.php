<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Coa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editform">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="nama_akun">Nama Akun:</label>
                        <input type="text" class="form-control" id="nama_akun" name="nama_akun" required>
                    </div>
                    <div class="form-group">
                        <label for="kelompok_akun">kelompok_akun Akun:</label>
                        <select class="form-control" id="kelompok_akun" name="kelompok_akun" required>
                            <option value="" selected hidden>Select Kelompok</option>
                            @foreach ($kelompokAkun as $option)
                                <option value="{{ $option->nama_kelompok_akun }}"> {{ $option->nama_kelompok_akun }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="posisi_d_c">Posisi Debit/Kredit:</label>
                        <br>
                        <input type="radio" id="Debit" name="posisi_d_c" value="Debit">
                        <label for="Debit">Debit</label><br>
                        <input type="radio" id="Kredit" name="posisi_d_c" value="Kredit">
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
                    @if (auth()->user()->id === 1)
                        <div class="form-group">
                            <label for="id_perusahaan">Perusahaan:</label>
                            <select class="form-control" id="id_perusahaan" name="id_perusahaan" required>
                                <option value="" hidden>Select Perusahaan</option>
                                @foreach ($perusahaan as $option)
                                    <option value="{{ $option->id_perusahaan }}"> {{ $option->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="id_perusahaan" value="id_perusahaan">
                    @endif
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="confirmUpdateButton">Update Data</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle edit button click
        $('.edit-button').click(function() {
            var id = $(this).data('id');

            // Fetch current data and populate the form
            $.ajax({
                url: '/masterdata/coa/' + id + '/edit',
                method: 'GET',
                success: function(data) {
                    // Populate the form fields (input)
                    $('input[name="id_coa"]').val(data.coas.id_coa);
                    $('input[name="nama_akun"]').val(data.coas.nama_akun);
                    
                    // Populate the form fields (dropdown)
                    $('select[name="kelompok_akun"]').val(data.coas.kelompok_akun);
                    $('select[name="id_perusahaan"]').val(data.coas.id_perusahaan);

                    // Populate the form fields (radio button)
                    $('input[name="posisi_d_c"][value="' + data.coas.posisi_d_c + '"]').prop('checked', true);
                    $('input[name="saldo_awal"][value="' + data.coas.saldo_awal + '"]').prop('checked', true);

                    // Update form action URL
                    $('#editform').attr('action', '/masterdata/coa/' + id);

                    // Show the modal
                    $('#editmodal').modal('show');
                },
                error: function(xhr) {
                    alert('Error: ' + xhr.responseText);
                }
            });
        });

        // Handle form submission for updating data
        $('#confirmUpdateButton').click(function() {
            var form = $('#editform');
            var formData = form.serialize(); // Serialize form data

            // Send AJAX request for updating
            $.ajax({
                url: form.attr('action'), // Use the action attribute from the form
                method: 'POST',
                data: formData + '&_method=PUT&_token={{ csrf_token() }}', // Include CSRF token and method override
                success: function(response) {
                    // Handle success
                    $('#editmodal').modal('hide');
                    location.reload(); // Reload the page to see the updated data
                },
                error: function(xhr) {
                    // Handle error
                    alert('Error: ' + xhr.responseText);
                }
            });
        });
    });
</script>

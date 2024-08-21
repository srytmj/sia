<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Jabatan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editform" method="POST" action="{{ route('jabatan.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Jabatan :</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="asuransi">Asuransi :</label>
                        <input type="number" class="form-control" id="asuransi" name="asuransi" required>
                    </div>
                    <div class="form-group">
                        <label for="tarif_tetap">Asuransi :</label>
                        <input type="number" class="form-control" id="tarif_tetap" name="tarif_tetap" required>
                    </div>
                    <div class="form-group">
                        <label for="tarif_tidak_tetap">Asuransi :</label>
                        <input type="number" class="form-control" id="tarif_tidak_tetap" name="tarif_tidak_tetap" required>
                    </div>
                    @if (auth()->user()->id === 1)
                        <div class="form-group">
                            <label for="id_perusahaan">Perusahaan:</label>
                            <select class="form-control" id="id_perusahaan" name="id_perusahaan" required>
                                <option value="" selected hidden>Select Perusahaan</option>
                                @foreach ($perusahaan as $option)
                                    <option value="{{ $option->id_perusahaan }}">{{ $option->nama }}</option>
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
                url: '/masterdata/jabatan/' + id + '/edit',
                method: 'GET',
                success: function(data) {
                    // Populate the form fields (input)
                    $('input[name="nama"]').val(data.jabatans.nama);
                    $('input[name="asuransi"]').val(data.jabatans.asuransi);
                    $('input[name="tarif_tetap"]').val(data.jabatans.tarif_tetap);
                    $('input[name="tarif_tidak_tetap"]').val(data.jabatans.tarif_tidak_tetap);
                    $('select[name="id_perusahaan"]').val(data.jabatans.id_perusahaan);

                    // Update form action URL
                    $('#editform').attr('action', '/masterdata/jabatan/' + id);

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
            // Get form data
            var form = $('#editform');
            var formData = form.serialize(); // Serialize form data
            
            // Send AJAX request for updating
            $.ajax({
                url: form.attr('action'), // Use the action attribute from the form
                method: 'PUT',
                data: formData + '&_token={{ csrf_token() }}', // Include CSRF token
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

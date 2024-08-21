<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data {{ $table }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="addJabatanForm" method="POST" action="{{ route('jabatan.store') }}">
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
            var form = $('#addJabatanForm'); // Updated ID
            var formData = form.serialize(); // Serialize form data

            // Send AJAX request
            $.ajax({
                url: '{{ route("jabatan.store") }}', // Use route helper for URL
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


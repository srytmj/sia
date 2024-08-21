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
                    {{-- perusahaan kalo dia admin --}}
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
                        <input type="hidden" name="id_perusahaan" value="{{ auth()->user()->id_perusahaan }}">
                    @endif

                    {{-- nama --}}
                    <div class="form-group">
                        <label for="nama">Nama Supplier:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    {{-- No Telepon --}}
                    <div class="form-group">
                        <label for="no_telp">No Telepon:</label>
                        <input type="number" class="form-control" id="no_telp" name="no_telp" required>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label for="alamat">Alamat :</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
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
                url: '{{ route('supplier.store') }}', // Use route helper for URL
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                        'content') // Include CSRF token
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

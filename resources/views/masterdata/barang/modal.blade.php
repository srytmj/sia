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
                        <label for="nama">Nama Barang:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>

                    {{-- detail --}}
                    <div class="form-group">
                        <label for="detail">Detail :</label>
                        <input type="text" class="form-control" id="detail" name="detail" required>
                    </div>

                    {{-- satuan --}}
                    <div class="form-group">
                        <label for="satuan">Satuan :</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <option value="" selected hidden>Select Satuan</option>
                            <option value="unit">unit</option>
                            <option value="ml">ml</option>
                            <option value="gr">gr</option>
                        </select>
                    </div>

                    {{-- satuan --}}
                    <div class="form-group">
                        <label for="kategori">Kategori :</label>
                        <br>
                        <input type="radio" id="perlengkapan" name="kategori" value="Perlengkapan">
                        <label for="perlengkapan">Perlengkapan</label>
                        <input type="radio" id="peralatan" name="kategori" value="Peralatan">
                        <label for="peralatan">Peralatan</label>
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
                url: '{{ route('barang.store') }}', // Use route helper for URL
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

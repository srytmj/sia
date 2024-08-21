<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editform">
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
                url: '/masterdata/barang/' + id + '/edit',
                method: 'GET',
                success: function(data) {
                    // Populate the form fields (input)
                    $('input[name="nama"]').val(data.barangs.nama);
                    $('input[name="detail"]').val(data.barangs.detail);

                    // Populate the form fields (dropdown)
                    $('select[name="id_perusahaan"]').val(data.barangs.id_perusahaan);
                    $('select[name="satuan"]').val(data.barangs.satuan);

                    // Populate the form fields (radio)
                    $('input[name="kategori"][value="' + data.barangs.kategori + '"]')
                        .prop('checked', true);

                    // Update form action URL
                    $('#editform').attr('action', '/masterdata/barang/' + id);

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
                data: formData +
                    '&_method=PUT&_token={{ csrf_token() }}', // Include CSRF token and method override
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

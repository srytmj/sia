<!-- Edit Modal -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Supplier</h5>
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
                url: '/masterdata/supplier/' + id + '/edit',
                method: 'GET',
                success: function(data) {
                    // Populate the form fields (input)
                    $('input[name="nama"]').val(data.suppliers.nama);
                    $('input[name="no_telp"]').val(data.suppliers.no_telp);
                    $('input[name="alamat"]').val(data.suppliers.alamat);

                    // Populate the form fields (dropdown)
                    $('select[name="id_perusahaan"]').val(data.suppliers.id_perusahaan);

                    // Populate the form fields (radio)
                    $('input[name="status"][value="' + data.suppliers.status + '"]')
                        .prop('checked', true);

                    // Update form action URL
                    $('#editform').attr('action', '/masterdata/supplier/' + id);

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

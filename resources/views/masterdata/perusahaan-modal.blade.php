<div class="modal fade" id="addmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Company</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="newCompanyForm">

                    <input type="hidden" id="table-data" name="table" value="perusahaan">

                    <div class="form-group">
                        <label for="nama" class="col-form-label">Nama Perusahaan:</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat" class="col-form-label">Alamat:</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis" class="col-form-label">Jenis Perusahaan:</label>
                        <select class="form-control" id="jenis" name="jenis_perusahaan" required>
                            <option value="">Select Type</option>
                            <option value="jasa">Jasa</option>
                            <option value="dagang">Dagang</option>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
                <input type="hidden" id="delete-ids" name="ids">
                <input type="hidden" id="delete-table" name="table">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle the click event for the create button in the add modal
    $('#confirmDataButton').on('click', function() {
        $.post('/masterdata/store', $('#newCompanyForm').serialize())
            .done(function(response) {
                console.log('Success:', response);
                $('#addmodal').modal('hide');
                location.reload();
            })
            .fail(function(xhr) {
                console.log('Error:', xhr.responseText);
            });
    });

    // Tampilkan modal konfirmasi saat tombol delete ditekan
    $('.delete-button').on('click', function() {
        var ids = $(this).data('ids'); // Get the ID from the button's data attribute
        var table = $(this).data('table'); // Get the table name from the button's data attribute
        
        // Set nilai ID dan table di modal
        $('#delete-ids').val(ids);
        $('#delete-table').val(table);
        
        // Tampilkan modal konfirmasi
        $('#deleteModal').modal('show');
    });

    // Handle delete ketika tombol 'Yes, Delete' ditekan
    $('#confirmDeleteButton').on('click', function() {
        var ids = $('#delete-ids').val();
        var table = $('#delete-table').val();
        
        // Kirim request delete via AJAX
        $.ajax({
            url: '/masterdata/delete',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                ids: ids,
                table: table
            },
            success: function(response) {
                if (response.success) {
                    // Sembunyikan modal dan refresh halaman
                    $('#deleteModal').modal('hide');
                    location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseText);
            }
        });
    });
});
</script>


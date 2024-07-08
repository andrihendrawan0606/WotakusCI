<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('content') ?>

<div class="row mt-5">
    <div class="col-11 ml-5">
        <div class="card-body">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Total Genre : <?= esc($genres) ?> </h6>
                <a href="#"><button type="button" id="openModal"  class="btn btn-primary mt-2">Tambah Genre</button></a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Genre</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($genre as $anime) : ?>
                        <tr>
                            <td><?= $anime['id'] ?></td>
                            <td><?= $anime['genre'] ?></td>
                            <td><?= $anime['created_at'] ?></td>
                            <td>
                            <button class="btn btn-warning edit-genre" data-id="<?= $anime['id'] ?>" data-slug="<?= $anime['slug_genre'] ?>" data-genre="<?= $anime['genre'] ?>"><i class="fal fa-edit"></i></button>
                            <button class="btn btn-danger delete-genre" data-id="<?= $anime['id'] ?>"><i class="fal fa-trash-alt"></i></button>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>

    $(document).ready(function() {
        // Flashdata handling dengan SweetAlert2 toast
        <?php if (session()->getFlashdata('pesan')) : ?>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            Toast.fire({
                icon: 'success',
                title: '<?= session()->getFlashdata('pesan'); ?>'
            });
        <?php endif; ?>
    });

// Tambah Genre dengan sweetalert 2 -------------------------------------------------------------------------------------------------------------------------------------------------
  $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        $(document).ready(function() {
        $('#openModal').on('click', function() {
            Swal.fire({
                title: 'Tambah Genre',
                html: `
                    <form id="genreForm" action="<?= url_to('prosesGenre'); ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="form-icon">
                            <span><i class="icon icon-user"></i></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="genre" class="form-control item " id="username" placeholder="Masukkan Nama Genre" value="<?= old('genre'); ?>" autofocus >
                            <div class="invalid-feedback">
                            
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block create-account">Tambah</button>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Tutup'
            });


            $(document).on('submit', '#genreForm', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Genre berhasil ditambahkan.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menambahkan genre.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    });

// Edit Genre dengan sweetalert 2 -------------------------------------------------------------------------------------------------------------------------------------------------

    $(document).ready(function() {
        $('#dataTable').DataTable();


        $(document).on('click', '.edit-genre', function() {
            const id = $(this).data('id');
            const slug = $(this).data('slug');
            const genre = $(this).data('genre');

            Swal.fire({
                title: 'Edit Genre',
                html: `
                    <form id="editGenreForm" action="<?= url_to('updateGenre', ''); ?>/${slug}" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="${id}">
                        <div class="form-icon">
                            <span><i class="icon icon-user"></i></span>
                        </div>
                        <div class="form-group">
                            <input type="text" name="genre" class="form-control item" id="editGenre" placeholder="Masukkan Nama Genre" value="${genre}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-block create-account">Update</button>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                cancelButtonText: 'Tutup'
            });

  
            $(document).on('submit', '#editGenreForm', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            title: 'Sukses!',
                            text: 'Genre berhasil diupdate.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat mengupdate genre.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });


// Hapus Genre dengan sweetalert 2 -------------------------------------------------------------------------------------------------------------------------------------------------

    $(document).on('click', '.delete-genre', function() {
        const id = $(this).data('id');
        const deleteUrl = "<?= url_to('deleteGenre', ''); ?>/" + id;

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Genre ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: deleteUrl,
                    method: 'POST',
                    data: {<?= csrf_token() ?>: '<?= csrf_hash() ?>'},
                    success: function(response) {
                        Swal.fire({
                            title: 'Dihapus!',
                            text: 'Genre berhasil dihapus.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus genre.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    });
});

    
</script>

<?= $this->endSection() ?>

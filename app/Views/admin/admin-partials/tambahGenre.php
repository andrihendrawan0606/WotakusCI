<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('content') ?>

<div class="registration-form">
    <form id="genreForm" action="<?= url_to('prosesGenre');  ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-icon">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="form-group">
            <input type="text" name="genre" class="form-control item <?= ($validation->hasError('genre')) ? 'is-invalid' : ''; ?>" id="username" placeholder="Masukkan Nama Genre" value="<?= old('genre'); ?>" autofocus >
            <div class="invalid-feedback">
                <?= $validation->getError('genre') ?>
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block create-account">Tambah</button>
        </div>
        <div class="form-group">
            <a href="<?= url_to('genreList') ?>" style="text-decoration: none;"><button type="button" class="btn btn-block create-account" style="background-color: red;">Kembali</button></a>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('#genreForm').on('submit', function(e) {
            e.preventDefault();

            let form = this;

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda tidak akan dapat membatalkan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, tambahkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
</script>











<?= $this->endSection() ?>

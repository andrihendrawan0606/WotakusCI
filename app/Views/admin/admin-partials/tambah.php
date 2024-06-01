<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>





<div class="container mt-5">
    <!-- <div class="registration-form"> -->
        <form action="<?= url_to('prosesTambah'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-icon text-center">
                <span><i class="icon icon-user"></i></span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <input type="text" name="Judul" class="form-control <?= ($validation->hasError('Judul')) ? 'is-invalid' : ''; ?>" id="Judul" placeholder="Judul" value="<?= old('Judul'); ?>" autofocus>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Judul') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="Desc" class="form-control <?= ($validation->hasError('Desc')) ? 'is-invalid' : ''; ?>" id="Desc" placeholder="Deskripsi"><?= old('Desc'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Desc') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="genre[]" id="choices-multiple-remove-button" class="form-control <?= ($validation->hasError('genre')) ? 'is-invalid' : ''; ?>" multiple required>
                            <?php foreach ($genres as $genre): ?>
                                <option value="<?= $genre['id'] ?>" <?= in_array($genre['id'], old('genre', [])) ? 'selected' : '' ?>><?= $genre['genre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            <?= $validation->getError('genre') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="number" name="Eps" class="form-control <?= ($validation->hasError('Eps')) ? 'is-invalid' : ''; ?>" id="Eps" placeholder="Jumlah Episode" value="<?= old('Eps'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('Eps') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="number" name="Durasi" class="form-control <?= ($validation->hasError('Durasi')) ? 'is-invalid' : ''; ?>" id="Durasi" placeholder="Durasi (menit)" value="<?= old('Durasi'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('Durasi') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="date" name="Rilis" class="form-control <?= ($validation->hasError('Rilis')) ? 'is-invalid' : ''; ?>" id="Rilis" placeholder="Tanggal Rilis" value="<?= old('Rilis'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('Rilis') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="JudulLainnya" class="form-control <?= ($validation->hasError('JudulLainnya')) ? 'is-invalid' : ''; ?>" id="JudulLainnya" placeholder="Judul Lainnya" value="<?= old('JudulLainnya'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('JudulLainnya') ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="BackgroundCover" id="fileBackgroundCover" class="custom-file-input <?= ($validation->hasError('BackgroundCover')) ? 'is-invalid' : ''; ?>" onchange="previewImg()">
                            <label class="custom-file-label" for="fileBackgroundCover">Background Cover</label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('BackgroundCover') ?>
                            </div>
                        </div>
                        <div class="mt-2">
                            <img src="/assets/images/default.jpg" id="img-preview" class="image-thumbnail">
                        </div>
                    </div>
                    <div class="form-group mt-5">
                        <div class="custom-file">
                            <input type="file" name="Poster" id="Poster" class="custom-file-input <?= ($validation->hasError('Poster')) ? 'is-invalid' : ''; ?>" onchange="previewImgPoster()">
                            <label class="custom-file-label" for="Poster">Poster</label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('Poster') ?>
                            </div>
                        </div>
                        <div class="mt-2">
                            <img src="/assets/images/default.jpg" id="img-preview-poster" class="image-thumbnail">
                        </div>
                    </div>
                    <div class="form-group">
                        <select name="status" class="form-control mt-4">
                            <option value="Completed">Completed</option>
                            <option value="On-Going">On-Going</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block create-account">Tambah</button>
                    </div>
                    <div class="form-group">
                        <a href="<?= url_to('dashboard') ?>" style="text-decoration: none;">
                            <button type="button" class="btn btn-block create-account" style="background-color: red;">Kembali</button>
                        </a>
                    </div>
                </div>
            <!-- </div> -->
        </form>
    </div>
</div>
















<?= $this->endSection() ?>
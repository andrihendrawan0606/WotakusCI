<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>



<div class="container mt-5">
    <!-- <div class="registration-form"> -->
    <form action="<?= url_to('prosesEdit', $animes['anime_id']); ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="BackgroundCoverOld" value="<?= $animes['BackgroundCover'] ?>">
        <input type="hidden" name="PosterOld" value="<?= $animes['Poster'] ?>">
        <div class="form-icon text-center">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" name="Judul" class="form-control <?= ($validation->hasError('Judul')) ? 'is-invalid' : '' ?>" value="<?= $animes['Judul'] ?>" id="Judul" placeholder="Judul" autofocus>
                    <div class="invalid-feedback">
                        <?= $validation->getError('Judul') ?>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="Desc" class="form-control <?= ($validation->hasError('Desc')) ? 'is-invalid' : ''; ?>" id="Desc" placeholder="Deskripsi"><?= $animes['Desc'] ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('Desc') ?>
                    </div>
                </div>
                <div class="form-group">
                    <select name="genre[]" id="choices-multiple-remove-button" class="form-control <?= ($validation->hasError('genre')) ? 'is-invalid' : ''; ?>" multiple required>
                        <?php foreach ($genres as $genre): ?>
                            <option value="<?= $genre['id'] ?>" <?= in_array($genre['id'], array_column($selectedGenre, 'genre_id')) ? 'selected' : '' ?>><?= esc($genre['genre']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        <?= $validation->getError('genre') ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="number" name="Eps" class="form-control <?= ($validation->hasError('Eps')) ? 'is-invalid' : ''; ?>" id="Eps" placeholder="Jumlah Episode" value="<?= $animes['Eps'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('Eps') ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="number" name="Durasi" class="form-control <?= ($validation->hasError('Durasi')) ? 'is-invalid' : ''; ?>" id="Durasi" placeholder="Durasi (menit)" value="<?= $animes['Durasi'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('Durasi') ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="date" name="Rilis" class="form-control <?= ($validation->hasError('Rilis')) ? 'is-invalid' : ''; ?>" id="Rilis" placeholder="Tanggal Rilis" value="<?= $animes['Rilis'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('Rilis') ?>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="JudulLainnya" class="form-control <?= ($validation->hasError('JudulLainnya')) ? 'is-invalid' : ''; ?>" id="JudulLainnya" placeholder="Judul Lainnya" value="<?= $animes['JudulLainnya'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('JudulLainnya') ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" name="BackgroundCover" id="fileBackgroundCover" class="custom-file-input <?= ($validation->hasError('BackgroundCover')) ? 'is-invalid' : ''; ?>" onchange="previewImg()">
                        <label class="custom-file-label" for="fileBackgroundCover"><?= $animes['BackgroundCover'] ?></label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('BackgroundCover') ?>
                        </div>
                    </div>
                    <div class="mt-2">
                        <img src="/assets/images/<?= $animes['BackgroundCover'] ?>" id="img-preview" class="image-thumbnail">
                    </div>
                </div>
                <div class="form-group mt-5">
                    <div class="custom-file">
                        <input type="file" name="Poster" id="Poster" class="custom-file-input <?= ($validation->hasError('Poster')) ? 'is-invalid' : ''; ?>" onchange="previewImgPoster()">
                        <label class="custom-file-label" for="Poster"><?= $animes['Poster'] ?></label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Poster') ?>
                        </div>
                    </div>
                    <div class="mt-2">
                        <img src="/assets/images/<?= $animes['Poster'] ?>" id="img-preview-poster" class="image-thumbnail">
                    </div>
                </div>
                <div class="form-group">
                    <select name="status" class="form-control mt-4">
                        <option value="Completed" <?= $animes['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="On-Going" <?= $animes['status'] == 'On-Going' ? 'selected' : '' ?>>On-Going</option>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block create-account">Edit</button>
                </div>
                <div class="form-group">
                    <a href="<?= url_to('dashboard') ?>" style="text-decoration: none;">
                        <button type="button" class="btn btn-block create-account" style="background-color: red;">Kembali</button>
                    </a>
                </div>
            </div>
        </div>
    </form>
<!-- </div> -->
</div>


<?= $this->endSection() ?>
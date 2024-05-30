<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>



<div class="registration-form">
    <form action="/dashboard/edit/ProsesEdit/<?= $animes['anime_id'] ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="BackgroundCoverOld" value="<?= $animes['BackgroundCover'] ?>">
        <input type="hidden" name="PosterOld" value="<?= $animes['Poster'] ?>">
        <div class="form-icon">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="form-group">
            <input type="text" name="Judul" class="form-control item <?= ($validation->hasError('Judul')) ? 'is-invalid' : '' ?>" value="<?= $animes['Judul'] ?>" id="username" placeholder="Judul" autofocus>
            <div class="invalid-feedback">
                <?= $validation->getError('Judul') ?>
            </div>
        </div>
        <div class="custom-file">
            <input type="file" name="BackgroundCover" id="fileBackgroundCover" class="custom-file-input <?= ($validation->hasError('BackgroundCover')) ? 'is-invalid' : '' ?>" onchange="previewImg()">
            <div class="invalid-feedback">
                <?= $validation->getError('BackgroundCover') ?>
            </div>
            <label class="custom-file-label" id="custom-file-label" for="customFile"><?= $animes['BackgroundCover'] ?></label>
            <div class="mt-2 ml-2">
                <img src="/assets/images/<?= $animes['BackgroundCover'] ?>" style="width: 10em;" id="img-preview" class="image-thumbnail img-Preview">
            </div>
        </div>
        <div class="custom-file mt-5 mb-5">
            <input type="file" name="Poster" id="Poster" class="custom-file-input <?= ($validation->hasError('Poster')) ? 'is-invalid' : '' ?>" id="customFile" onchange="previewImgPoster()">
            <div class="invalid-feedback">
                <?= $validation->getError('Poster') ?>
            </div>
            <label class="custom-file-label" id="custom-file-label-poster" for="customFile"><?= $animes['Poster'] ?></label>
            <div class="mt-2 ml-2">
                <img src="/assets/images/<?= $animes['Poster'] ?>" id="img-preview-poster" style="width: 3em; height: 3em;" class="image-thumbnail img-preview" alt="">
            </div>
        </div>
        <div class="form-group mt-3">
            <textarea type="text" name="Desc" class="form-control item" id="Desc" placeholder="Desc"><?= $animes['Desc'] ?></textarea>
        </div>
        <div class="form-group">
            <select name="genre[]" id="choices-multiple-remove-button" placeholder="Pilih Genre" multiple>
                <?php foreach ($genres as $genre): ?>
                <option value="<?= $genre['id'] ?>" <?= in_array($genre['id'], array_column($selectedGenre, 'genre_id')) ? 'selected' : '' ?>><?= esc($genre['genre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input type="number" value="<?= $animes['Eps'] ?>" name="Eps" class="form-control item" id="phone-number" placeholder="Eps">
        </div>
        <div class="form-group">
            <input type="number" value="<?= $animes['Durasi'] ?>" name="Durasi" class="form-control item" id="birth-date" placeholder="Durasi">
        </div>
        <div class="form-group">
            <input type="date" value="<?= $animes['Rilis'] ?>" name="Rilis" class="form-control item" id="birth-date" placeholder="Rilis">
        </div>
        <div class="form-group">
            <input type="text" value="<?= $animes['JudulLainnya'] ?>" name="JudulLainnya" class="form-control item" id="birth-date" placeholder="Judul Lainnya">
        </div>
        <div class="form-group">
            <select for="Status" name="status" class="form-control item mt-4">
                <option name="status" value="Completed" <?= $animes['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                <option name="status" value="On-Going" <?= $animes['status'] == 'On-Going' ? 'selected' : '' ?>>On-Going</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block create-account">Edit</button>
        </div>
        <div class="form-group">
            <a href="/dashboard"><button type="button" class="btn btn-block create-account" style="background-color: red;">Kembali</button></a>
        </div>
    </form>
</div>


<?= $this->endSection() ?>
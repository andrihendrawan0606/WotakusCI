<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>





<div class="registration-form">
    <form action="/dashboard/prosesTambah" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-icon">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="form-group">
            <input type="text" name="Judul" class="form-control item <?= ($validation->hasError('Judul')) ? 'is-invalid' : ''; ?>" id="username" placeholder="Judul" value="<?= old('Judul'); ?>" autofocus >
            <div class="invalid-feedback">
                <?= $validation->getError('Judul') ?>
            </div>
        </div>
        <div class="custom-file">
            <input type="file" name="BackgroundCover" id="fileBackgroundCover" class="custom-file-input <?= ($validation->hasError('BackgroundCover')) ? 'is-invalid' :'' ?>"  onchange="previewImg()">
            <div class="invalid-feedback" >
                <?= $validation->getError('BackgroundCover') ?>
            </div>
            <label class="custom-file-label" id="custom-file-label" for="customFile">Background Cover</label>
            <div class="mt-2 ml-2">
                <img src="/assets/images/default.jpg" style="width: 10em;" id="img-preview" class="image-thumbnail img-Preview">
            </div>
        </div>
        <div class="custom-file mt-5 mb-5">
            <input type="file" name="Poster" id="Poster" class="custom-file-input <?= ($validation->hasError('Poster')) ? 'is-invalid' :'' ?>" id="customFile" onchange="previewImgPoster()">
            <div class="invalid-feedback">
                <?= $validation->getError('Poster') ?>
            </div>
            <label class="custom-file-label" id="custom-file-label-poster" for="customFile">Poster</label>
            <div class="mt-2 ml-2">
                <img src="/assets/images/default.jpg" id="img-preview-poster" style="width: 10em;, height: 10em; " class="image-thumbnail img-preview"  alt="">
            </div>
        </div>
        <div class="form-group mt-5">
            <textarea type="text" name="Desc" class="form-control item <?= ($validation->hasError('Desc')) ? 'is-invalid' :'' ?>" value="<?= old('Desc'); ?>" id="Desc" placeholder="Desc"></textarea>
        </div>
        <div class="form-group">
            <select name="genre[]" id="choices-multiple-remove-button" placeholder="" multiple required>
                <?php foreach ($genres as $genre): ?>
                <option value="<?= $genre['id']  ?>"><?= $genre['genre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <input type="number" name="Eps" class="form-control item <?= ($validation->hasError('Eps')) ? 'is-invalid' :'' ?>" value="<?= old('Eps'); ?>" id="phone-number" placeholder="Eps">
        </div>
        <div class="form-group">
            <input type="number" name="Durasi" class="form-control item <?= ($validation->hasError('Durasi')) ? 'is-invalid' :'' ?>" value="<?= old('Durasi'); ?>" id="birth-date" placeholder="Durasi">
        </div>
        <div class="form-group">
            <input type="date" name="Rilis" class="form-control item  <?= ($validation->hasError('Rilis')) ? 'is-invalid' :'' ?>" value="<?= old('Rilis'); ?>" id="birth-date" placeholder="Rilis">
        </div>
        <div class="form-group">
            <input type="text" name="JudulLainnya" class="form-control item <?= ($validation->hasError('JudulLainnya')) ? 'is-invalid' :'' ?>" value="<?= old('JudulLainnya'); ?>" id="birth-date"
                placeholder="Judul Lainnya">
        </div>
        <div class="form-group">
            <select for="Status" name="status" class="form-control item mt-4">
                <option name="status" value="Completed">Completed</option>
                <option name="status" value="On-Going">On-Going</option>
            </select>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-block create-account">Tambah</button>
        </div>
        <div class="form-group">
            <a href="<?= url_to('dashboard') ?>" style="text-decoration: none;"><button type="button" class="btn btn-block create-account" style="background-color: red;">Kembali</button></a>
        </div>
    </form>

</div>
















<?= $this->endSection() ?>
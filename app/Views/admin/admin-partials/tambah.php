<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="container mt-5">
        <form action="<?= url_to('prosesTambah'); ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field(); ?>
            <div class="form-icon text-center">
                <span><i class="icon icon-user"></i></span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="judul">Judul Anime</label>
                        <input type="text" name="Judul" class="form-control <?= ($validation->hasError('Judul')) ? 'is-invalid' : ''; ?>" id="Judul" placeholder="Judul" value="<?= old('Judul'); ?>" autofocus>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Judul') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="desc">Deskripsi / Sinopsis</label>
                        <textarea name="Desc" class="form-control <?= ($validation->hasError('Desc')) ? 'is-invalid' : ''; ?>" id="summernote" placeholder="Deskripsi"><?= old('Desc'); ?></textarea>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Desc') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="genre">Genre</label>                     
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
                        <label for="jumlahEpisode">Jumlah Episode</label>
                        <input type="number" name="Eps" class="form-control <?= ($validation->hasError('Eps')) ? 'is-invalid' : ''; ?>" id="Eps" placeholder="Jumlah Episode" value="<?= old('Eps'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('Eps') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Durasi">Durasi Per Episode <strong>* Menit</strong></label>
                        <input type="number" name="Durasi" class="form-control <?= ($validation->hasError('Durasi')) ? 'is-invalid' : ''; ?>" id="Durasi" placeholder="Durasi (menit)" value="<?= old('Durasi'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('Durasi') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rilis">Rilis</label>
                        <input type="date" name="Rilis" class="form-control <?= ($validation->hasError('Rilis')) ? 'is-invalid' : ''; ?>" id="Rilis" placeholder="Tanggal Rilis" value="<?= old('Rilis'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('Rilis') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="judulLainnya">Judul Lainnya</label>
                        <input type="text" name="JudulLainnya" class="form-control <?= ($validation->hasError('JudulLainnya')) ? 'is-invalid' : ''; ?>" id="JudulLainnya" placeholder="Judul Lainnya" value="<?= old('JudulLainnya'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('JudulLainnya') ?>
                        </div>
                    </div>
                    <div class="form-group">
                    <label for="tipeAnime">Tipe Anime</label>
                            <select class="form-control selectpicker" name="typeAnime" title="Pilih Tipe Anime">
                                <?php foreach($typeAnime as $item): ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['tipeAnime'] ?></option>
                                <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                    <label for="seriLainnya">Seri Lainnya <strong> * Bisa pilih lebih dari 1 </strong></label>
                        <!-- <select id=""  multiple="multiple" style="width: 100%;"> -->
                            <select class="form-control selectpicker" data-size="7" data-max-options="6" title="Pilih Seri Lainnya" data-live-search="true" name="seriLainnya[]" multiple>
                                <?php foreach($animes as $item): ?>
                                    <option value="<?= $item['id'] ?>"><?= $item['Judul'] ?></option>
                                <?php endforeach; ?>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="status">Status</label>
                        <select name="status" class="form-control selectpicker" title="Pilih Status">
                            <option value="Completed">Completed</option>
                            <option value="On-Going">On-Going</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="judulLainnya">Background Cover <strong>* Maks 2MB Format jpg | jpeg | png | webp</strong></label>
                        <div class="custom-file">
                            <input type="file" name="BackgroundCover" id="fileBackgroundCover" class="custom-file-input <?= ($validation->hasError('BackgroundCover')) ? 'is-invalid' : ''; ?>" onchange="previewImg('img-preview', 'fileBackgroundCover', 'btn-reset-background-cover')">
                            <label class="custom-file-label" for="fileBackgroundCover">Background Cover</label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('BackgroundCover') ?>
                            </div>
                        </div>
                        <div class="mt-2 position-relative" id="frame-background-cover">
                        <img src="/assets/images/default.jpg" id="img-preview" class="image-thumbnail frame-image">
                        <button type="button" class="btn btn-danger btn-sm position-absolute d-none" style="top: 0; right: 0;" id="btn-reset-background-cover" onclick="resetImageBackgroundCover('img-preview', 'fileBackgroundCover', 'btn-reset-background-cover')">x</button>
                    </div>

                    </div>
                    <div class="form-group mt-5">
                        <label for="judulLainnya">Poster <strong>* Maks 2MB Format jpg | jpeg | png | webp</strong></label>
                        <div class="custom-file">
                            <input type="file" name="Poster" id="Poster" class="custom-file-input <?= ($validation->hasError('Poster')) ? 'is-invalid' : ''; ?>" onchange="previewImgPoster()">
                            <label class="custom-file-label" for="Poster">Poster</label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('Poster') ?>
                            </div>
                        </div>
                        <div class="mt-2 position-relative" id="frame-poster">
                            <img src="/assets/images/default.jpg" id="img-preview-poster" class="image-thumbnail frame-image">
                            <button type="button" class="btn btn-danger btn-sm position-absolute d-none" style="top: 0; right: 0;" id="btn-reset-poster" onclick="resetImagePoster('img-preview-poster', 'Poster', 'btn-reset-poster')">x</button>
                        </div>
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
<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>



<div class="container mt-5">
    <form action="<?= url_to('prosesEdit', $animes['id']); ?>" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="BackgroundCoverOld" value="<?= $animes['BackgroundCover'] ?>">
        <input type="hidden" name="PosterOld" value="<?= $animes['Poster'] ?>">

        <input type="hidden" name="BackgroundCoverReset" id="BackgroundCoverReset" value="0">
        <input type="hidden" name="PosterReset" id="PosterReset" value="0">
        <div class="form-icon text-center">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="judul">Judul Anime</label>
                    <input type="text" name="Judul" class="form-control <?= ($validation->hasError('Judul')) ? 'is-invalid' : '' ?>" value="<?= $animes['Judul'] ?>" id="Judul" placeholder="Judul" required autofocus>
                    <div class="invalid-feedback">
                        <?= $validation->getError('Judul') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="desc">Deskripsi / Sinopsis</label>
                    <textarea name="Desc" class="form-control <?= ($validation->hasError('Desc')) ? 'is-invalid' : ''; ?>" id="summernote" placeholder="Deskripsi"><?= $animes['Desc'] ?></textarea>
                    <div class="invalid-feedback">
                        <?= $validation->getError('Desc') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="genre">Genre</label>
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
                    <label for="jumlahEpisode">Jumlah Episode</label>
                    <input type="number" name="Eps" class="form-control <?= ($validation->hasError('Eps')) ? 'is-invalid' : ''; ?>" id="Eps" placeholder="Jumlah Episode" value="<?= $animes['Eps'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('Eps') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="Durasi">Durasi Per Episode * <strong>Menit</strong></label>
                    <input type="number" name="Durasi" class="form-control <?= ($validation->hasError('Durasi')) ? 'is-invalid' : ''; ?>" id="Durasi" placeholder="Durasi (menit)" value="<?= $animes['Durasi'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('Durasi') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rilis">Rilis</label>
                    <input type="date" name="Rilis" class="form-control <?= ($validation->hasError('Rilis')) ? 'is-invalid' : ''; ?>" id="Rilis" placeholder="Tanggal Rilis" value="<?= $animes['Rilis'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('Rilis') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="judulLainnya">Judul Lainnya</label>
                    <input type="text" name="JudulLainnya" class="form-control <?= ($validation->hasError('JudulLainnya')) ? 'is-invalid' : ''; ?>" id="JudulLainnya" placeholder="Judul Lainnya" value="<?= $animes['JudulLainnya'] ?>">
                    <div class="invalid-feedback">
                        <?= $validation->getError('JudulLainnya') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tipeAnime">Tipe Anime</label>
                    <select class="form-control selectpicker" name="typeAnime" title="Pilih Tipe Anime">
                        <?php foreach ($typeAnime as $item): ?>
                            <option value="<?= $item['id'] ?>" <?= ($item['id'] == $animes['typeId']) ? 'selected' : '' ?>><?= $item['tipeAnime'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="seriLainnya">Seri Lainnya <strong> * Bisa pilih lebih dari 1 </strong></label>
                    <select class="form-control selectpicker show-menu-arrow" data-size="7" data-live-search="true" data-max-options="6" multiple title="Pilih Seri Lainnya" name="seriLainnya[]" multiple>
                        <?php foreach($animess as $item): ?>
                            <?php if ($item['id'] !== $animes['id']): ?>
                                <option value="<?= $item['id']; ?>" 
                                    <?= in_array($item['id'], array_column($relatedAnime, 'id')) ? 'selected' : ''; ?>>
                                    <?= $item['Judul']; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </optgroup>
                    </select>
                </div>
                <!-- <div class="form-group">
                    <select name="status_tayang" class="form-control mt-4">
                        <option value="published" <?= $animes['statusTayang'] == 'published' ? 'selected' : '' ?>>Publish</option>
                        <option value="draft" <?= $animes['statusTayang'] == 'draft' ? 'selected' : '' ?>>draft</option>
                    </select>
                </div> -->
                <div class="form-group">
                <label for="status">Status</label>
                    <select name="status" class="form-control selectpicker" title="Pilih Status">
                        <option value="Completed" <?= $animes['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="On-Going" <?= $animes['status'] == 'On-Going' ? 'selected' : '' ?>>On-Going</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="statusTayang">Status Tayang</label>
                    <br>    
                    <input type="hidden" name="status_tayang" value="draft">
                    <input id="labelDemo" type="checkbox" name="status_tayang" value="published" <?= $animes['statusTayang'] == 'published' ? 'checked' : '' ?> class="toggle-status" data-toggle="toggle" data-onstyle="outline-success" data-offstyle="outline-warning" data-on=" <i class='far fa-check-circle'></i><br> Published" data-off="<i class='far fa-times-circle'></i><br> Draft">
                </div>
            </div>
            <!-- BackgroundCover section -->
            <div class="col-md-6">
            <div class="form-group">
                    <label for="BackgroundCover">Background Cover <strong>* Maks 2MB Format jpg | jpeg | png | webp</strong></label>
                    <div class="custom-file">
                        <input type="file" name="BackgroundCover" id="fileBackgroundCover" class="custom-file-input <?= ($validation->hasError('BackgroundCover')) ? 'is-invalid' : ''; ?>" onchange="previewImg('img-preview', 'fileBackgroundCover', 'btn-reset-background-cover')">
                        <label class="custom-file-label" for="fileBackgroundCover"><?= $animes['BackgroundCover'] ?></label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('BackgroundCover') ?>
                        </div>
                    </div>
                    <div class="mt-2 position-relative" id="frame-background-cover">
                        <img src="/assets/images/<?= $animes['BackgroundCover'] ?>" id="img-preview" class="image-thumbnail frame-image">
                        <button type="button" class="btn btn-danger btn-sm position-absolute <?= ($animes['BackgroundCover'] == 'default.jpg') ? 'd-none' : ''; ?>" style="top: 0; right: 0;" id="btn-reset-background-cover" onclick="resetImageBackgroundCover()">x</button>
                    </div>
                </div>
                <!-- Poster section -->
                <div class="form-group mt-5">
                <label for="Poster">Poster <strong>* Maks 2MB Format jpg | jpeg | png | webp</strong></label>
                    <div class="custom-file">
                        <input type="file" name="Poster" id="Poster" class="custom-file-input <?= ($validation->hasError('Poster')) ? 'is-invalid' : ''; ?>" onchange="previewImgPoster()">
                        <label class="custom-file-label" for="Poster"><?= $animes['Poster'] ?></label>
                        <div class="invalid-feedback">
                            <?= $validation->getError('Poster') ?>
                        </div>
                    </div>
                    <div class="mt-2 position-relative" id="frame-poster">
                        <img src="/assets/images/<?= $animes['Poster'] ?>" id="img-preview-poster" class="image-thumbnail frame-image">
                        <button type="button" class="btn btn-danger btn-sm position-absolute <?= ($animes['Poster'] == 'default1.jpg') ? 'd-none' : ''; ?>" style="top: 0; right: 0;" id="btn-reset-poster" onclick="resetImagePoster()">x</button>
                    </div>
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

<script>
    $(document).ready(function(){
        $(".toggle-status").bootstrapSwitch();
    });
</script>


<?= $this->endSection() ?>
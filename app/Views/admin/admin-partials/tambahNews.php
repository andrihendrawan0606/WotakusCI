<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <!--begin::Form-->
    <form class="form" action="<?= url_to('SaveNews'); ?>" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <div class="alert alert-custom alert-default" role="alert">
                </div>
            </div>
            <div class="form-group">
                <label>Judul News</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"> <> </span></div>
                    <input type="text" name="JudulNews" class="form-control" placeholder="Masukkan Judul News" />
                </div>
                <span class="form-text text-muted">Huruf Gede</span>
            </div>
            <div class="form-group">
                <label>Sub Judul News</label>
                <div class="input-group">
                    <div class="input-group-prepend"><span class="input-group-text"> >< </span></div>
                    <input type="text" name="subJudulNews" class="form-control" placeholder="Masukkan sub Judul News" />
                </div>
                <span class="form-text text-muted">Huruf kecil</span>
            </div>
            <div class="col-md-12">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" name="previewGambarNews" id="newsimg" class="custom-file-input <?= ($validation->hasError('preview_gambar')) ? 'is-invalid' : ''; ?>" onchange="GambarPreviewNews()">
                            <label class="custom-file-label" id="newsimglabel" for="newsimglabel">Preview Gambar News</label>
                            <div class="invalid-feedback">
                                <?= $validation->getError('preview_gambar') ?>
                            </div>
                        </div>
                        <div class="mt-2">
                            <img src="/assets/images/default.jpg" id="img-preview-news" class="image-thumbnail">
                        </div>
                </div>
            <div class="form-group">
                <select name="tags[]" id="choices-multiple-remove-button2" class="form-control <?= ($validation->hasError('tags')) ? 'is-invalid' : ''; ?>" multiple required>
                    <?php foreach ($tags as $tag): ?>
                        <option value="<?= $tag['id'] ?>" <?= in_array($tag['id'], old('tags', [])) ? 'selected' : '' ?>><?= $tag['namaTag'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('tags') ?>
                </div>
            </div>
            <textarea id="summernote" name="isi"></textarea>
            <button type="submit" class="btn btn-block create-account mt-4">Tambah</button>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

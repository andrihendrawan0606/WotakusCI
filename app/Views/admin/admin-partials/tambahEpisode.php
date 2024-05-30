<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>





<div class="registration-form">
    <form action="/dashboard/detail/prosesEpisode" method="POST" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <div class="form-icon">
            <span><i class="icon icon-user"></i></span>
        </div>
        <div class="form-group">
        <input type="hidden" name="anime_id" value="<?= $animeId['anime_id'] ?>">
        
        <input type="text" name="judul" class="form-control item " id="judul" placeholder="Judul" value="" autofocus >
            <div class="invalid-feedback" >
            </div>
        </div>
        <!-- <div class="custom-file">
            <input type="file" name="BackgroundCover" id="fileBackgroundCover" class="custom-file-input "  onchange="previewImg()">
            <div class="invalid-feedback" >
        
            </div>
            <label class="custom-file-label" id="custom-file-label" for="customFile">Background Cover</label>
            <div class="mt-2 ml-2">
                <img src="/assets/images/default.jpg" style="width: 10em;" id="img-preview" class="image-thumbnail img-Preview">
            </div>
        </div> -->
        <!-- <div class="custom-file  mb-5">
            <input type="file" name="Poster" id="Poster" class="custom-file-input " id="customFile" onchange="previewImgPoster()">
            <div class="invalid-feedback" >

            </div> -->
        <div class="form-group">
            <textarea type="text" name="Deskripsi" class="form-control item " value="" id="Desc" placeholder="Desckripsi"></textarea>
        </div>
        <div class="form-group">
            <input type="number" name="episodeNumber" class="form-control item " value="" id="phone-number" placeholder="Episode Number">
        </div>
        <div class="custom-file">
            <input type="file" name="gambarPreview" id="gambarPreview" class="custom-file-input <?= ($validation->hasError('GambarPreview')) ? 'is-invalid' :'' ?>"  onchange="GambarPreview()">
            <div class="invalid-feedback" >
                <?= $validation->getError('GambarPreview') ?>
            </div>
            <label class="custom-file-label" id="custom-file-label-episode" for="customFile">Gambar Preview Episode</label>
            <div class="mt-2 ml-2">
                <img src="/assets/images/default.jpg" style="width: 10em;" id="img-preview-episode" class="image-thumbnail img-Preview">
            </div>
        </div>
        <div class="custom-file mt-5">
            <input type="file" name="video_path" id="video_path" accept="video/*" class="custom-file-input <?= ($validation->hasError('video_path')) ? 'is-invalid' :'' ?>"  onchange="displayFileDetails()">
            <div class="invalid-feedback" >
                <?= $validation->getError('video_path') ?>
            </div>
            <label class="custom-file-label" id="file-name" for="customFile">Video Preview Episode</label>
            <!-- <div id="file-name"></div> Elemen untuk menampilkan nama file -->
            <video id="video-preview" width="240" height="240" controls style="display: none;">
                <source id="video-source" src="" type="video/mp4">
            </video>
        </div>
        <div class="form-group mt-5">
            <button type="submit" class="btn btn-block create-account">Tambah</button>
        </div>
        <div class="form-group">
         <?php $slug = url_title($animeId['Judul'], '-', true); ?>
            <a href="/dashboard/detail/<?= $animeId['anime_id']; ?>/<?= $slug; ?>" style="text-decoration: none;"><button type="button" class="btn btn-block create-account" style="background-color:red;">Kembali</button></a>
        </div>
    </form>

</div>
















<?= $this->endSection() ?>
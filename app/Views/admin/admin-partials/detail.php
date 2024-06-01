<?= $this->extend('admin/admin-partials/index') ?>

<?= $this->section('Judul') ?>
<?= $title?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="row">
    <img class="card" src="<?=base_url('assets/images/'.$animes['Poster']);?>" alt="Poster-Anime">
    <div class="col-6">
        <form>
            <div class="mb-3 ml-3">
                <label for="InputJudul" class="form-label">Judul</label>
                <input type="email" class="form-control" disabled="disabled" id="exampleInputEmail1"
                    value="<?= $animes['Judul'] ?>" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text"></div>
            </div>
            <div class="mb-3 ml-3">
                <label for="InputDesc" class="form-label">Desc</label>
                <textarea class="form-control" style="width: 100%; height: 4em" disabled="disabled"
                    aria-label="With textarea"><?= $animes['Desc'] ?></textarea>
            </div>
            <div class="mb-3 ml-3">
                <label for="InputEps" class="form-label">Eps</label>
                <input type="text" disabled="disabled" value="<?= $animes['Eps'] ?>" class="form-control"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputDurasi" class="form-label">Durasi</label>
                <input type="text" disabled="disabled" value="<?= $animes['Durasi'] ?> Menit" class="form-control"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputRilis" class="form-label">Rilis</label>
                <input type="text" disabled="disabled" value="<?= format_indo_date($animes['Rilis']); ?>"
                    class="form-control" id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputJudulLainnya" class="form-label">Judul Lainnya</label>
                <input type="text" disabled="disabled" value="<?= $animes['JudulLainnya'] ?>" class="form-control"
                    id="exampleInputPassword1">
            </div>
            <div class="mb-3 ml-3">
                <label for="InputGenre" class="form-label">Genre</label>
                <input type="text" disabled="disabled" value="<?= $animes['genre'] ?> " class="form-control"
                    id="exampleInputPassword1">
            </div>

            <div class="mb-3 ml-3">
                <label for="SelectionGenre" class="form-label">Status</label>
                <input type="text" disabled="disabled" value="<?= $animes['status'] ?>" class="form-control"
                    id="exampleInputPassword1">
            </div>
            <a href="<?= url_to('dashboard') ?>"><button type="button" class="btn btn-danger  ml-3">Kembali</button></a>
        </form>

    </div>
</div>


<div class="row mt-5">
    <div class="col-10 ml-5">
        <div class="card-body">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Total Episode : <?= esc($totalEpisode) ?> </h6>
                <?php 
                    $slug = url_title($animes['Judul'], '-', true); 
                    ?>
                    <a href="<?= url_to('createEpisode', esc($animes['anime_id']), $slug); ?>">
                        <button type="button" class="btn btn-primary mt-2">Tambah Episode</button>
                    </a>
            </div>
            <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" role="alert" id="flash-alert">>
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Anime</th>
                            <th>Episode</th>
                            <th>Deskripsi Episode</th>
                            <th>Views</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($episode as $anime) : ?>
                        <tr>
                            <td><?= $animes['Judul'] ?></td>
                            <td><?= $anime['episode_number'] ?></td>
                            <td><?= $anime['deskripsi'] ?></td>
                            <td><?= $anime['view_count'] ?>- Orang wak</td>
                            <td>
                                <a href=""><button type="button" class="btn btn-warning">Edit</button></a>
                                <?php $slug = url_title($animes['Judul'], '-', true); ?>
                                <a href="<?= url_to('deleteEpisode', $anime['id'], $slug); ?>"><button type="button" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');">Hapus</button></a>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


















<?= $this->endSection() ?>
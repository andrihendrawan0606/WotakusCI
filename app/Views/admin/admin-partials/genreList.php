<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('content') ?>

<div class="row mt-5">
    <div class="col-11 ml-5">
        <div class="card-body">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Total Genre : <?= esc($genres) ?> </h6>
                <a href=""><button type="button" class="btn btn-primary mt-2">Tambah Genre</button></a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Genre</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($genre as $anime) : ?>
                        <tr>
                            <td><?= $anime['id'] ?></td>
                            <td><?= $anime['genre'] ?></td>
                            <td><?= $anime['created_at'] ?></td>
                            <td>
                                <a href=""><button type="button" class="btn btn-warning">Edit</button></a>
                                <a href=""><button type="button" class="btn btn-danger">Hapus</button></a>
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

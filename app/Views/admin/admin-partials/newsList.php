<?= $this->extend('admin/admin-partials/index') ?>
<?= $this->section('content') ?>


<div class="container-fluid">
	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">News - List</h1>
	</div>

	<a href="<?= url_to('TambahNews');  ?>"><button type="button" class="btn btn-primary ml-3 mb-3">Tambah News</button></a>


<div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Sub Judul</th>
                            <th>Penulis</th>
                            <th>Tayang pada</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($news as $n) : ?>
                        <tr>
                            <td><?= $n['id'] ?></td>
                            <td><?= $n['Judul'] ?></td>
                            <td><?= $n['subJudul'] ?></td>
                            <td><?= $n['author_name'] ?></td>
                            <td><?= format_indo_date($n['waktu_penayangan']); ?></td>
                            <td>
                                <a href="#"><button type="button" class="btn btn-warning"><i class="fal fa-edit"></i></button></a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                    </tbody>
                </table>
            </div>
</div>



<?= $this->endSection() ?>

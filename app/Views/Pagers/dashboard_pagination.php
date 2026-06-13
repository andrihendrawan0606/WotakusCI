<?php if ($pager) : ?>
    <div class="container">
        <ul class="pagination">
            <!-- Link ke halaman sebelumnya -->
            <?php if ($pager->hasPreviousPage()) : ?>
                <li><a href="<?= $pager->getPreviousPage() ?>">Prev</a></li>
            <?php else : ?>
                <li class="disabled"><a href="#">Prev</a></li>
            <?php endif; ?>

            <!-- Tampilkan link untuk setiap halaman -->
            <?php foreach ($pager->links() as $link) : ?>
                <li class="<?= $link['active'] ? 'active' : '' ?>">
                    <a href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
                </li>
            <?php endforeach; ?>

            <!-- Link ke halaman berikutnya -->
            <?php if ($pager->hasNextPage()) : ?>
                <li><a href="<?= $pager->getNextPage() ?>">Next</a></li>
            <?php else : ?>
                <li class="disabled"><a href="#">Next</a></li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>
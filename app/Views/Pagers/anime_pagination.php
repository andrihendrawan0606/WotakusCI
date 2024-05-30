<?php $pager->setSurroundCount(2) ?>

<div class="pagination">
    <ul>
        <?php if ($pager->hasPreviousPage()) : ?>
        <a href="<?= $pager->getFirst() ?>">
            <li class="btn prev">
                <i class="fas fa-angle-left"></i> First
            </li>
        </a>
        <a href="<?= $pager->getPreviousPage() ?>">
            <li class="btn ">
                <i class="fas fa-angle-left"></i> Prev
            </li>
        </a>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
        <a href="<?= $link['uri'] ?>">
            <li class="<?= $link['active'] ? 'numb active' : 'numb' ?>">
                <?= $link['title'] ?>
            </li>
        </a>
        <?php endforeach ?>
        <?php if ($pager->hasNextPage()) : ?>
        <a href="<?= $pager->getNextPage() ?>">
            <li class="btn ">
                Next <i class="fas fa-angle-right"></i>
            </li>
        </a>
        <a href="<?= $pager->getLast() ?>">
            <li class="btn next">
                Last <i class="fas fa-angle-right"></i>
            </li>
        </a>
        </li>
        <?php endif ?>
    </ul>
</div>
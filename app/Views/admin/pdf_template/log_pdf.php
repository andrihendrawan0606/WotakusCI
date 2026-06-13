<!DOCTYPE html>
<html lang="id">
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h2 { text-align: center; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; color: #333; }
        .action { font-weight: bold; }
    </style>
</head>
<body>
    <h2>Laporan Aktivitas Admin (Wotakus VOD)</h2>
    <p>Dicetak pada: <?= date('d M Y H:i:s') ?></p>
    <table>
        <thead>
            <tr>
                <th>TANGGAL</th>
                <th>ADMIN</th>
                <th>AKSI</th>
                <th>ITEM (ID)</th>
                <th>DESKRIPSI & DETAIL PERUBAHAN</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></td>
                    <td><?= $log['admin_name'] ?></td>
                    <td class="action"><?= $log['action'] ?></td>
                    <td><?= $log['item'] ?> (#<?= $log['item_id'] ?>)</td>
                    <td>
                        <?= strip_tags($log['description']) ?><br>
                        <small style="color:#555;"><?= str_replace('<br>', ' | ', strip_tags($log['change_type'], '<br>')) ?></small>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
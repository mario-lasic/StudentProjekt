<?php
    require_once "header.php";

    use StudentProjekt\Models\Smjer;

    $smjerovi = Smjer::dohvatiSve();
?>
<main class="pregled">
    <section class="table-card">
        <h1>Pregled smjerova</h1>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Naziv smjera</th>
                <th>Trajanje</th>
                <th>Status</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($smjerovi as $smjer): ?>
                <tr class="<?= ((int)$smjer['id'] % 2 === 0) ? 'even-row' : 'odd-row' ?>">
                    <td><?= $smjer['id']; ?></td>
                    <td><?= $smjer['naziv']; ?></td>
                    <td><?= $smjer['trajanjeGodina']; ?></td>
                    <td>
                        <?php if ($smjer['aktivan']): ?>
                            <span class="status active">Aktivan</span>
                        <?php else: ?>
                            <span class="status inactive">Neaktivan</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php require_once "footer.php"; ?>

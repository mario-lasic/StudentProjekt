<?php
    require_once "header.php";

    use StudentProjekt\Models\Student;

    $studenti = Student::dohvatiSve();
?>
<main class="pregled">
    <section class="table-card">
        <h1>Pregled studenata</h1>

        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>JMBAG</th>
                <th>Godina studija</th>
                <th>Prosjek</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($studenti as $student): ?>
                <tr class="<?= ((int)$student['id'] % 2 === 0) ? 'even-row' : 'odd-row' ?>">
                    <td><?= $student['id']; ?></td>
                    <td><?= $student['ime']; ?></td>
                    <td><?= $student['prezime']; ?></td>
                    <td><?= $student['jmbag']; ?></td>
                    <td><?= $student['godinaStudija']; ?></td>
                    <td><?= (float)$student['prosjek']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php require_once "footer.php"; ?>

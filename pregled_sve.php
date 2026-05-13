<?php
    require_once "header.php";

    use StudentProjekt\Models\Student;

    $studenti = Student::dohvatiSaSmjerom();


?>
<main class="pregled">
    <section class="table-card">
        <h1>Pregled svega</h1>

        <table>
            <thead>
            <tr>
                <th>Student</th>
                <th>JMBAG</th>
                <th>Godina studija</th>
                <th>Prosjek</th>
                <th>Smjer</th>
            </tr>
            </thead>

            <tbody>
            <?php foreach ($studenti as $student): ?>
                <tr class="<?= ((int)$student['id'] % 2 === 0) ? 'even-row' : 'odd-row' ?>">
                    <td><?= $student["student"]; ?></td>
                    <td><?= $student['jmbag']; ?></td>
                    <td><?= $student['godinaStudija']; ?></td>
                    <td><?= $student['prosjek']; ?></td>
                    <td><?= $student['smjer']; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

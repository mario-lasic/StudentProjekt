<?php

    require_once "header.php";

    use StudentProjekt\Models\Student;
    use StudentProjekt\Models\Smjer;

    $brojStudenataPoSmjeru = Student::dohvatiStudentePoSmjeru();
    $odlikasi = Student::dohvatiOdlikase();
    $kolicina = [];
    foreach ($brojStudenataPoSmjeru as $key => $value) {
        $kolicina[Smjer::findById($key)->getNaziv()] = [
                "value" => $value,
                "row" => $key
        ];
    }
?>

    <main class="pregled">
        <section class="table-card">
            <h1>Dodatni pregledi</h1>

            <h2>Broj studenata po smjeru</h2>

            <table>
                <thead>
                <tr>
                    <th>Smjer</th>
                    <th>Broj studenata</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($kolicina as $key => $v): ?>
                    <tr class="<?= ($v["row"] % 2 === 0) ? 'even-row' : 'odd-row' ?>">
                        <td><?= $key ?></td>
                        <td><?= $v["value"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>


            <h2>Odlikasi</h2>


            <table>
                <thead>
                <tr>
                    <th>Ime i prezime odlikaša</th>
                </tr>
                </thead>

                <tbody>
                <?php foreach ($odlikasi as $key => $value): ?>
                    <tr class="<?= ((int)$key % 2 === 0  ? 'even-row' : 'odd-row') ?>">
                        <td><?= $value["student"] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

<?php require_once "footer.php"; ?>
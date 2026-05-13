<?php
    require_once "header.php";

    use StudentProjekt\Models\Smjer;
    use StudentProjekt\Models\Student;

    $ime = $prezime = $jmbag = $godinaStudija = $prosjek = $smjerId = "";
    $poruka = $greska = "";

    try {
        $smjerovi = Smjer::dohvatiSve();
    } catch (Exception $e) {
        $smjerovi = [];
        $greska = $e->getMessage();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {
            $ime = $_POST["firstName"];
            $prezime = $_POST["lastName"];
            $jmbag = $_POST["jmbag"];
            $godinaStudija = $_POST["godinaStudija"];
            $prosjek = $_POST["prosjek"];
            $smjerId = $_POST["smjerId"];

            $smjer = Smjer::findById($smjerId);

            if ($smjer === null) {
                throw new Exception("Odabrani smjer ne postoji!");
            }

            $student = new Student($ime, $prezime, $jmbag, $godinaStudija, $prosjek, $smjer);
            $student->spremi();
            $poruka = "Student uspješno spremljen!";
            Student::redirect("pregled_studenata.php");
        } catch (Exception $e) {
            $greska = $e->getMessage();
        }
    }
?>
<main class="form-container">
    <section class="form-card">
        <h1>Unos Studenta</h1>
        <?php if (!empty($poruka)): ?>
            <p class="success"><?= $poruka; ?></p>
        <?php endif; ?>

        <?php if (!empty($greska)): ?>
            <p class="error"><?= $greska; ?></p>
        <?php endif; ?>

        <form action="student_form.php" method="POST">

            <label for="firstName">Ime</label>
            <input
                    type="text"
                    id="firstName"
                    name="firstName"
                    placeholder="Ime"
                    value="<?= $ime ?>"
                    required
            >

            <label for="lastName">Prezime</label>
            <input
                    type="text"
                    id="lastName"
                    name="lastName"
                    placeholder="Prezime"
                    value="<?= $prezime ?>"
                    required
            >

            <label for="jmbag">JMBAG</label>
            <input
                    type="text"
                    id="jmbag"
                    name="jmbag"
                    placeholder="JMBAG"
                    value="<?= $jmbag ?>"
                    required
            >

            <label for="godinaStudija">Godina studija</label>
            <input
                    type="number"
                    id="godinaStudija"
                    name="godinaStudija"
                    placeholder="1"
                    value="<?= $godinaStudija ?>"
                    required
            >

            <label for="prosjek">Prosjek</label>
            <input
                    type="number"
                    id="prosjek"
                    name="prosjek"
                    step="0.01"
                    placeholder="5.0"
                    value="<?= $prosjek ?>"
                    required
            >

            <label for="smjerId">Smjer</label>
            <select name="smjerId" id="smjerId">
                <option value="" disabled selected >Odaberi Smjer...</option>
                <?php foreach ($smjerovi as $smjer): ?>
                <option value="<?= $smjer['id'];?>"
                        <?php
                            if ($smjer['id'] == $smjerId) {
                                echo "selected";
                            }
                        ?>
                ><?= $smjer["naziv"]?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Spremi studenta</button>

        </form>
    </section>
</main>
<?php require_once "footer.php"; ?>

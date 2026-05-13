<?php
    require_once "header.php";

    use StudentProjekt\Models\Smjer;

    $naziv = $tajanje = $aktivan = "";
    $poruka = $greska = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        try {


        $naziv = $_POST["naziv"];
        $tajanje = $_POST["tajanje"];
        $aktivan = $_POST["aktivan"];

        $smjer = new Smjer($naziv, $tajanje, $aktivan);
        $smjer->spremi();
        $poruka = "Smjer uspješno spremljen!";
        Smjer::redirect("pregled_smjerova.php");
        } catch (Exception $e) {
            $greska = $e->getMessage();
        }
    }
    Smjer::redirect("pregled_smjerova.php");
?>
<main class="form-container">
    <section class="form-card">
        <h1>Unos Smjera</h1>
        <?php if (!empty($poruka)): ?>
            <p class="success"><?= $poruka; ?></p>
        <?php endif; ?>

        <?php if (!empty($greska)): ?>
            <p class="error"><?= $greska; ?></p>
        <?php endif; ?>
        <form action="smjer_form.php" method="POST">

            <label for="naziv">Naziv smjera</label>
            <input
                    type="text"
                    id="naziv"
                    name="naziv"
                    placeholder="Unesite naziv smjera"
                    required
            >

            <label for="trajanjeGodina">Trajanje studija u godinama</label>
            <input
                    type="number"
                    id="trajanjeGodina"
                    name="trajanjeGodina"
                    placeholder="3"
                    required
            >

            <label class="checkbox-label">
                <input
                        type="checkbox"
                        name="aktivan"
                        value="1"
                        checked
                >
                Aktivan
            </label>

            <button type="submit">Spremi smjer</button>

        </form>
    </section>
</main>
<?php require_once "footer.php"; ?>

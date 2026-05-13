<?php
    require_once "header.php";

    use StudentProjekt\Models\Student;

    $number_of_students = Student::brojStudenata();
?>
<main class="dashboard-container">
    <section class="dashboard-card">
        <h1>Student Projekt</h1>

        <div class="stat-box">
            <h2>Ukupan broj studenata:</h2>
            <p class="number-of-students"><?= $number_of_students ?></p>
        </div>
    </section>
</main>
<?php require_once "footer.php"; ?>
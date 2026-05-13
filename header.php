<?php
    require_once "bootstrap.php";

    use StudentProjekt\Models\Smjer;

    $smjerovi = Smjer::dohvatiSve();
    if (empty($smjerovi)) {
        for ($i = 1; $i <= 30; $i++) {
            try {
                $smjer = new Smjer("Smjer $i", rand(1,5), true);
                $smjer->spremi();
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
    }


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="Assets/style.css">
    <title>Student Project</title>
</head>
<body>
<nav>
    <ul class="nav-menu">
        <li><a href="index.php">Početna</a></li>

        <li class="dropdown">
            <a class="not-link">Unosi <span class="arrow">▼</span></a>

            <ul class="dropdown-menu">
                <li><a href="student_form.php">Unos Studenta</a></li>
                <li><a href="smjer_form.php">Unos Smjera</a></li>
            </ul>
        </li>

        <li class="dropdown">
            <a class="not-link">Pregledi <span class="arrow">▼</span></a>

            <ul class="dropdown-menu">
                <li><a href="pregled_studenata.php">Pregled Studenta</a></li>
                <li><a href="pregled_smjerova.php">Pregled Smjera</a></li>
                <li><a href="pregled_sve.php">Pregled Sve</a></li>
                <li><a href="pregled_dodatne.php">Pregled Dodatno</a></li>
            </ul>
        </li>
    </ul>
</nav>

<?php

declare(strict_types=1);
namespace App;

/* 
    include - uruchomi się gdy plik będzie istniał. Jeśli nie istnieje, to da warning, ale będzie działał
    include_once
    require 
    require_once - program uruchomi się tylko kiedy dany plik będzie istniał
*/

include_once('./src/utils/debug.php');

$action = $_GET['action'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My notes</title>
    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <h1>Moje notatki</h1>    
    </header>

    <main>
        <nav>
            <ul class="ul-note">
                <li class="li-note">
                    <a href="/">Nowa notatka</a>
                </li>
                <li class="li-note">
                    <a href="/?action=create">Lista notatek</a>
                </li>
            </ul>
        </nav>
        <article>
            <?php if ($action === 'create') : ?>
                <h3>Nowa notatka</h3>
                <?php echo htmlentities($action) ?>
            <?php else : ?>
                <h3>Lista notatek</h3>
                <?php echo htmlentities($action ?? '') ?>
            <?php endif; ?>
        </article>
    </main>
</body>
</html>
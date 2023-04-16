<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My notes</title>
    <link rel="stylesheet" href="../public/style.css">
</head>

<body>
    <header>
        <h1>Moje notatki</h1>
    </header>

    <main>
        <nav>
            <ul class="ul-note">
                <li class="li-note">
                    <a href="/">Lista notatek</a>
                </li>
                <li class="li-note">
                    <a href="/?action=create">Nowa notatka</a>
                </li>
            </ul>
        </nav>
        <article>
            <?php
            require_once("./templates/pages/$page.php")
            ?>
        </article>
    </main>
</body>

</html>
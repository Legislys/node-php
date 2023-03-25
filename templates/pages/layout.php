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
            <?php if ($page === 'create') : ?>
                <h3>Nowa notatka</h3>
                <?php echo htmlentities($page) ?>
            <?php else : ?>
                <h3>Lista notatek</h3>
                <?php echo htmlentities($page ?? '') ?>
            <?php endif; ?>
        </article>
    </main>
</body>
</html>
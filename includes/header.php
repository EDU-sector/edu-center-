<?php
require_once __DIR__ . '/../config/database.php';

function renderHeader(string $title = 'EduTricity'): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header class="topbar">
            <a class="brand" href="index.php">EduTricity</a>
            <form class="search" method="get" action="index.php">
                <input type="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search schools, colleges, courses...">
                <button type="submit">Search</button>
            </form>
            <nav>
                <a href="index.php#compare">Compare</a>
                <a href="index.php#popular">Institutions</a>
                <a href="index.php#faqs">FAQs</a>
                <a href="index.php#suggest">Suggest</a>
            </nav>
        </header>
    <?php
}

function renderFooter(): void
{
    ?>
        <footer>
            <p>EduTricity · Education discovery for Chandigarh, Mohali and Panchkula</p>
        </footer>
    </body>
    </html>
    <?php
}

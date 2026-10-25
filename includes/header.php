<?php
function renderHeader(string $title = 'EduTricity'): void
{
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header class="topbar topbar-compact">
            <div class="topbar-inner">
                <div class="brand-wrap">
                    <span class="brand-mark">info</span>
                    <a class="brand" href="index.php">EduTricity</a>
                </div>

                <form class="search search-compact" method="get" action="index.php">
                    <label class="sr-only" for="q">Search institutions</label>
                    <input id="q" type="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search schools, colleges, courses...">
                    <button type="submit">Search</button>
                </form>

                <button type="button" class="ghost-btn">Sign in</button>
            </div>
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

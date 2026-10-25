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
        <link rel="stylesheet" href="/assets/css/style.css">
    </head>
    <body>
        <header class="topbar">
            <div class="topbar-inner">
                <div class="brand-wrap">
                    <span class="brand-mark">EDU</span>
                    <a class="brand" href="/index.php">EduTricity</a>
                </div>

                <form class="search" method="get" action="/index.php">
                    <label class="sr-only" for="q">Search institutions</label>
                    <input id="q" type="search" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Search schools, colleges, courses...">
                    <button type="submit">Search</button>
                </form>

                <nav class="topnav" aria-label="Main navigation">
                    <a href="/index.php#compare">Compare</a>
                    <a href="/index.php#institutions">Institutions</a>
                    <a href="/index.php#faqs">FAQs</a>
                    <a href="/index.php#suggest">Suggest</a>
                </nav>

                <div class="header-actions">
                    <button class="theme-toggle" type="button" aria-label="Toggle dark mode">
                        <span class="theme-toggle-icon">🌙</span>
                    </button>
                    <button type="button" class="ghost-btn">Sign in</button>
                </div>
            </div>
        </header>
        <script src="/assets/js/app.js" defer></script>
    <?php
}

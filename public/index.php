<?php
require_once __DIR__ . '/../app/db.php';

$searchQuery = trim($_GET['q'] ?? '');
$selectedCategory = trim($_GET['category'] ?? '');
$showSuccess = isset($_GET['success']) && $_GET['success'] === '1';
$showError = isset($_GET['error']) && $_GET['error'] === '1';

$categories = [];
$institutions = [];
$metrics = ['institutions' => 0, 'cities' => 0, 'categories' => 0];

try {
    $pdo = getDbConnection();

    $categoriesStmt = $pdo->query('SELECT name FROM categories ORDER BY name ASC');
    $categories = $categoriesStmt->fetchAll(PDO::FETCH_COLUMN);

    $where = [];
    $params = [];

    if ($searchQuery !== '') {
        $where[] = '(i.name LIKE :q OR l.city LIKE :q OR c.name LIKE :q)';
        $params[':q'] = '%' . $searchQuery . '%';
    }

    if ($selectedCategory !== '') {
        $where[] = 'c.name = :category';
        $params[':category'] = $selectedCategory;
    }

    $sql = 'SELECT i.id, i.name, i.ownership, i.description, i.fee_range, i.website, l.city, c.name AS category
            FROM institutions i
            INNER JOIN locations l ON l.id = i.city_id
            INNER JOIN categories c ON c.id = i.category_id';

    if ($where !== []) {
        $sql .= ' WHERE ' . implode(' AND ', $where);
    }

    $sql .= ' ORDER BY i.name ASC';

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $institutions = $stmt->fetchAll();

    $metrics['institutions'] = (int) $pdo->query('SELECT COUNT(*) FROM institutions')->fetchColumn();
    $metrics['cities'] = (int) $pdo->query('SELECT COUNT(*) FROM locations')->fetchColumn();
    $metrics['categories'] = (int) $pdo->query('SELECT COUNT(*) FROM categories')->fetchColumn();
} catch (Throwable $e) {
    $showError = true;
}

renderHeader('EduTricity | Discover institutions across the Tricity');
?>

<div class="layout">
    <aside class="sidebar" aria-label="Navigation and filters">
        <div>
            <p class="eyebrow">Explore</p>
            <h2>EduTricity</h2>
        </div>

        <nav aria-label="Sidebar navigation">
            <a href="#institutions">Institutions</a>
            <a href="#popular">Popular</a>
            <a href="#compare">Compare</a>
            <a href="#faqs">FAQs</a>
            <a href="#suggest">Suggest</a>
        </nav>

        <div>
            <h3>Categories</h3>
            <?php foreach ($categories as $category): ?>
                <a href="/index.php?category=<?= urlencode((string) $category); ?><?= $searchQuery !== '' ? '&q=' . urlencode($searchQuery) : ''; ?>"><?= htmlspecialchars((string) $category, ENT_QUOTES, 'UTF-8'); ?></a>
            <?php endforeach; ?>
        </div>
    </aside>

    <main>
        <section class="panel hero" id="popular">
            <div class="hero-copy">
                <p class="eyebrow">Education discovery for the Tricity</p>
                <h1>Find the right place to learn and grow.</h1>
                <p>Explore schools, colleges, universities, coaching centres, and skill-development institutes across Chandigarh, Mohali, and Panchkula.</p>

                <div class="hero-actions">
                    <a href="#institutions" class="primary-btn">Explore institutions</a>
                    <a href="#compare" class="ghost-btn light-ghost">Compare options</a>
                </div>

                <div class="location-tags" aria-label="Supported locations">
                    <span>Chandigarh</span>
                    <span>Mohali</span>
                    <span>Panchkula</span>
                </div>
            </div>

            <div class="hero-metrics" aria-label="Platform metrics">
                <div>
                    <strong><?= htmlspecialchars((string) $metrics['institutions'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span>Institutions</span>
                </div>
                <div>
                    <strong><?= htmlspecialchars((string) $metrics['cities'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span>Cities</span>
                </div>
                <div>
                    <strong><?= htmlspecialchars((string) $metrics['categories'], ENT_QUOTES, 'UTF-8'); ?></strong>
                    <span>Categories</span>
                </div>
            </div>
        </section>

        <section>
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Explore by type</p>
                    <h2>Education categories</h2>
                </div>
            </div>

            <div class="grid sectors-grid">
                <?php foreach ($categories as $category): ?>
                    <a class="sector-card" href="/index.php?category=<?= urlencode((string) $category); ?>">
                        <span>🎓</span>
                        <h3><?= htmlspecialchars((string) $category, ENT_QUOTES, 'UTF-8'); ?></h3>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="institutions">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Discovery</p>
                    <h2>Institutions</h2>
                </div>
                <?php if ($searchQuery !== '' || $selectedCategory !== ''): ?>
                    <a href="/index.php" class="ghost-btn">Clear filters</a>
                <?php endif; ?>
            </div>

            <?php if ($institutions === []): ?>
                <div class="panel empty-state">
                    <p>No institutions match your current search.</p>
                </div>
            <?php else: ?>
                <div class="institution-grid">
                    <?php foreach ($institutions as $institution): ?>
                        <article class="institution-card">
                            <span class="badge neutral"><?= htmlspecialchars((string) $institution['category'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <h3><?= htmlspecialchars((string) $institution['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="meta"><?= htmlspecialchars((string) $institution['city'], ENT_QUOTES, 'UTF-8'); ?> · <?= htmlspecialchars((string) $institution['ownership'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><?= htmlspecialchars((string) $institution['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <ul>
                                <li>Fee range: <?= htmlspecialchars((string) ($institution['fee_range'] ?: 'Not available'), ENT_QUOTES, 'UTF-8'); ?></li>
                                <?php if (!empty($institution['website'])): ?>
                                    <li><a href="<?= htmlspecialchars((string) $institution['website'], ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer">Official website</a></li>
                                <?php endif; ?>
                            </ul>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section id="compare">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Compare</p>
                    <h2>Side-by-side overview</h2>
                </div>
            </div>

            <div class="compare-grid">
                <?php foreach (array_slice($institutions, 0, 3) as $institution): ?>
                    <article class="compare-card">
                        <h3><?= htmlspecialchars((string) $institution['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                        <p><strong>Location:</strong> <?= htmlspecialchars((string) $institution['city'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Category:</strong> <?= htmlspecialchars((string) $institution['category'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Ownership:</strong> <?= htmlspecialchars((string) $institution['ownership'], ENT_QUOTES, 'UTF-8'); ?></p>
                        <p><strong>Fee:</strong> <?= htmlspecialchars((string) ($institution['fee_range'] ?: 'Not available'), ENT_QUOTES, 'UTF-8'); ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="faqs">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">FAQ</p>
                    <h2>Frequently asked questions</h2>
                </div>
            </div>

            <div class="faq-list">
                <details open>
                    <summary>What is EduTricity?</summary>
                    <p>EduTricity helps students discover and compare educational institutions across the Chandigarh Tricity region.</p>
                </details>
                <details>
                    <summary>Which locations are covered?</summary>
                    <p>We focus on Chandigarh, Mohali, and Panchkula.</p>
                </details>
                <details>
                    <summary>What institutions can I find here?</summary>
                    <p>Schools, colleges, universities, coaching centres, and skill-development institutes.</p>
                </details>
                <details>
                    <summary>Can I suggest a missing institution?</summary>
                    <p>Yes. Use the suggestion form below to submit new institution details for review.</p>
                </details>
            </div>
        </section>

        <section id="suggest" class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Suggest</p>
                    <h2>Suggest an institution</h2>
                </div>
            </div>

            <?php if ($showSuccess): ?>
                <div class="flash success">Your suggestion has been submitted successfully.</div>
            <?php endif; ?>

            <?php if ($showError): ?>
                <div class="flash error">Please complete the institution name and location fields before submitting.</div>
            <?php endif; ?>

            <form id="suggest-form" method="post" action="/process-suggestion.php" class="suggest-form">
                <div class="field-row">
                    <label>
                        Institution name
                        <input type="text" name="institution" placeholder="Enter institution name" required>
                    </label>
                    <label>
                        Location
                        <input type="text" name="location" placeholder="Chandigarh, Mohali, Panchkula" required>
                    </label>
                </div>

                <label>
                    Details
                    <textarea name="details" rows="4" placeholder="Share the type of institution, courses, or other useful details"></textarea>
                </label>

                <button type="submit" class="primary-btn">Submit suggestion</button>
            </form>
        </section>
    </main>
</div>

<?php
renderFooter();
?>

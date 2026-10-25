<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/footer.php';

$dbError = null;

try {
    $pdo = getDbConnection();
} catch (RuntimeException $e) {
    $dbError = $e->getMessage();
    $institutions = [];
}

$searchTerm = trim($_GET['q'] ?? '');

if ($dbError === null) {
    $query = "
        SELECT i.id, i.name, i.ownership, i.description, i.fee_range, i.website,
               l.city, c.name AS category_name
        FROM institutions i
        INNER JOIN locations l ON l.id = i.city_id
        INNER JOIN categories c ON c.id = i.category_id
    ";

    $params = [];
    if ($searchTerm !== '') {
        $query .= " WHERE i.name LIKE :search OR l.city LIKE :search OR c.name LIKE :search ";
        $params[':search'] = '%' . $searchTerm . '%';
    }

    $query .= " ORDER BY i.name ASC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $institutions = $stmt->fetchAll();
}

renderHeader('EduTricity | Education Discovery');
?>

<div class="layout" id="top">
    <aside class="sidebar">
        <div>
            <p class="eyebrow">Explore</p>
            <h2>Quick links</h2>
        </div>
        <a href="#popular">Top institutions</a>
        <a href="#sectors">Education sectors</a>
        <a href="#compare">Compare schools</a>
        <a href="#faqs">Support</a>
    </aside>

    <main>
        <section class="hero panel">
            <div class="hero-copy">
                <p class="eyebrow">EDUCATION DISCOVERY PLATFORM</p>
                <h1>Find the right educational path for every stage of learning.</h1>
                <p>Discover schools, colleges, private institutions, coaching centres and skill-development programmes across Chandigarh, Mohali and Panchkula.</p>
                <div class="hero-actions">
                    <a class="primary-btn" href="#popular">Explore institutions</a>
                    <a class="secondary-btn" href="#compare">Compare options</a>
                </div>
                <div class="location-tags">
                    <span>Chandigarh</span>
                    <span>Mohali</span>
                    <span>Panchkula</span>
                </div>
            </div>

            <div class="hero-metrics">
                <div>
                    <strong>220+</strong>
                    <span>Institutions tracked</span>
                </div>
                <div>
                    <strong>12</strong>
                    <span>Education sectors</span>
                </div>
                <div>
                    <strong>4.9/5</strong>
                    <span>Student trust score</span>
                </div>
            </div>
        </section>

        <section id="sectors" class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Browse by type</p>
                    <h2>Explore education sectors</h2>
                </div>
            </div>

            <div class="grid sectors-grid">
                <article class="sector-card"><span>🏫</span><h3>Schools</h3><p>Class XI and XII, international and foundational learning.</p></article>
                <article class="sector-card"><span>🎓</span><h3>Colleges</h3><p>Degree courses and professional training.</p></article>
                <article class="sector-card"><span>📚</span><h3>Coaching</h3><p>Academic support and entrance preparation.</p></article>
                <article class="sector-card"><span>💻</span><h3>Skill development</h3><p>Career-focused vocational learning.</p></article>
            </div>
        </section>

        <section id="popular" class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Popular choices</p>
                    <h2>Featured institutions</h2>
                </div>
            </div>

            <?php if ($dbError !== null): ?>
                <p class="error-message">Database connection failed: <?= htmlspecialchars($dbError, ENT_QUOTES, 'UTF-8'); ?></p>
            <?php else: ?>
                <div class="institution-grid">
                    <?php foreach ($institutions as $institution): ?>
                        <article class="institution-card">
                            <div class="badge success"><?= htmlspecialchars($institution['ownership'], ENT_QUOTES, 'UTF-8'); ?></div>
                            <h3><?= htmlspecialchars($institution['name'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p class="meta"><?= htmlspecialchars($institution['category_name'], ENT_QUOTES, 'UTF-8'); ?> · <?= htmlspecialchars($institution['city'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <p><?= htmlspecialchars($institution['description'], ENT_QUOTES, 'UTF-8'); ?></p>
                            <ul>
                                <li>Fee range: <?= htmlspecialchars($institution['fee_range'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></li>
                                <li><?= htmlspecialchars($institution['website'] ?? 'Website coming soon', ENT_QUOTES, 'UTF-8'); ?></li>
                            </ul>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <section id="compare" class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Decision support</p>
                    <h2>Compare institutions</h2>
                </div>
            </div>

            <div class="compare-grid">
                <div class="compare-card">
                    <h3>Academic focus</h3>
                    <p><strong>Chandigarh University</strong> · Technology and research courses</p>
                    <p><strong>Government College</strong> · Core degrees and arts programmes</p>
                </div>
                <div class="compare-card">
                    <h3>Cost profile</h3>
                    <p>Private universities offer premium offers and wider options.</p>
                    <p>Government colleges remain more affordable for most learners.</p>
                </div>
                <div class="compare-card">
                    <h3>Best fit</h3>
                    <p>Students seeking campus experience often prefer universities.</p>
                    <p>Budget-conscious learners often prefer public institutions.</p>
                </div>
            </div>
        </section>

        <section id="faqs" class="panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Need help?</p>
                    <h2>Frequently asked questions</h2>
                </div>
            </div>

            <div class="faq-list">
                <details open>
                    <summary>What is EduTricity?</summary>
                    <p>EduTricity is a discovery and comparison platform for educational institutions.</p>
                </details>
                <details>
                    <summary>Which cities does it cover?</summary>
                    <p>Currently, the project focuses on Chandigarh, Mohali and Panchkula.</p>
                </details>
                <details>
                    <summary>Can I suggest an institution?</summary>
                    <p>Yes. Use the suggestion form below to share updates or missing entries.</p>
                </details>
            </div>
        </section>

        <section id="suggest" class="panel suggest-panel">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Improve the directory</p>
                    <h2>Suggest an institution</h2>
                </div>
            </div>

            <form method="post" action="process-suggestion.php" class="suggest-form">
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

<?php renderFooter(); ?>

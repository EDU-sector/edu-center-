<?php
require_once __DIR__ . '/../app/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$institution = trim($_POST['institution'] ?? '');
$location = trim($_POST['location'] ?? '');
$details = trim($_POST['details'] ?? '');

if ($institution === '' || $location === '') {
    header('Location: index.php#suggest?error=1');
    exit;
}

try {
    $pdo = getDbConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO suggestions (institution_name, location, details, status) VALUES (:institution, :location, :details, "pending")'
    );
    $stmt->execute([
        ':institution' => $institution,
        ':location' => $location,
        ':details' => $details,
    ]);

    header('Location: index.php#suggest?success=1');
    exit;
} catch (Exception $e) {
    header('Location: index.php#suggest?error=1');
    exit;
}

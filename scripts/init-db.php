<?php
require_once __DIR__ . '/../app/db.php';

try {
    $pdo = getDbConnection();
    $sql = file_get_contents(__DIR__ . '/../database/schema.sql');

    if ($sql === false) {
        throw new RuntimeException('Unable to read schema.sql');
    }

    $pdo->exec($sql);
    echo "Database initialized successfully.\n";
} catch (Throwable $e) {
    fwrite(STDERR, 'Database initialization failed: ' . $e->getMessage() . PHP_EOL);
    exit(1);
}

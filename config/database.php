<?php
/**
 * Database configuration for EduTricity
 * Update these values to match your local MySQL environment.
 */

$DB_CONFIG = [
    'host' => '127.0.0.1',
    'port' => 3306,
    'dbname' => 'edutricity',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
];

function getDbConnection(): PDO
{
    global $DB_CONFIG;

    $dsn = sprintf(
        'mysql:host=%s;port=%d;dbname=%s;charset=%s',
        $DB_CONFIG['host'],
        $DB_CONFIG['port'],
        $DB_CONFIG['dbname'],
        $DB_CONFIG['charset']
    );

    try {
        $pdo = new PDO($dsn, $DB_CONFIG['username'], $DB_CONFIG['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);

        return $pdo;
    } catch (PDOException $e) {
        throw new RuntimeException('Database connection failed: ' . $e->getMessage());
    }
}

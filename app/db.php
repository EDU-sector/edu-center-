<?php

function getEnvValue(string $key, string $default = ''): string
{
    $value = getenv($key);
    if ($value === false || $value === '') {
        $value = $_ENV[$key] ?? $default;
    }

    return (string) $value;
}

function getDbConnection(): PDO
{
    $host = getEnvValue('DB_HOST', '127.0.0.1');
    $port = getEnvValue('DB_PORT', '3306');
    $dbname = getEnvValue('DB_NAME', 'edutricity');
    $username = getEnvValue('DB_USER', 'root');
    $password = getEnvValue('DB_PASS', '');
    $charset = getEnvValue('DB_CHARSET', 'utf8mb4');

    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=%s',
        $host,
        $port,
        $dbname,
        $charset
    );

    try {
        return new PDO(
            $dsn,
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    } catch (PDOException $e) {
        throw new RuntimeException('Database connection failed: ' . $e->getMessage());
    }
}

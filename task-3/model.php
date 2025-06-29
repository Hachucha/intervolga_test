<?php
$dbname = getenv('DB_NAME', 'app');
$dsn = 'mysql:host=db;dbname='.$dbname.';charset=utf8mb4';
$username = getenv('DB_USER', 'app');
$password = getenv('DB_PASSWORD', '');

function getPDO()
{
    static $pdo = null;

    if ($pdo === null) {
        global $dsn, $username, $password;
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }

    return $pdo;
}


function saveComment($author, $message)
{
    $pdo = getPDO();
    $stmt = $pdo->prepare("INSERT INTO comments (author, message) VALUES (:author, :message)");
    $stmt->execute([    
        ':author' => $author,
        ':message' => $message,
    ]);
}

function getComments()
{
    $pdo = getPDO();
    $stmt = $pdo->query("SELECT author, message, created_at FROM comments ORDER BY created_at ASC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
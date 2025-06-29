<?php
require_once __DIR__ . '/model.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $author = trim($_POST['author'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($author !== '' && $message !== '') {
            saveComment($author, $message);

            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    $comments = getComments();
} catch (PDOException $e) {
    die('Ошибка подключения к БД: ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Комментарии</title>
</head>

<body>
    <h1>Комментарии</h1>

    <?php foreach ($comments as $comment): ?>
        <div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">
            <strong><?= htmlspecialchars($comment['author']) ?></strong><br>
            <small><?= htmlspecialchars($comment['created_at']) ?></small>
            <p><?= nl2br(htmlspecialchars($comment['message'])) ?></p>
        </div>
    <?php endforeach; ?>

    <h2>Добавить комментарий</h2>
    <form method="post" action="">
        <label for="author">Имя:</label><br>
        <input type="text" name="author" id="author" required><br><br>

        <label for="message">Сообщение:</label><br>
        <textarea name="message" id="message" style="width: 100%; box-sizing: border-box" rows="5" required></textarea><br><br>

        <button type="submit">Отправить</button>
    </form>
</body>

</html>
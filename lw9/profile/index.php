<?php
require_once '../data/db.php';

$userId = null;
if (isset($_GET['user_id'])) {
    $userId = (int)$_GET['user_id'];
}

if (!$userId) {
    die("Ошибка: ID пользователя не указан.");
}

$sqlUser = "SELECT u.id, u.user_name, u.avatar_url, u.about_yourself
            FROM users AS u
            WHERE u.id = ?";

$stmtUser = $conn->prepare($sqlUser);
if (!$stmtUser) {
    die("Ошибка подготовки запроса пользователя: " . $conn->error);
}
$stmtUser->bind_param('i', $userId);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
$foundUser = $resultUser->fetch_assoc();

$stmtUser->close();

if (!$foundUser) {
    die("Пользователь с ID " . htmlspecialchars($userId) . " не найден.");
}

$sqlAllImages = "
    SELECT
        pi.image_url,
        p.id AS post_id -- ID поста, чтобы можно было сделать ссылку на post.php
    FROM
        post_images AS pi
    JOIN
        posts AS p ON pi.post_id = p.id
    WHERE
        p.user_id = ?
    ORDER BY
        p.created_time DESC, pi.display_order ASC; -- Сортируем по дате поста, затем по порядку картинки
";

$stmtImages = $conn->prepare($sqlAllImages);
if (!$stmtImages) {
    die("Ошибка подготовки запроса всех картинок: " . $conn->error);
}
$stmtImages->bind_param('i', $userId);
$stmtImages->execute();
$resultAllImages = $stmtImages->get_result();
$userAllImages = $resultAllImages->fetch_all(MYSQLI_ASSOC); 

$stmtImages->close();

$sqlPostCount = "SELECT COUNT(id) AS total_posts FROM posts WHERE user_id = ?";
$stmtPostCount = $conn->prepare($sqlPostCount);
$stmtPostCount->bind_param('i', $userId);
$stmtPostCount->execute();
$resultPostCount = $stmtPostCount->get_result();
$postCountRow = $resultPostCount->fetch_assoc();
$postCount = $postCountRow['total_posts'];
$stmtPostCount->close();

$conn->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= htmlspecialchars($foundUser['user_name']) ?></title>
        <meta charset="UTF-8">
        <link href="../profile.css" rel="stylesheet">
        <link href="../../font/font.css" rel="stylesheet">
    </head>
    <body>
        <div class="page">
            <div class="page__sidebar">
                <nav class="sidebar__menu">
                    <a href="/home" title="Home">
                        <img src="../../images/home.png" class="menu__image-service" alt="Home">
                    </a>
                    <a href="#" title="Profile">
                        <img src="../../images/profile-target.png" class="menu__image-service_target" alt="Profile">
                    </a>
                    <a href="/create_post" title="Plus">
                        <img src="../../images/plus.png" class="menu__image-service" alt="Plus">
                    </a>
                </nav>
            </div>
            <div class="page__main-content">
                <div class="main-content__profile">
                    <div class="profile__info">
                        <?php if ($foundUser['avatar_url']): ?>
                            <img src="../../<?= htmlspecialchars($foundUser['avatar_url']) ?>" class="info__image-avatar" alt="Аватар">
                        <?php endif; ?>
                        <h1 class="info__text-name"><?= htmlspecialchars($foundUser['user_name']) ?></h1>
                    </div>
                    <div class="profile__about">
                    <?php if ($foundUser['about_yourself']): ?>
                        <p class="about__text"><?= htmlspecialchars($foundUser['about_yourself']) ?></p>
                    <?php endif; ?>
                    </div>
                    <div class="profile__statistic">
                        <img src="../../images/posts.png" class="info__image-post" alt="Posts">
                        <p class="statistic__text"> <?= htmlspecialchars($postCount) ?> поста  </p>
                    </div>
                    <div class="profile__content">
                        <?php if (!empty($userAllImages)): ?>
                            <?php foreach ($userAllImages as $image): ?>
                                <div class="content__post-item">
                                    <img src="../../<?= htmlspecialchars($image['image_url']) ?>" class="content__image-photo" alt="Фото из поста">
                                </div>                                  
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>У этого пользователя пока нет фотографий.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> 
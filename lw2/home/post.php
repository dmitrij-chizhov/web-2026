<?php
require_once '../data/db.php';
$postId = null;
if (isset($_GET['id'])) {
    $postId = (int)$_GET['id'];
}

if (!$postId) {
    die("Ошибка: ID поста не указан.");
}

$sql = "SELECT 
            p.*, 
            u.user_name, 
            u.avatar_url
        FROM 
            posts AS p
        JOIN 
            users AS u ON p.user_id = u.id
        WHERE 
            p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $postId);
$stmt->execute();
$result = $stmt->get_result();
$foundPost = $result->fetch_assoc(); 

if ($foundPost) {
    $foundPost['images'] = [];
    $sql_images = "SELECT 
                       image_url 
                   FROM 
                       post_images 
                   WHERE 
                       post_id = ? 
                   ORDER BY 
                       display_order ASC";
    
    $stmt_images = $conn->prepare($sql_images);
    $stmt_images->bind_param('i', $postId);
    $stmt_images->execute();
    $result_images = $stmt_images->get_result();

    while ($row = $result_images->fetch_assoc()) {
        $foundPost['images'][] = $row['image_url'];
    }
    
    $stmt_images->close();
}

function formatRelativeTime($timestamp) {
    $now = time() + 10800; 
    $postTime = strtotime($timestamp); 
    $diff = $now - $postTime; 

    if ($diff < 60) {
        return $diff . ' секунд назад';
    } elseif ($diff < 3600) { 
        $minutes = floor($diff / 60);
        return $minutes . ' минут назад';
    } elseif ($diff < 86400) { 
        $hours = floor($diff / 3600);
        return $hours . ' часов назад';
    } elseif ($diff < 604800) { 
        $days = floor($diff / 86400);
        return $days . ' дней назад';
    } elseif ($diff < 2592000) { 
        $weeks = floor($diff / 604800);
        return $weeks . ' недель назад';
    } elseif ($diff < 31536000) { 
        $months = floor($diff / 2592000);
        return $months . ' месяцев назад';
    } else {
        $years = floor($diff / 31536000);
        return $years . ' лет назад';
    }
}

$stmt->close();
$conn->close();
?>
<?php if ($foundPost): ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= htmlspecialchars($foundPost['title']) ?></title>
        <meta charset="UTF-8">
        <link href="../home.css" rel="stylesheet">
        <link href="../../font/font.css" rel="stylesheet">
    </head>
    <body>
        <div class="page">
            <nav class="page__menu">
                <a href="#" title="Home">
                    <img src="../../images/home-target.png" class="menu__image-service-target" alt="Home" height="40px" width="40px">
                </a>
                <a href="/profile" title="Profile">
                    <img src="../../images/profile.png" class="menu__image-service" alt="Profile" height="24px" width="24px">
                </a>
                <a href="#" title="Plus">
                    <img src="../../images/plus.png" class="menu__image-service" alt="Plus" height="24px" width="24px">
                </a>              
            </nav>
            <div class="page__main-content">
                <div class="main-content__post">         
                    <div class="post__info">
                        <div class="info__user"> 
                            <?php if ($foundPost['avatar_url']): ?>
                                <a href="/profile/index/<?= htmlspecialchars($foundPost['user_id']) ?>">
                                    <img src="../<?= htmlspecialchars($foundPost['avatar_url']) ?>" class="user__avatar" alt="Avatar" width="32px" height="32px">
                                </a>
                            <?php endif; ?>
                            <a href="/profile/index/<?= htmlspecialchars($foundPost['user_id']) ?>"  class="user__author">
                                <p class="user__author"><?= htmlspecialchars($foundPost['user_name']) ?></p>
                            </a>
                        </div>
                        <?php if ($foundPost['user_id'] == 1): ?>
                            <img src="../../images/edit.png" class="user__edit-icon" alt="Edit"  width="24px" height="24px">
                        <?php endif; ?>
                    </div>
                    <div class="post__content">
                        <?php if (!empty($foundPost['images'])): ?>
                            <div class="content__image-container">
                                <?php foreach ($foundPost['images'] as $imageUrl): ?>
                                    <img src="../<?= htmlspecialchars($imageUrl) ?>" class="image-container__image" alt="Post content"  width="474px" height="474px">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="content__footer"> 
                            <div class="footer__actions">
                                <button class="actions__reaction">
                                    <img src="../../images/like.png" class="reaction__image" alt="Like"  width="16px" height="16px">
                                    <p class="reaction__number"><?= $foundPost['like_count'] ?></p>
                                </button>
                            </div>
                            <?php if (!empty($foundPost['content'])): ?>
                                <p class="footer__text"><?= htmlspecialchars($foundPost['content']) ?></p>
                            <?php endif; ?>
                            <span class="footer__time"><?= formatRelativeTime($foundPost['created_time']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </body>
</html>
<?php else: ?>
    <div class="post-not-found">
        <h1>Ошибка 404</h1>
        <p>К сожалению, пост с ID "<?= $postId ?>" не найден.</p>
        <a href="/home">Вернуться на главную</a>
    </div>
<?php endif; ?>
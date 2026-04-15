<?php
require_once '../data/db.php';

$sql = "
    SELECT
        p.id,
        p.title,
        p.content,        
        p.created_time,  
        p.like_count,
        p.user_id,        
        u.user_name,
        u.avatar_url,
        COUNT(pi.id) AS photo_count,
        (SELECT image_url FROM post_images WHERE post_id = p.id ORDER BY display_order ASC LIMIT 1) AS first_image_url
    FROM
        posts AS p
    JOIN
        users AS u ON p.user_id = u.id
    LEFT JOIN
        post_images AS pi ON p.id = pi.post_id
    GROUP BY
        p.id
    ORDER BY
        p.created_time DESC; 
";

$result = $conn->query($sql);
$posts = [];
if ($result) {
    $posts = $result->fetch_all(MYSQLI_ASSOC);
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

$conn->close();

const MAX_TEXT_LENGTH = 135
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
        <link href="home.css" rel="stylesheet">
        <link href="../font/font.css" rel="stylesheet">
    </head>
    <body>
        <div class="page">
            <nav class="page__menu">
                <a href="#" title="Home">
                    <img src="../images/home-target.png" class="menu__image-service-target" alt="Home" height="40px" width="40px">
                </a>
                <a href="/profile/index/1" title="Profile">
                    <img src="../images/profile.png" class="menu__image-service" alt="Profile" height="24px" width="24px">
                </a>
                <a href="#" title="Plus">
                    <img src="../images/plus.png" class="menu__image-service" alt="Plus" height="24px" width="24px">
                </a>              
            </nav>
            <div class="page__main-content">
                <?php 
                    foreach ($posts as $post) {
                        include 'post_preview.php';
                    }
                ?>
            </div>
        </div>        
    </body>
</html>
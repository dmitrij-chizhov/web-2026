<?php
require_once '../data/db.php';

$sql = "
    SELECT
        p.id,
        p.content,
        p.created_time,
        p.like_count,
        p.user_id,
        u.user_name,
        u.avatar_url,
        COUNT(pi.id) AS photo_count,
        JSON_ARRAYAGG(pi.image_url) AS all_images
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
    $rows = $result->fetch_all(MYSQLI_ASSOC);
    
    foreach ($rows as $row) {
        $decoded_images = json_decode($row['all_images'] ?? '[]');
        $row['all_images'] = array_filter($decoded_images);
        
        $posts[] = $row;
    }
}

const SECONDS_IN_MINUTE = 60;
const SECONDS_IN_HOUR = 3600;
const SECONDS_IN_DAY = 86400;
const SECONDS_IN_WEEK = 604800;
const SECONDS_IN_MONTH = 2592000;
const SECONDS_IN_YEAR = 31536000;
const TIMEZONE_OFFSET = 10800;

function formatRelativeTime($timestamp) {
    $now = time() + TIMEZONE_OFFSET; 
    $postTime = strtotime($timestamp); 
    $diff = $now - $postTime; 

    if ($diff < SECONDS_IN_MINUTE) {
        return $diff . ' секунд назад';
    } elseif ($diff < SECONDS_IN_HOUR) { 
        $minutes = floor($diff / SECONDS_IN_MINUTE);
        return $minutes . ' минут назад';
    } elseif ($diff < SECONDS_IN_DAY) { 
        $hours = floor($diff / SECONDS_IN_HOUR);
        return $hours . ' часов назад';
    } elseif ($diff < SECONDS_IN_WEEK) { 
        $days = floor($diff / SECONDS_IN_DAY);
        return $days . ' дней назад';
    } elseif ($diff < SECONDS_IN_MONTH) { 
        $weeks = floor($diff / SECONDS_IN_WEEK);
        return $weeks . ' недель назад';
    } elseif ($diff < SECONDS_IN_YEAR) { 
        $months = floor($diff / SECONDS_IN_MONTH);
        return $months . ' месяцев назад';
    } else {
        $years = floor($diff / SECONDS_IN_YEAR);
        return $years . ' лет назад';
    }
}

$conn->close();

const MAX_TEXT_LENGTH = 135;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Лента новостей</title>
        <meta charset="UTF-8">
        <link href="home.css" rel="stylesheet">
        <link href="../font/font.css" rel="stylesheet">
        <script>
            window.POSTS_IMAGES = <?php 
                $registry = [];
                foreach ($posts as $post) {
                    $registry[] = $post['all_images'];
                }
                echo json_encode($registry);
            ?>;
        </script>
        <script src="script.js"></script>
    </head>
    <body>
        <nav class="menu">
            <a href="#" title="Home">
                <img src="../images/home-target.png" class="menu__image-service_target" alt="Home">
            </a>
            <a href="/profile/index/1" title="Profile">
                <img src="../images/profile.png" class="menu__image-service" alt="Profile">
            </a>
            <a href="/create_post" title="Plus">
                <img src="../images/plus.png" class="menu__image-service" alt="Plus">
            </a>              
        </nav>
        <div class="main-content">
            <?php 
                foreach ($posts as $post) {
                    include 'post_preview.php';
                }
            ?>
        </div>
        <div class="modal" id="modal">
            <div class="modal__content">
                <button class="modal__close" id="modalClose">
                    <img src="../images/cross.png" class="cross__image">
                </button>
                <img src="" class="modal__image" id="modalImage">
                <button class="modal__prev" id="modalPrev">
                    <img src="../images/arrow-left.png" class="slider__image">
                </button>
                <button class="modal__next" id="modalNext">
                    <img src="../images/arrow-right.png" class="slider__image">
                </button>
                <div class="modal__counter" id="modalCounter">1 из 1</div>
            </div>
        </div>
    </body>
</html>
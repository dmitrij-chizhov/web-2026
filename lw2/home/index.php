<?php
$posts = [
    [
        'id' => 1,
        'title' => 'Post Ivan',
        'img_modifier' => '../images/avatar-vania.png',
        'author' => 'Ваня Денисов',
        'edit' => '../images/edit.png',
        'img_content' => ['../images/photo1.png',
        '../images/photo3png',
        '../images/photo4png',
        ],
        'number_of_photo' => '3',
        'reaction_number' => '203',
        'reaction_active' => '',
        'text' => 'Так красиво сегодня на улице! Настоящая зима)) 
              Вспоминается Бродский: «Поздно ночью, в уснувшей долине, 
              на самом дне, в городке, занесенном снегом по ручку двери...» ',
        'more_info' => 'ещё',
        'time_post' => '2 часа назад'
    ],
    [
        'id' => 2,
        'title' => 'Post Elizaveta',
        'img_modifier' => '../images/avatar-elizaveta.png',
        'author' => 'Лиза Дёмина',
        'edit' => '',
        'img_content' => ['../images/photo2.jpg'],
        'number_of_photo' => '1',
        'reaction_number' => '534',
        'reaction_active' => '-active',
        'text' => '',
        'more_info' => '',
        'time_post' => '1 день назад'
    ]
];
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
                    <img src="../images/home-target.png" class="menu__image-service" alt="Home" height="40" width="40">
                </a>
                <a href="/profile" title="Profile">
                    <img src="../images/profile.png" class="menu__image-service" alt="Profile" height="40" width="40">
                </a>
                <a href="#" title="Plus">
                    <img src="../images/plus.png" class="menu__image-service" alt="Plus" height="40" width="40">
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
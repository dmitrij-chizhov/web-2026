<?php
$postId = null;
if (isset($_GET['id'])) {
    $postId = (int)$_GET['id']; 
}

$posts = [
    [
        'id' => 1,
        'title' => 'Post Ivan',
        'subtitle' => 'Post',
        'img_modifier' => '../../images/avatar-vania.png',
        'author' => 'Ваня Денисов',
        'edit' => '../../images/edit.png',
        'img_content' => ['../../images/photo1.png',
        '../../images/photo3.png',
        '../../images/photo4.png',
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
        'subtitle' => 'Post',
        'img_modifier' => '../../images/avatar-elizaveta.png',
        'author' => 'Лиза Дёмина',
        'edit' => '',
        'img_content' => ['../../images/photo2.jpg'],
        'number_of_photo' => '1',
        'reaction_number' => '534',
        'reaction_active' => '-active',
        'text' => '',
        'more_info' => '',
        'time_post' => '1 день назад'
    ]
];

$foundPost = null;
foreach ($posts as $post) {
    if ($post['id'] === $postId) {
        $foundPost = $post;
        break; 
    }
}
?>


<?php if ($foundPost): ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Home</title>
        <meta charset="UTF-8">
        <link href="../home.css" rel="stylesheet">
        <link href="../font/font.css" rel="stylesheet">
    </head>
    <body>
        <div class="page">
            <nav class="page__menu">
                <a href="#" title="Home">
                    <img src="../../images/home.png" class="menu__image-service" alt="Home" height="40" width="40">
                </a>
                <a href="/profile" title="Profile">
                    <img src="../../images/profile.png" class="menu__image-service" alt="Profile" height="40" width="40">
                </a>
                <a href="#" title="Plus">
                    <img src="../../images/plus.png" class="menu__image-service" alt="Plus" height="40" width="40">
                </a>              
            </nav>
            <div class="page__main-content">
                <div class="post-preview">         
                    <div class="post-preview__info">
                        <div class="info__user"> 
                            <?php if (!empty($foundPost['img_modifier'])): ?>
                                <img src="<?= $foundPost['img_modifier'] ?>" class="user__avatar" alt="Avatar">
                            <?php endif; ?>
                            <span class="user__author"><?= $foundPost['author'] ?></span>
                        </div>
                        <?php if (!empty($foundPost['edit'])): ?>
                            <img src="<?= $foundPost['edit'] ?>" class="user__edit-icon" alt="Edit">
                        <?php endif; ?>
                    </div>
                    <div class="post-preview__content">
                        <?php if (!empty($foundPost['img_content'])): ?>
                            <div class="content__image-container"> 
                                <?php foreach ($foundPost['img_content'] as $image): ?>
                                    <img src="<?= $image ?>" class="image-container__image" alt="Post content">
                                <?php endforeach;?>
                            </div>
                        <?php endif; ?>  
                        <div class="content__footer"> 
                            <div class="footer__actions">
                                <button class="actions__reaction<?= $foundPost['reaction_active'] ?>">
                                    <img src="../../images/like.png" class="actions__image-reaction" alt="like">
                                    <?= $foundPost['reaction_number'] ?>
                                </button>
                            </div>
                            <?php if (!empty($foundPost['text'])): ?>
                                <p class="footer__text">
                                    <?= $foundPost['text'] ?>
                                    <?php if (!empty($foundPost['more_info'])): ?>
                                        <a href="#" class="text__more-link"><?= $foundPost['more_info'] ?></a>
                                    <?php endif; ?>
                                </p>
                            <?php endif; ?>
                            <span class="footer__time"><?= $foundPost['time_post'] ?></span>
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
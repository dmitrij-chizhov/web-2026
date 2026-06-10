INSERT INTO 
    users (
        id, 
        user_name, 
        avatar_url, 
        about_yourself
    ) 
VALUES (
    1, 
    'Ваня Денисов', 
    '../../images/avatar-vania.png', 
    'Привет! Я системный аналитик в ACME :) Тут моя жизнь только для самых классных!'
),
(   
    2, 
    'Лиза Дёмина', 
    '../../images/avatar-elizaveta.png', 
    NULL
);

INSERT INTO 
    posts (
        user_id, 
        title, 
        content, 
        like_count
    ) 
VALUES (
    1, 
    'Post Ivan', 
    'Так красиво сегодня на улице! Настоящая зима)) 
    Вспоминается Бродский: «Поздно ночью, в уснувшей долине, 
    на самом дне, в городке, занесенном снегом по ручку двери...» ', 
    203
),
(
    2, 
    'Post Elizaveta', 
    NULL, 
    503
);

INSERT INTO
    post_images (
        post_id,
        image_url,
        display_order
    )   
VALUES (
    1,
    '../../images/photo1.png',
    1
),
(
    1,
    '../../images/photo3.png',
    2 
),
(
    1,
    '../../images/photo4.png',
    3 
),
(
    2,
    '../../images/photo2.jpg',
    1 
);
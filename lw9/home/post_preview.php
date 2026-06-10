<div class="post">         
    <div class="post__user-info">
        <?php if ($post['avatar_url']): ?>
            <a href="/profile/index/<?= htmlspecialchars($post['user_id']) ?>">
                <img src="../../<?= htmlspecialchars($post['avatar_url']) ?>" class="user-info__avatar" alt="Avatar">
            </a>
        <?php endif; ?>
        <a href="/profile/index/<?= htmlspecialchars($post['user_id']) ?>"  class="user-info__author">
            <p><?= htmlspecialchars($post['user_name']) ?></p>
        </a>
        <?php if ($post['user_id'] == 1): ?>
            <img src="../../images/edit.png" class="user-info__edit-icon" alt="Edit">
        <?php endif; ?>
    </div>
    <div class="post__image-container">
        <img src="../../<?= htmlspecialchars($post['all_images'][0]) ?>" class="image-container__image js-image" alt="Post preview">        
        <?php if ($post['photo_count'] > 1): ?>
            <span class="image-container__image-counter js-counter">1/<?= $post['photo_count'] ?></span>
            <button type="button" class="image-container__slider-left js-slider-prev">
                <img src="../images/arrow-left.png" class="slider__image">
            </button>
            <button type="button" class="image-container__slider-right js-slider-next">
                <img src="../images/arrow-right.png" class="slider__image">
            </button>
        <?php endif; ?>
    </div>
    <div class="post__content"> 
        <div class="content__actions">
            <button class="actions__reaction">
                <img src="../images/like.png" class="reaction__image" alt="Like">
                <p class="reaction__number"><?= $post['like_count'] ?></p>
            </button>
        </div>
        <div class="content__text-container js-text-container">
            <p class="text-container__text js-post-text">
                <?= htmlspecialchars($post['content']) ?>
            </p>
            <span class="text__more-link js-toggle-button">ещё</span>
        </div>
        <span class="content__time"><?= formatRelativeTime($post['created_time']) ?></span>
    </div>
</div>
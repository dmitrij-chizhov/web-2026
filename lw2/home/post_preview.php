<div class="post-preview">         
    <div class="post-preview__info">
        <div class="info__user"> 
            <?php if ($post['avatar_url']): ?>
                <a href="/profile/index/<?= htmlspecialchars($post['user_id']) ?>">
                    <img src="<?= htmlspecialchars($post['avatar_url']) ?>" class="user__avatar" alt="Avatar" width="32px" height="32px">
                </a>
            <?php endif; ?>
            <a href="/profile/index/<?= htmlspecialchars($post['user_id']) ?>"  class="user__author">
                <p><?= htmlspecialchars($post['user_name']) ?></p>
            </a>
        </div>
        <?php if ($post['user_id'] == 1): ?>
            <img src="../../images/edit.png" class="user__edit-icon" alt="Edit" width="24px" height="24px">
        <?php endif; ?>
    </div>
    <div class="post-preview__content">
        <?php if ($post['first_image_url']): ?>
            <div class="content__image-container">
                <a class="image-container__link" title="<?= $post['title'] ?>" href="post/<?= $post['id'] ?>"> 
                    <img src="<?= ($post['first_image_url']) ?>" class="image-container__image" alt="Post preview" width="474px" height="474px">
                </a>
                <?php if ($post['photo_count'] > 1): ?>
                    <span class="image-container__image-counter">1/<?= $post['photo_count'] ?></span>
                    <button class="image-container__slider-left">
                        <img src="../images/arrow-left.png" class="slider__image" width="20px" height="20px">
                    </button>
                    <button class="image-container__slider-right">
                        <img src="../images/arrow-right.png" class="slider__image" width="20px" height="20px">
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?> 
        <div class="content__footer"> 
            <div class="footer__actions">
                <button class="actions__reaction">
                    <img src="../images/like.png" class="reaction__image" alt="Like" width="16px" height="16px">
                    <p class="reaction__number"><?= $post['like_count'] ?></p>
                </button>
            </div>
            <?php if ($post['content']) {
                $truncatedText = htmlspecialchars($post['content']); 
                $originalLength = mb_strlen($truncatedText, 'UTF-8'); 
                if ($originalLength > MAX_TEXT_LENGTH) {
                    $truncatedText = mb_substr($truncatedText, 0, MAX_TEXT_LENGTH, 'UTF-8') . '...';
                    $moreInfo = true;
                } else {
                    $moreInfo = false;
                }
                ?>
                <p class="footer__text">
                    <?= $truncatedText ?>
                    <?php if ($moreInfo): ?>
                        <br>
                        <a href="post/<?= htmlspecialchars($post['id']) ?>" class="text__more-link">ещё</a>
                    <?php endif; ?>
                </p>
                <?php
            }
            ?>
            <span class="footer__time"><?= formatRelativeTime($post['created_time']) ?></span>
        </div>
    </div>
</div>
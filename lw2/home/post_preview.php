<div class="post-preview">         
    <div class="post-preview__info">
        <div class="info__user"> 
            <?php if ($post['avatar_url']): ?>
                <a href="/profile/index/<?= htmlspecialchars($post['user_id']) ?>">
                    <img src="<?= htmlspecialchars($post['avatar_url']) ?>" class="user__avatar" alt="Avatar">
                </a>
            <?php endif; ?>
            <a href="/profile/index/<?= htmlspecialchars($post['user_id']) ?>" class="user__author">
                <p class="user__author"><?= htmlspecialchars($post['user_name']) ?></p>
            </a>
        </div>
        <?php if ($post['user_id'] == 1): ?>
            <img src="../../images/edit.png" class="user__edit-icon" alt="Edit">
        <?php endif; ?>
    </div>
    <div class="post-preview__content">
        <?php if ($post['first_image_url']): ?>
            <div class="content__image-container">
                <a class="image-container__link" title="<?= $post['title'] ?>" href="post/<?= $post['id'] ?>"> 
                    <img src="<?= ($post['first_image_url']) ?>" class="image-container__image" alt="Превью поста">
                </a>
                <?php if ($post['photo_count'] > 1): ?>
                    <span class="content__image-counter">1/<?= $post['photo_count'] ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?> 
        <div class="content__footer"> 
            <div class="footer__actions">
                <button class="actions__reaction">
                    <img src="../images/like.png" class="actions__image-reaction" alt="like">
                    <p class="actions__reaction-number"><?= $post['like_count'] ?></p>
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
<div class="post-preview">         
    <div class="post-preview__info">
        <div class="info__user"> 
            <?php if (!empty($post['img_modifier'])): ?>
                <img src="<?= $post['img_modifier'] ?>" class="user__avatar" alt="Avatar">
            <?php endif; ?>
            <span class="user__author"><?= $post['author'] ?></span>
        </div>
        <?php if (!empty($post['edit'])): ?>
            <img src="<?= $post['edit'] ?>" class="user__edit-icon" alt="Edit">
        <?php endif; ?>
    </div>
    <div class="post-preview__content">
        <?php if (!empty($post['img_content'])): ?>
            <div class="content__image-container"> 
                <a class="image-container__link" title="<?= $post['title'] ?>" href="post/<?= $post['id'] ?>"> 
                    <img src="<?= $post['img_content'][0] ?>" class="image-container__image" alt="Post content">
                </a>
                <?php if (!empty($post['number_of_photo']) && $post['number_of_photo'] > 1): ?>
                    <span class="content__image-counter">1/<?= $post['number_of_photo'] ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>  
        <div class="content__footer"> 
            <div class="footer__actions">
                <button class="actions__reaction<?= $post['reaction_active'] ?>">
                    <img src="../images/like.png" class="actions__image-reaction" alt="like">
                    <p class="actions__reaction-number"><?= $post['reaction_number'] ?></p>
                </button>
            </div>
            <?php if (!empty($post['text'])): ?>
                <p class="footer__text">
                    <?= $post['text'] ?><br>
                    <?php if (!empty($post['more_info'])): ?>
                        <a class="text__more-link" title="<?= $post['more_info'] ?>" href="post.php?id=<?= $post['id'] ?>"><?= $post['more_info'] ?></a>
                    <?php endif; ?>
                </p>
            <?php endif; ?>
            <span class="footer__time"><?= $post['time_post'] ?></span>
        </div>
    </div>
</div>
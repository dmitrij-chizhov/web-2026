<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Создать пост</title>
        <link href="create_post.css" rel="stylesheet">
        <link href="../font/font.css" rel="stylesheet">
        <script src="script.js"></script>
    </head>
    <body>
        <nav class="menu">
            <a href="/home" title="Home">
                <img src="../../images/home.png" class="menu__image-service" alt="Home">
            </a>
            <a href="/profile/index/1" title="Profile">
                <img src="../../images/profile.png" class="menu__image-service" alt="Profile">
            </a>
            <a href="#" title="Plus">
                <img src="../../images/plus.png" class="menu__image-service" alt="Plus">
            </a>
        </nav>
        <div class="main-content">
            <div class="create-post-success js-success-message" style="display: none; text-align: center; font-size: 18px; font-family: 'Golos UI Medium', sans-serif; margin-top: 50px;">
                Пост успешно сохранен!
            </div>

            <div class="create-post js-form-container">
                <div class="create-post__error-block js-error-block" style="display: none; color: #ff3333; margin-bottom: 16px; font-family: 'Golos UI Regular', sans-serif; font-size: 14px;"></div>

                <div class="create-post__preview-zone js-preview-container" data-current="0">
                    <img class="preview-zone__image js-image" src="" alt="Preview">
                    
                    <button type="button" class="preview-zone__slider-left js-slider-prev">
                        <img src="../images/arrow-left.png" class="slider__image">
                    </button>
                    <button type="button" class="preview-zone__slider-right js-slider-next">
                        <img src="../images/arrow-right.png" class="slider__image">
                    </button>
                    
                    <span class="preview-zone__image-counter js-counter">1/1</span>
                    
                    <div class="preview-zone__placeholder js-placeholder-block">
                        <img src="../../images/gallery-icon.png" class="placeholder__icon" alt="Placeholder">
                        <button type="button" class="placeholder__button" id="buttonUploadTrigger">Добавить фото</button>
                    </div>
                </div>
                
                <input type="file" id="fileInput" accept="image/*" multiple style="display: none;">
                
                <button type="button" class="create-post__add-button" id="addButton">
                    <img src="../../images/plus-square.png" class="add-button__icon">Добавить фото
                </button>
                
                <textarea class="create-post__textarea" id="postCaption" placeholder="Добавьте подпись..." rows="3"></textarea>
                <button type="button" class="create-post__submit-button" id="submitButton" disabled>Поделиться</button>
            </div>
        </div>
    </body>
</html>
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('fileInput');
    const buttonUploadTrigger = document.getElementById('buttonUploadTrigger');
    const addButton = document.getElementById('addButton');
    const postCaption = document.getElementById('postCaption');
    const submitButton = document.getElementById('submitButton');
    const previewContainer = document.querySelector('.js-preview-container');
    const placeholderBlock = previewContainer.querySelector('.js-placeholder-block');
    const image = previewContainer.querySelector('.js-image');
    const counterElement = previewContainer.querySelector('.js-counter');
    const buttonNext = previewContainer.querySelector('.js-slider-next');
    const buttonPrev = previewContainer.querySelector('.js-slider-prev');

    let uploadedFiles = [];
    let objectUrls = [];

    buttonUploadTrigger.addEventListener('click', () => fileInput.click());
    addButton.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', (e) => {
        const files = Array.from(e.target.files);
        if (files.length > 0) {
            files.forEach(file => {
                objectUrls.push(URL.createObjectURL(file));
            });
            
            uploadedFiles = uploadedFiles.concat(files);
            
            const newIndex = uploadedFiles.length - files.length;
            previewContainer.dataset.current = newIndex;
            
            updateSlider();
            checkValidation();
        }
        fileInput.value = '';
    });

    const updateSlider = () => {
        if (uploadedFiles.length === 0) {
            placeholderBlock.style.display = 'flex';
            image.style.display = 'none';
            buttonPrev.style.display = 'none';
            buttonNext.style.display = 'none';
            counterElement.style.display = 'none';
            return;
        }

        placeholderBlock.style.display = 'none';
        image.style.display = 'block';

        const currentIndex = parseInt(previewContainer.dataset.current, 10) || 0;
        image.src = objectUrls[currentIndex];

        if (uploadedFiles.length > 1) {
            buttonPrev.style.display = 'flex';
            buttonNext.style.display = 'flex';
            counterElement.style.display = 'block';
            counterElement.textContent = `${currentIndex + 1}/${uploadedFiles.length}`;
        } else {
            buttonPrev.style.display = 'none';
            buttonNext.style.display = 'none';
            counterElement.style.display = 'none';
        }
    };

    const next = () => {
        if (uploadedFiles.length === 0) {
            return;
        }
        let currentIndex = parseInt(previewContainer.dataset.current, 10) || 0;
        let nextIndex = (currentIndex + 1) % uploadedFiles.length;
        previewContainer.dataset.current = nextIndex;
        updateSlider();
    };

    const prev = () => {
        if (uploadedFiles.length === 0) {
            return;
        }
        let currentIndex = parseInt(previewContainer.dataset.current, 10) || 0;
        let prevIndex = (currentIndex - 1 + uploadedFiles.length) % uploadedFiles.length;
        previewContainer.dataset.current = prevIndex;
        updateSlider();
    };

    buttonNext.addEventListener('click', (e) => {
        e.stopPropagation();
        next();
    });

    buttonPrev.addEventListener('click', (e) => {
        e.stopPropagation();
        prev();
    });

    document.addEventListener('keydown', (e) => {
        if (document.activeElement === postCaption) {
            return;
        }
        if (e.key === 'ArrowRight') {
            next();
        } else if (e.key === 'ArrowLeft') {
            prev();
        }
    });

    function checkValidation() {
        const hasPhotos = uploadedFiles.length > 0;
        const hasText = postCaption.value.trim().length > 0;
        submitButton.disabled = !(hasPhotos && hasText);
    }

    postCaption.addEventListener('input', checkValidation);

    const formContainer = document.querySelector('.js-form-container');
    const successMessage = document.querySelector('.js-success-message');
    const errorBlock = document.querySelector('.js-error-block');

    submitButton.addEventListener('click', () => {
        submitButton.disabled = true;
        submitButton.textContent = 'Сохранение...';
        
        errorBlock.style.display = 'none';
        errorBlock.textContent = '';

        const formData = new FormData();
        formData.append('caption', postCaption.value.trim());

        uploadedFiles.forEach(file => {
            formData.append('images[]', file);
        });

        fetch('save_post.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    throw new Exception(data.message || 'Произошла ошибка при сохранении.');
                }
                return data;
            });
        })
        .then(data => {
            formContainer.style.display = 'none';
            successMessage.style.display = 'block';
            objectUrls.forEach(url => URL.revokeObjectURL(url));
        })
        .catch(error => {
            errorBlock.textContent = error.message || 'Не удалось связаться с сервером. Попробуйте позже.';
            errorBlock.style.display = 'block';
            submitButton.disabled = false;
            submitButton.textContent = 'Поделиться';
        });
    });
    
});
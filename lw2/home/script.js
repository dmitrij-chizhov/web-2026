document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    const modalCounter = document.getElementById('modalCounter');
    const closeBtn = document.getElementById('modalClose');
    const containers = document.querySelectorAll('.post__image-container');
    let activeContainer = null; // Здесь будем хранить пост, над которым находится мышь

    let modalImages = [];
    let modalIndex = 0;

    // --- ФУНКЦИИ МОДАЛЬНОГО ОКНА ---

    const updateModal = (index) => {
        modalIndex = index;
        modalImg.src = '../' + modalImages[modalIndex];
        modalCounter.textContent = `${modalIndex + 1} из ${modalImages.length}`;
    };

    const nextModal = () => updateModal((modalIndex + 1) % modalImages.length);
    const prevModal = () => updateModal((modalIndex - 1 + modalImages.length) % modalImages.length);

    // Обработчик ESC
    const handleModalKeyboard = (e) => {
        if (e.key === 'Escape'){
            closeModal();
        } else if (e.key === 'ArrowRight') {
            nextModal();
        } else if (e.key === 'ArrowLeft') {
            prevModal();
        }
    };

    const openModal = (images, startIndex) => {
        modalImages = images;
        updateModal(startIndex);
        modal.style.display = 'flex';
        // Подписываемся на ESC только при открытии
        document.addEventListener('keydown', handleModalKeyboard);
    };

    const closeModal = () => {
        modal.style.display = 'none';
        // Отписываемся от ESC при закрытии
        document.removeEventListener('keydown', handleModalKeyboard);
    };

    // События кнопок модалки
    closeBtn.onclick = closeModal;
    document.getElementById('modalNext').onclick = (e) => { e.stopPropagation(); nextModal(); };
    document.getElementById('modalPrev').onclick = (e) => { e.stopPropagation(); prevModal(); };

    // --- ЛОГИКА ЛЕНТЫ (ВАШИ СЛАЙДЕРЫ) ---

    containers.forEach(container => {
        const images = JSON.parse(container.dataset.images);
        const imgElement = container.querySelector('.js-slider-img');
        const counterElement = container.querySelector('.js-counter');
        const btnNext = container.querySelector('.js-slider-next');
        const btnPrev = container.querySelector('.js-slider-prev');

        // Клик по самой картинке открывает модалку
        imgElement.onclick = (e) => {
            e.preventDefault();
            const currentIdx = parseInt(container.dataset.current) || 0;
            openModal(images, currentIdx);
        };

        if (!btnNext || !btnPrev) return;

        let currentIndex = 0;

        const updateImage = (index) => {
            currentIndex = index;
            imgElement.src = '../' + images[currentIndex];
            if (counterElement) {
                counterElement.textContent = `${currentIndex + 1}/${images.length}`;
            }
            // Обновляем индекс в data-атрибуте, чтобы помнить позицию
            container.dataset.current = currentIndex;
        };

        // Логика кликов по кнопкам
        const next = () => {
            let idx = parseInt(container.dataset.current) || 0;
            let nextIndex = (idx + 1 >= images.length) ? 0 : idx + 1;
            updateImage(nextIndex);
        };

        const prev = () => {
            let idx = parseInt(container.dataset.current) || 0;
            let prevIndex = (idx - 1 < 0) ? images.length - 1 : idx - 1;
            updateImage(prevIndex);
        };

        btnNext.addEventListener('click', (e) => { next(); });
        btnPrev.addEventListener('click', (e) => { prev(); });

        // Отслеживаем, над каким постом находится мышь
        container.addEventListener('mouseenter', () => { activeContainer = { next, prev }; });
        container.addEventListener('mouseleave', () => { activeContainer = null; });
    });

    // Слушаем клавиатуру
    document.addEventListener('keydown', (e) => {
        if (!activeContainer) return;

        if (e.key === 'ArrowRight') {
            activeContainer.next();
        } else if (e.key === 'ArrowLeft') {
            activeContainer.prev();
        }
    });

    document.querySelectorAll('.js-text-container').forEach(container => {
        const btnToggle = container.querySelectorAll('.js-toggle-text');
        const shortText = container.querySelector('.js-text-short');
        const fullText = container.querySelector('.js-text-full');

        btnToggle.forEach(btn => {
            btn.addEventListener('click', () => {
                if (fullText.style.display === 'none') {
                    fullText.style.display = 'block';
                    shortText.style.display = 'none';
                } else {
                    fullText.style.display = 'none';
                    shortText.style.display = 'block';
                }
            });
        });
    });
});
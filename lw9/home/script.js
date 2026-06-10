document.addEventListener('DOMContentLoaded', () => {
    const allPostsImages = window.POSTS_IMAGES || [];
    const modal = document.getElementById('modal');
    const modalImg = document.getElementById('modalImage');
    const modalNextButton = document.getElementById('modalNext');
    const modalPrevButton = document.getElementById('modalPrev');
    const modalCounter = document.getElementById('modalCounter');
    const modalCloseButton = document.getElementById('modalClose');
    let activeContainer = null;
    let currentIndexModal = 0;
    let imagesModal = [];

    const updateModal = (index) => {
        modalImg.src = '../' + imagesModal[index];
        modalCounter.textContent = `${index + 1} из ${imagesModal.length}`;
    };

    const nextModal = () => {
        let nextIndex = (currentIndexModal + 1) % imagesModal.length;
        updateModal(nextIndex);
        currentIndexModal = nextIndex;
    };

    const prevModal = () => {
        let prevIndex = (currentIndexModal - 1 + imagesModal.length) % imagesModal.length;
        updateModal(prevIndex);
        currentIndexModal = prevIndex;
    };

    const handleModalKeyboard = (e) => {
        if (e.key === 'Escape'){
            closeModal();
        } else if (e.key === 'ArrowRight') {
            nextModal();
        } else if (e.key === 'ArrowLeft') {
            prevModal();
        }
    };

    const closeModal = () => {
        modal.style.display = 'none';
        document.removeEventListener('keydown', handleModalKeyboard);
    };

    const openModal = (images, startIndex) => {
        imagesModal = images;
        currentIndexModal = startIndex;
        updateModal(currentIndexModal);
        modal.style.display = 'flex';
        document.addEventListener('keydown', handleModalKeyboard);
        if (imagesModal.length === 1) {
            modalNextButton.style.display = 'none';
            modalPrevButton.style.display = 'none';
            modalCounter.style.display = 'none';
        } else {
            modalNextButton.style.display = 'flex';
            modalPrevButton.style.display = 'flex';
            modalCounter.style.display = 'flex';
        }
    };

    modalCloseButton.addEventListener('click', (e) => {
        e.stopPropagation();
        closeModal();
    });
    modalNextButton.addEventListener('click', (e) => {
        e.stopPropagation();
        nextModal();
    });
    modalPrevButton.addEventListener('click', (e) => {
        e.stopPropagation();
        prevModal();
    });

    document.querySelectorAll('.post__image-container').forEach((container, postIndex) => {
        const images = allPostsImages[postIndex] || [];
        let currentIndex = 0;
        const image = container.querySelector('.js-image');
        const counter = container.querySelector('.js-counter');
        const sliderNext = container.querySelector('.js-slider-next');
        const sliderPrev = container.querySelector('.js-slider-prev');

        image.addEventListener('click', (e) => {
            e.stopPropagation();
            e.preventDefault();
            openModal(images, currentIndex);
        });

        if (!sliderNext || !sliderPrev) {
            return;
        }

        const updateImage = (currentIndex) => {
            image.src = '../' + images[currentIndex];
            counter.textContent = `${currentIndex + 1}/${images.length}`;
        };

        const next = () => {
            let nextIndex = (currentIndex + 1) % images.length;
            updateImage(nextIndex);
            currentIndex = nextIndex;
        };

        const prev = () => {
            let prevIndex = (currentIndex - 1 + images.length) % images.length;
            updateImage(prevIndex);
            currentIndex = prevIndex;
        };

        sliderNext.addEventListener('click', (e) => {
            e.stopPropagation();
            next();
        });

        sliderPrev.addEventListener('click', (e) => {
            e.stopPropagation();
            prev();
        });

        container.addEventListener('mouseenter', () => { activeContainer = { next, prev }; });
        container.addEventListener('mouseleave', () => { activeContainer = null; });
    });

    document.addEventListener('keydown', (e) => {
        if (modal.style.display === 'flex') {
            return;
        }
        
        if (!activeContainer) {
            return;
        }

        if (e.key === 'ArrowRight') {
            activeContainer.next();
        } else if (e.key === 'ArrowLeft') {
            activeContainer.prev();
        }
    });

    document.querySelectorAll('.js-text-container').forEach(container => {
        const text = container.querySelector('.js-post-text');
        const toggleButton = container.querySelector('.js-toggle-button');

        text.className = 'text-container__text_collapsed';
        const isOverflowing = text.scrollHeight > text.clientHeight;
        if (!isOverflowing) {
            text.className = 'text-container__text';
            toggleButton.style.display = 'none';
            return;
        }

        toggleButton.style.display = 'inline-block';
        toggleButton.textContent = 'ещё';

        toggleButton.addEventListener('click', () => {
            const isCollapsed = text.classList.replace('text-container__text_collapsed', 'text-container__text');

            if (isCollapsed) {
                toggleButton.textContent = 'свернуть';
            } else {
                text.classList.replace('text-container__text', 'text-container__text_collapsed');
                toggleButton.textContent = 'ещё';
            }
        });
    });
});
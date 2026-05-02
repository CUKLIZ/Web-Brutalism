document.addEventListener('DOMContentLoaded', () => {
    console.log('LOOT VAULT INITIALIZED.');

    // Satisfying click effect
    const allButtons = document.querySelectorAll('.brutal-button');
    allButtons.forEach(btn => {
        btn.addEventListener('mousedown', () => {
            btn.style.transform = 'translate(4px, 4px)';
            btn.style.boxShadow = 'none';
        });
        btn.addEventListener('mouseup', () => {
            btn.style.transform = '';
            btn.style.boxShadow = '';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = '';
            btn.style.boxShadow = '';
        });
    });

    // Add to cart animation
    const buyButtons = document.querySelectorAll('.buy-btn');
    buyButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const originalText = btn.innerText;
            btn.innerText = 'ADDED TO LOOT!';
            btn.style.background = '#FF00FF';
            
            setTimeout(() => {
                btn.innerText = originalText;
                btn.style.background = '';
            }, 2000);
        });
    });

    // Simple scroll reveal for brutalist cards
    const cards = document.querySelectorAll('.brutal-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.4s ease-out';
        observer.observe(card);
    });

    // Products Filtering (Search + Category)
    const searchInput = document.getElementById('search-input');
    const categoryBtns = document.querySelectorAll('.category-btn');
    const productItems = document.querySelectorAll('.product-item');
    const noResultsMsg = document.getElementById('no-results-msg');
    const resultsCount = document.querySelector('.brutal-font[style*="font-size: 1.2rem"]');

    let currentSearch = (window.INITIAL_SEARCH || '').toLowerCase().trim();
    let currentCategory = window.INITIAL_CATEGORY || 'ALL';

    const performFiltering = () => {
        let visibleCount = 0;

        productItems.forEach(item => {
            const name = item.dataset.name || '';
            const category = item.dataset.category || '';
            
            const matchesSearch = name.includes(currentSearch);
            const matchesCategory = currentCategory === 'ALL' || category === currentCategory;

            if (matchesSearch && matchesCategory) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Update UI feedback
        if (noResultsMsg) {
            const isFiltering = currentSearch !== "" || currentCategory !== "ALL";
            noResultsMsg.style.display = (visibleCount === 0 && isFiltering) ? 'block' : 'none';
        }
        if (resultsCount) {
            resultsCount.innerHTML = `[${visibleCount}_RESULTS_FOUND]`;
        }

        // Update Category Buttons Highlighting
        categoryBtns.forEach(btn => {
            if (btn.dataset.category === currentCategory) {
                btn.style.background = 'var(--neon-green)';
                btn.style.transform = 'translate(4px, 4px)';
                btn.style.boxShadow = 'none';
            } else {
                btn.style.background = '';
                btn.style.transform = '';
                btn.style.boxShadow = '';
            }
        });
    };

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value.toLowerCase().trim();
            performFiltering();
        });
    }

    if (categoryBtns.length > 0) {
        categoryBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                currentCategory = btn.dataset.category;
                performFiltering();
            });
        });
    }

    // Run initial filtering
    if (productItems.length > 0) {
        performFiltering();
    }

    // Quick View Modal Logic
    const quickViewBtns = document.querySelectorAll('.quick-view-btn');
    const modal = document.getElementById('quick-view-modal');
    const closeModal = document.getElementById('close-modal');

    if (modal && quickViewBtns.length > 0) {
        quickViewBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const { id, name, price, image, category } = btn.dataset;
                
                const formatPriceJS = (val) => {
                    const idr = Math.floor(parseFloat(val));
                    return 'Rp ' + idr.toLocaleString('id-ID');
                };
                
                document.getElementById('modal-image').src = image;
                document.getElementById('modal-name').textContent = name;
                document.getElementById('modal-price').textContent = formatPriceJS(price);
                document.getElementById('modal-category').textContent = category;
                document.getElementById('modal-link').href = `/product/${id}`;
                
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden'; // Prevent scroll
            });
        });

        const closeFunc = () => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        };

        if (closeModal) closeModal.addEventListener('click', closeFunc);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeFunc();
        });
    }
});

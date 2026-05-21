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

    // --- WISHLIST & AUTH PORTAL ENGINE ---
    const getWishlist = () => JSON.parse(localStorage.getItem('brutal_wishlist') || '[]');
    const setWishlist = (list) => localStorage.setItem('brutal_wishlist', JSON.stringify(list));
    const isLoggedIn = () => localStorage.getItem('currentUser') !== null;

    // Direct dynamic CSS shake animation injection for satisfying haptic feeling
    if (!document.getElementById('wishlist-animations-style')) {
        const style = document.createElement('style');
        style.id = 'wishlist-animations-style';
        style.innerHTML = `
            @keyframes brutalShake {
                0% { transform: translate(0, 0) rotate(0deg); }
                15% { transform: translate(-3px, 2px) rotate(-1.5deg); }
                30% { transform: translate(3px, -1px) rotate(1.5deg); }
                45% { transform: translate(-3px, -2px) rotate(-1deg); }
                60% { transform: translate(2px, 2px) rotate(1deg); }
                75% { transform: translate(-1px, -1px) rotate(-0.5deg); }
                100% { transform: translate(0, 0) rotate(0deg); }
            }
            .cart-badge {
                border: 2px solid black !important;
                box-shadow: 2px 2px 0px black;
                font-weight: 1000 !important;
            }
        `;
        document.head.appendChild(style);
    }

    const showFloatingFeedback = (targetBtn, message, type) => {
        const rect = targetBtn.getBoundingClientRect();
        const floatText = document.createElement('div');
        floatText.innerText = message;
        floatText.style.position = 'fixed';
        floatText.style.top = `${rect.top - 15}px`;
        floatText.style.left = `${rect.left + (rect.width/2)}px`;
        floatText.style.transform = 'translate(-50%, 0)';
        floatText.style.background = type === 'add' ? 'var(--neon-green)' : 'black';
        floatText.style.color = type === 'add' ? 'black' : 'white';
        floatText.style.padding = '8px 16px';
        floatText.style.border = '3px solid black';
        floatText.style.fontWeight = '1000';
        floatText.style.fontSize = '0.75rem';
        floatText.style.zIndex = '1000000';
        floatText.style.pointerEvents = 'none';
        floatText.style.letterSpacing = '1px';
        floatText.style.boxShadow = '5px 5px 0px black';
        floatText.style.transition = 'all 0.8s cubic-bezier(0.19, 1, 0.22, 1)';
        
        document.body.appendChild(floatText);
        
        // Slight shake animation on button
        targetBtn.style.animation = 'brutalShake 0.4s ease-out';
        setTimeout(() => { targetBtn.style.animation = ''; }, 400);

        setTimeout(() => {
            floatText.style.top = `${rect.top - 70}px`;
            floatText.style.opacity = '0';
        }, 50);

        setTimeout(() => {
            floatText.remove();
        }, 850);
    };

    const updateWishlistUI = () => {
        const list = getWishlist();
        
        // Update Wishlist Badge in navbar
        const badge = document.getElementById('wishlist-badge');
        if (badge) {
            badge.innerText = list.length;
            badge.style.display = list.length > 0 ? 'inline-block' : 'none';
        }

        // Update all toggle buttons on the page
        const toggles = document.querySelectorAll('.wishlist-toggle-btn');
        toggles.forEach(btn => {
            const id = btn.dataset.id;
            const hasItem = list.some(item => String(item.id) === String(id));
            
            const icon = btn.querySelector('.heart-icon');
            const text = btn.querySelector('.btn-text');
            
            if (hasItem) {
                // Active/Saved State
                btn.style.background = 'var(--accent-pink)'; // hot pink/magenta accent drop
                btn.style.color = 'white';
                if (icon) icon.innerText = '❤';
                else btn.innerText = '❤';
                if (text) text.innerText = 'SAVED_TO_VAULT';
            } else {
                // Inactive/Unsaved State
                btn.style.background = 'white';
                btn.style.color = 'black';
                if (icon) icon.innerText = '♡';
                else btn.innerText = '♡';
                if (text) text.innerText = 'ADD_TO_VAULT';
            }
        });
    };

    // Expose update handler globally
    window.updateWishlistBadges = updateWishlistUI;

    // Listen to wishlist toggle button clicks (using delegation)
    document.body.addEventListener('click', (e) => {
        const btn = e.target.closest('.wishlist-toggle-btn');
        if (!btn) return;

        e.preventDefault();
        e.stopPropagation();

        if (!isLoggedIn()) {
            window.BrutalModal.show({
                title: 'AUTHENTICATION_REQUIRED',
                message: 'LOGIN TO SAVE PRODUCTS INTO YOUR VAULT.',
                tag: 'SECURE_PROTOCOL_BLOCKED',
                actions: [
                    { label: 'ABORT_SCAN', style: 'neutral', onClick: null },
                    { label: 'PROCEED_TO_LOGIN', style: 'danger', onClick: () => { window.location.href = '/login'; } }
                ]
            });
            return;
        }

        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const price = parseFloat(btn.dataset.price);
        const image = btn.dataset.image;
        const category = btn.dataset.category;

        let list = getWishlist();
        const index = list.findIndex(item => String(item.id) === String(id));

        if (index > -1) {
            list.splice(index, 1);
            setWishlist(list);
            showFloatingFeedback(btn, 'REMOVED_FROM_VAULT', 'remove');
        } else {
            list.push({ id, name, price, image, category });
            setWishlist(list);
            showFloatingFeedback(btn, 'SAVED_TO_VAULT', 'add');
        }

        updateWishlistUI();
    });

    // Handle form submitting simulation for login/register
    const loginForm = document.querySelector('form');
    if (loginForm && window.location.pathname === '/login') {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const inputs = loginForm.querySelectorAll('input');
            const userInput = inputs[0]?.value.trim() || 'VOID_AGENT';
            const emailInput = 'agent@void.st';
            
            localStorage.setItem('currentUser', JSON.stringify({ username: userInput, email: emailInput }));
            
            window.BrutalModal.show({
                title: 'ACCESS_GRANTED',
                message: `IDENTITY ${userInput.toUpperCase()} SUCCESSFULLY LOADED INTO TEMPORARY VAULT SESSION.`,
                tag: 'DECRYPT_SUCCESS',
                actions: [
                    { label: 'ENTER_THE_VAULT', style: 'danger', onClick: () => { window.location.href = '/products'; } }
                ]
            });
        });
    }

    if (loginForm && window.location.pathname === '/register') {
        loginForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const inputs = loginForm.querySelectorAll('input');
            const userInput = inputs[0]?.value.trim() || 'VOID_AGENT';
            const emailInput = inputs[1]?.value.trim() || 'agent@void.st';
            
            localStorage.setItem('currentUser', JSON.stringify({ username: userInput, email: emailInput }));
            
            window.BrutalModal.show({
                title: 'IDENTITY_REGISTERED',
                message: `IDENTITY "${userInput.toUpperCase()}" COMM CHANNEL SET: ${emailInput}.`,
                tag: 'CREATION_SUCCESS',
                actions: [
                    { label: 'PROCEED_TO_VAULT', style: 'danger', onClick: () => { window.location.href = '/products'; } }
                ]
            });
        });
    }

    // Fully functional add-to-cart sync
    document.body.addEventListener('click', (e) => {
        const btn = e.target.closest('.buy-btn');
        if (!btn) return;
        
        const id = btn.dataset.id;
        const name = btn.dataset.name;
        const price = parseFloat(btn.dataset.price);
        const image = btn.dataset.image;
        const category = btn.dataset.category;

        if (id && name) {
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (!cart.some(c => String(c.id) === String(id))) {
                cart.push({ id, name, price, image, category });
            }
            localStorage.setItem('cart', JSON.stringify(cart));
        }
    });

    // Run initial UI updates
    updateWishlistUI();
});

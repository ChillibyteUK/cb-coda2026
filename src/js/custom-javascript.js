// Add your custom JS here.

// Modern scroll animations using Intersection Observer
(function() {
  // Check for reduced motion preference
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  
  if (prefersReducedMotion) {
    // If user prefers reduced motion, make all elements immediately visible
    document.querySelectorAll('[data-aos]').forEach(el => {
      el.style.opacity = '1';
      el.style.transform = 'none';
    });
    return;
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('aos-animate');
        // Once animated, stop observing (animate once)
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px'
  });

  // Observe all elements with data-aos attribute
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-aos]').forEach(el => {
      observer.observe(el);
    });
  });
})();

document.querySelectorAll('.hub-team__grid').forEach(grid => {
    let openDetail = null;
    let openCard = null;

    function closeDetail(animated = true) {
        if (!openDetail) return;

        if (animated) {
            openDetail.classList.add('fade-out');
            openDetail.addEventListener('animationend', () => {
                if (openDetail) openDetail.remove();
                openDetail = null;
            }, { once: true });
        } else {
            openDetail.remove();
            openDetail = null;
        }

        if (openCard) openCard.classList.remove('active');
        if (openCard) openCard.setAttribute('aria-expanded', 'false');
        grid.classList.remove('has-detail');
        openCard = null;
    }

    grid.addEventListener('click', e => {
        const card = e.target.closest('.hub-team__card');
        if (!card) return;

        // toggle off if clicking same card again
        if (openCard === card) {
            closeDetail();
            return;
        }

        // clear previous detail
        closeDetail(false);

        // Find the detail-content sibling (now outside the button)
        const detailId = card.getAttribute('aria-controls');
        const hidden = detailId ? document.getElementById(detailId) : card.nextElementSibling;
        
        if (!hidden || !hidden.classList.contains('detail-content')) {
            console.error('detail-content not found');
            return;
        }
        
        const detail = document.createElement('div');
        detail.className = 'detail';
        detail.innerHTML = hidden.innerHTML;

        // insert after the correct row
        const cards = Array.from(grid.children).filter(el => el.classList.contains('hub-team__card'));
        const index = cards.indexOf(card);
        const cols = getComputedStyle(grid).gridTemplateColumns.split(' ').length;
        const rowEnd = Math.ceil((index + 1) / cols) * cols - 1;
        const insertAfter = cards[Math.min(rowEnd, cards.length - 1)];
        
        // Find the detail-content element after insertAfter card
        let insertPoint = insertAfter;
        if (insertAfter.nextElementSibling && insertAfter.nextElementSibling.classList.contains('detail-content')) {
            insertPoint = insertAfter.nextElementSibling;
        }
        
        insertPoint.insertAdjacentElement('afterend', detail);

        // mark active states
        card.classList.add('active');
        card.setAttribute('aria-expanded', 'true');
        grid.classList.add('has-detail');

        openDetail = detail;
        openCard = card;
    });

    // Keyboard support for team cards
    grid.addEventListener('keydown', e => {
        const card = e.target.closest('.hub-team__card');
        if (!card) return;
        
        // Enter or Space to toggle
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            card.click();
        }
        // Escape to close
        else if (e.key === 'Escape' && openCard === card) {
            e.preventDefault();
            closeDetail();
        }
    });

    // click outside to close
    document.addEventListener('click', e => {
        if (openDetail && !grid.contains(e.target)) {
            closeDetail();
        }
    });

    // close detail on resize
    window.addEventListener('resize', () => {
        closeDetail(false);
    });
});

// Back to top button functionality
(function() {
    // Create the back to top button
    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/></svg>';
    backToTopBtn.className = 'back-to-top';
    backToTopBtn.setAttribute('aria-label', 'Back to top');
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background-color: var(--col-light-gold);
        color: var(--col-simco-gold);
        border: none;
        cursor: pointer;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
    `;

    // Add hover effects
    backToTopBtn.addEventListener('mouseenter', () => {
        backToTopBtn.style.transform = 'translateY(-2px)';
        backToTopBtn.style.boxShadow = '0 6px 20px rgba(0,0,0,0.2)';
    });

    backToTopBtn.addEventListener('mouseleave', () => {
        backToTopBtn.style.transform = 'translateY(0)';
        backToTopBtn.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
    });

    // Add click handler to scroll to top
    backToTopBtn.addEventListener('click', () => {
        // Try to scroll to #top element first, fallback to top of page
        const topElement = document.getElementById('top');
        if (topElement) {
            topElement.scrollIntoView({ behavior: 'smooth' });
        } else {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    });

    // Append to body
    document.body.appendChild(backToTopBtn);

    // Show/hide button based on scroll position
    function toggleBackToTop() {
        const scrolled = window.scrollY;
        const viewportHeight = window.innerHeight;
        
        if (scrolled > viewportHeight) {
            backToTopBtn.style.opacity = '1';
            backToTopBtn.style.visibility = 'visible';
        } else {
            backToTopBtn.style.opacity = '0';
            backToTopBtn.style.visibility = 'hidden';
        }
    }

    // Listen for scroll events
    window.addEventListener('scroll', toggleBackToTop);
    
    // Check initial scroll position
    toggleBackToTop();
})();

// Highlight search term from URL parameter
(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const searchTerm = urlParams.get('highlight');
    if (searchTerm) {
        highlightText(searchTerm);
    }

    function highlightText(searchTerm) {
        const content = document.querySelector('main');
        if (!content) return;

        const walker = document.createTreeWalker(
            content,
            NodeFilter.SHOW_TEXT,
            {
                acceptNode: function(node) {
                    // Skip script and style elements
                    if (node.parentElement.tagName === 'SCRIPT' || 
                        node.parentElement.tagName === 'STYLE' ||
                        node.parentElement.classList.contains('search-result-item')) {
                        return NodeFilter.FILTER_REJECT;
                    }
                    return NodeFilter.FILTER_ACCEPT;
                }
            }
        );

        const nodesToReplace = [];
        let node;
        while (node = walker.nextNode()) {
            const text = node.nodeValue;
            const regex = new RegExp(searchTerm, 'gi');
            if (regex.test(text)) {
                nodesToReplace.push(node);
            }
        }

        nodesToReplace.forEach(node => {
            const text = node.nodeValue;
            const regex = new RegExp('(' + searchTerm.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
            const parent = node.parentElement;
            const fragment = document.createDocumentFragment();
            
            let lastIndex = 0;
            text.replace(regex, function(match, p1, offset) {
                if (offset > lastIndex) {
                    fragment.appendChild(document.createTextNode(text.slice(lastIndex, offset)));
                }
                const mark = document.createElement('mark');
                mark.textContent = match;
                mark.style.backgroundColor = '#AB965F';
                mark.style.color = '#fff';
                mark.style.padding = '2px 4px';
                fragment.appendChild(mark);
                lastIndex = offset + match.length;
            });
            
            if (lastIndex < text.length) {
                fragment.appendChild(document.createTextNode(text.slice(lastIndex)));
            }
            
            parent.replaceChild(fragment, node);
        });

        // Scroll to first highlight
        const firstMark = content.querySelector('mark');
        if (firstMark) {
            firstMark.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
})();

// Hamburger menu animation - toggle aria-expanded for offcanvas
(function() {
    const offcanvasElement = document.getElementById('offcanvasNavbar');
    const togglerButton = document.querySelector('[data-bs-toggle="offcanvas"]');
    
    if (offcanvasElement && togglerButton) {
        offcanvasElement.addEventListener('show.bs.offcanvas', function () {
            togglerButton.setAttribute('aria-expanded', 'true');
        });
        
        offcanvasElement.addEventListener('hide.bs.offcanvas', function () {
            togglerButton.setAttribute('aria-expanded', 'false');
        });
        
        // Fix duplicate IDs - add 'mobile-' prefix to all IDs in mobile menu
        const mobileMenu = offcanvasElement.querySelector('#mobile-menu');
        if (mobileMenu) {
            const elementsWithId = mobileMenu.querySelectorAll('[id]');
            elementsWithId.forEach(function(element) {
                const oldId = element.id;
                const newId = 'mobile-' + oldId;
                element.id = newId;
                
                // Update aria-labelledby references
                const labelledByElements = mobileMenu.querySelectorAll('[aria-labelledby="' + oldId + '"]');
                labelledByElements.forEach(function(el) {
                    el.setAttribute('aria-labelledby', newId);
                });
            });
            
            // Handle dropdown toggle behavior - close other dropdowns when opening one
            const dropdownToggles = mobileMenu.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdownToggles.forEach(function(toggle) {
                toggle.addEventListener('show.bs.dropdown', function(e) {
                    // Close all other open dropdowns
                    dropdownToggles.forEach(function(otherToggle) {
                        if (otherToggle !== toggle && otherToggle.classList.contains('show')) {
                            const otherDropdown = bootstrap.Dropdown.getInstance(otherToggle);
                            if (otherDropdown) {
                                otherDropdown.hide();
                            }
                        }
                    });
                });
                
                // Prevent dropdown from closing when clicking items inside it
                toggle.setAttribute('data-bs-auto-close', 'false');
            });
        }
    }
})();

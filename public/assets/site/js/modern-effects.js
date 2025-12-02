/**
 * Modern UI Effects - JavaScript
 * Scroll animations, dark mode, ripple effects, and more
 */

(function() {
    'use strict';

    // ============================================
    // 1. SCROLL ANIMATIONS (Intersection Observer)
    // ============================================
    const initScrollAnimations = () => {
        const animatedElements = document.querySelectorAll(
            '.scroll-animate, .scroll-animate-left, .scroll-animate-right, .scroll-animate-scale'
        );

        if (animatedElements.length === 0) return;

        const observerOptions = {
            root: null,
            rootMargin: '0px 0px -50px 0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    // Optionally unobserve after animation
                    // observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        animatedElements.forEach(el => observer.observe(el));
    };

    // ============================================
    // 2. SCROLL PROGRESS BAR
    // ============================================
    const initScrollProgress = () => {
        const progressBar = document.querySelector('.scroll-progress');
        if (!progressBar) return;

        const updateProgress = () => {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = (scrollTop / docHeight) * 100;
            progressBar.style.width = `${progress}%`;
        };

        window.addEventListener('scroll', updateProgress, { passive: true });
        updateProgress();
    };

    // ============================================
    // 3. DARK MODE TOGGLE
    // ============================================
    const initDarkMode = () => {
        const toggleBtn = document.querySelector('.theme-toggle');
        const html = document.documentElement;
        
        // Check for saved preference or system preference
        const savedTheme = localStorage.getItem('theme');
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        if (savedTheme) {
            html.setAttribute('data-theme', savedTheme);
        } else if (systemPrefersDark) {
            html.setAttribute('data-theme', 'dark');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                // Dispatch event for other scripts to listen
                window.dispatchEvent(new CustomEvent('themechange', { 
                    detail: { theme: newTheme } 
                }));
            });
        }

        // Listen for system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                html.setAttribute('data-theme', e.matches ? 'dark' : 'light');
            }
        });
    };

    // ============================================
    // 4. RIPPLE EFFECT FOR BUTTONS
    // ============================================
    const initRippleEffect = () => {
        const rippleButtons = document.querySelectorAll('.btn-ripple');
        
        rippleButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                ripple.style.left = `${x}px`;
                ripple.style.top = `${y}px`;
                
                this.appendChild(ripple);
                
                setTimeout(() => ripple.remove(), 600);
            });
        });
    };

    // ============================================
    // 5. MAGNETIC BUTTON EFFECT
    // ============================================
    const initMagneticButtons = () => {
        const magneticButtons = document.querySelectorAll('.btn-magnetic');
        
        magneticButtons.forEach(button => {
            button.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left - rect.width / 2;
                const y = e.clientY - rect.top - rect.height / 2;
                
                this.style.transform = `translate(${x * 0.3}px, ${y * 0.3}px)`;
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translate(0, 0)';
            });
        });
    };

    // ============================================
    // 6. SMOOTH SCROLL
    // ============================================
    const initSmoothScroll = () => {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    };

    // ============================================
    // 7. PARALLAX EFFECT
    // ============================================
    const initParallax = () => {
        const parallaxElements = document.querySelectorAll('.parallax');
        
        if (parallaxElements.length === 0) return;
        
        const handleScroll = () => {
            const scrollY = window.scrollY;
            
            parallaxElements.forEach(el => {
                const speed = el.dataset.speed || 0.5;
                const offset = scrollY * speed;
                el.style.transform = `translateY(${offset}px)`;
            });
        };
        
        window.addEventListener('scroll', handleScroll, { passive: true });
    };

    // ============================================
    // 8. TILT EFFECT FOR CARDS
    // ============================================
    const initTiltEffect = () => {
        const tiltCards = document.querySelectorAll('.card-3d');
        
        tiltCards.forEach(card => {
            card.addEventListener('mousemove', function(e) {
                const rect = this.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                
                const rotateX = (y - centerY) / 10;
                const rotateY = (centerX - x) / 10;
                
                this.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateZ(20px)`;
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) translateZ(0)';
            });
        });
    };

    // ============================================
    // 9. COUNTER ANIMATION
    // ============================================
    const initCounterAnimation = () => {
        const counters = document.querySelectorAll('.counter');
        
        const animateCounter = (el) => {
            const target = parseInt(el.dataset.target);
            const duration = parseInt(el.dataset.duration) || 2000;
            const start = 0;
            const startTime = performance.now();
            
            const updateCounter = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Easing function
                const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                const current = Math.floor(start + (target - start) * easeOutQuart);
                
                el.textContent = current.toLocaleString();
                
                if (progress < 1) {
                    requestAnimationFrame(updateCounter);
                }
            };
            
            requestAnimationFrame(updateCounter);
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        counters.forEach(counter => observer.observe(counter));
    };

    // ============================================
    // 10. LAZY LOADING IMAGES WITH FADE
    // ============================================
    const initLazyLoading = () => {
        const lazyImages = document.querySelectorAll('img[data-src]');
        
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                    img.classList.add('animate-fade-in');
                    imageObserver.unobserve(img);
                }
            });
        }, { rootMargin: '50px' });
        
        lazyImages.forEach(img => imageObserver.observe(img));
    };

    // ============================================
    // 11. STICKY HEADER EFFECT
    // ============================================
    const initStickyHeader = () => {
        const header = document.querySelector('.header-main');
        if (!header) return;
        
        let lastScroll = 0;
        
        window.addEventListener('scroll', () => {
            const currentScroll = window.scrollY;
            
            if (currentScroll > 100) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
            
            // Hide/show on scroll direction
            if (currentScroll > lastScroll && currentScroll > 200) {
                header.classList.add('header-hidden');
            } else {
                header.classList.remove('header-hidden');
            }
            
            lastScroll = currentScroll;
        }, { passive: true });
    };

    // ============================================
    // 12. CURSOR FOLLOWER
    // ============================================
    const initCursorFollower = () => {
        // Only on desktop
        if (window.innerWidth < 992) return;
        
        const cursor = document.querySelector('.cursor-follower');
        if (!cursor) return;
        
        let mouseX = 0, mouseY = 0;
        let cursorX = 0, cursorY = 0;
        
        document.addEventListener('mousemove', (e) => {
            mouseX = e.clientX;
            mouseY = e.clientY;
        });
        
        const animate = () => {
            cursorX += (mouseX - cursorX) * 0.1;
            cursorY += (mouseY - cursorY) * 0.1;
            
            cursor.style.left = `${cursorX}px`;
            cursor.style.top = `${cursorY}px`;
            
            requestAnimationFrame(animate);
        };
        
        animate();
        
        // Scale effect on interactive elements
        const interactiveElements = document.querySelectorAll('a, button, .cursor-hover');
        
        interactiveElements.forEach(el => {
            el.addEventListener('mouseenter', () => cursor.classList.add('cursor-hover'));
            el.addEventListener('mouseleave', () => cursor.classList.remove('cursor-hover'));
        });
    };

    // ============================================
    // 13. TYPING EFFECT
    // ============================================
    const initTypingEffect = () => {
        const typingElements = document.querySelectorAll('.typing-effect');
        
        typingElements.forEach(el => {
            const text = el.dataset.text || el.textContent;
            const speed = parseInt(el.dataset.speed) || 100;
            el.textContent = '';
            
            let i = 0;
            const type = () => {
                if (i < text.length) {
                    el.textContent += text.charAt(i);
                    i++;
                    setTimeout(type, speed);
                }
            };
            
            // Start when visible
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    type();
                    observer.unobserve(el);
                }
            });
            
            observer.observe(el);
        });
    };

    // ============================================
    // 14. SCROLL TO TOP BUTTON
    // ============================================
    const initScrollToTop = () => {
        const scrollBtn = document.getElementById('scrollTop');
        if (!scrollBtn) return;
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                scrollBtn.classList.add('visible');
            } else {
                scrollBtn.classList.remove('visible');
            }
        }, { passive: true });
        
        scrollBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    };

    // ============================================
    // 15. PRELOADER
    // ============================================
    const initPreloader = () => {
        const preloader = document.querySelector('.preloader');
        if (!preloader) return;
        
        window.addEventListener('load', () => {
            preloader.classList.add('preloader-hidden');
            setTimeout(() => preloader.remove(), 500);
        });
    };

    // ============================================
    // INITIALIZE ALL
    // ============================================
    const init = () => {
        initScrollAnimations();
        initScrollProgress();
        initRippleEffect();
        initMagneticButtons();
        initSmoothScroll();
        initParallax();
        initTiltEffect();
        initCounterAnimation();
        initLazyLoading();
        initStickyHeader();
        initCursorFollower();
        initTypingEffect();
        initScrollToTop();
        initPreloader();
        
        console.log('✨ Modern Effects initialized');
    };

    // Run on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
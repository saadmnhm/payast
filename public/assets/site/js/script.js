// Owl Carousel Initialization
$('.owl-carousel').owlCarousel({
    loop:true,
    dots:false,
    nav:true,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
})
// Owl Carousel Initialization
$('.owl-carousel2').owlCarousel({
    loop:true,
    dots:false,
    nav:true,
    responsive:{
        0:{
            items:3
        },
        600:{
            items:3
        },
        1000:{
            items:6
        }
    }
})
// filter dropdown
document.querySelectorAll('[id=btn-filter]').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        const dropdown = btn.nextElementSibling;

        document.querySelectorAll('[id=btn-filter]').forEach(other => {
            if (other === btn) return;
            other.classList.remove('active');
            const otherDropdown = other.nextElementSibling;
            if (otherDropdown) otherDropdown.classList.remove('show');
        });

        btn.classList.toggle('active');
        if (dropdown) dropdown.classList.toggle('show');
    });
});


// Owl Carousel Initialization
$('.owl-carousel').owlCarousel({
    loop:true,
    dots:false,
    nav:true,
    responsive:{
        0:{
            items:3,
            nav:false
        },
        600:{
            items:3,
            nav:false
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
            items:3,
            nav:false
        },
        600:{
            items:3,
            nav:false
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


 // Search functionality
function performSearch() {
    const query = document.getElementById('searchInput').value;
    if (query.trim()) {
        showNotification(`Recherche: ${query}`);
    }
}

// Vehicle search
function searchVehicle(e) {
    e.preventDefault();
    const brand = document.getElementById('brand').value;
    const model = document.getElementById('model').value;
    const version = document.getElementById('version').value;

    if (!brand) {
        alert('Veuillez sélectionner un constructeur');
        return;
    }

    showNotification('Recherche de pièces en cours...');
}



function filterCategory(category) {
    showNotification(`Catégorie: ${category}`);
}

// Scroll functions
function scrollToTop() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
}





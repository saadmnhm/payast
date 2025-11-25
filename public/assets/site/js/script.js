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


// Search functionality with AJAX suggestions
let searchTimeout;
let suggestionsDiv;

function initializeSearch() {
    const searchInputs = document.querySelectorAll('#searchInput');
    
    searchInputs.forEach(input => {
        // Create suggestions dropdown for each search input
        const dropdown = document.createElement('div');
        dropdown.className = 'search-suggestions-dropdown';
        dropdown.style.display = 'none';
        input.parentElement.style.position = 'relative';
        input.parentElement.appendChild(dropdown);
        
        // Add input event listener
        input.addEventListener('input', function(e) {
            const query = e.target.value;
            const suggestionsDropdown = this.parentElement.querySelector('.search-suggestions-dropdown');
            
            clearTimeout(searchTimeout);
            
            if (query.length < 2) {
                suggestionsDropdown.style.display = 'none';
                return;
            }
            
            searchTimeout = setTimeout(() => {
                fetchSuggestions(query, suggestionsDropdown);
            }, 300);
        });
        
        // Handle Enter key
        input.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    });
}

function fetchSuggestions(query, dropdown) {
    fetch(`/search/suggestions?q=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            displaySuggestions(data, dropdown);
        })
        .catch(error => console.error('Search error:', error));
}

function displaySuggestions(data, dropdown) {
    let html = '';
    
    // Brands
    if (data.brands && data.brands.length > 0) {
        html += '<div class="suggestions-section"><div class="suggestions-title">Marques</div>';
        data.brands.forEach(brand => {
            html += `<a href="/pieces?brand[]=${brand.id}" class="suggestion-item">
                <i class="fas fa-tag"></i> ${brand.label}
            </a>`;
        });
        html += '</div>';
    }
    
    // Categories
    if (data.categories && data.categories.length > 0) {
        html += '<div class="suggestions-section"><div class="suggestions-title">Catégories</div>';
        data.categories.forEach(category => {
            html += `<a href="/pieces?catalog[]=${category.id}" class="suggestion-item">
                <i class="fas fa-folder"></i> ${category.title}
            </a>`;
        });
        html += '</div>';
    }
    
    // Pieces
    if (data.pieces && data.pieces.length > 0) {
        html += '<div class="suggestions-section"><div class="suggestions-title">Pièces</div>';
        data.pieces.forEach(piece => {
            html += `<a href="/pieces?search=${encodeURIComponent(piece.name)}" class="suggestion-item">
                <i class="fas fa-cog"></i> ${piece.name}
                <span class="suggestion-price">${piece.price} DH</span>
            </a>`;
        });
        html += '</div>';
    }
    
    if (html === '') {
        html = '<div class="no-suggestions">Aucun résultat trouvé</div>';
    }
    
    dropdown.innerHTML = html;
    dropdown.style.display = 'block';
}

function performSearch() {
    const query = document.querySelector('#searchInput').value;
    if (query.trim()) {
        window.location.href = `/pieces?search=${encodeURIComponent(query)}`;
    }
}

// Close suggestions when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.search-bar')) {
        document.querySelectorAll('.search-suggestions-dropdown').forEach(dropdown => {
            dropdown.style.display = 'none';
        });
    }
});

// Initialize search when DOM is ready
document.addEventListener('DOMContentLoaded', initializeSearch);

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





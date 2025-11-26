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

function initializeSearch() {
    const searchInputs = document.querySelectorAll('#searchInput, #searchInputMobile');
    
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
                e.preventDefault();
                const isMobile = this.id === 'searchInputMobile';
                if (isMobile) {
                    performSearchMobile();
                } else {
                    performSearch();
                }
            }
        });
        
        // Focus event - show suggestions if there's a value
        input.addEventListener('focus', function() {
            if (this.value.length >= 2) {
                const suggestionsDropdown = this.parentElement.querySelector('.search-suggestions-dropdown');
                if (suggestionsDropdown && suggestionsDropdown.innerHTML) {
                    suggestionsDropdown.style.display = 'block';
                }
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
    let totalResults = 0;
    
    // Pieces first - most relevant
    if (data.pieces && data.pieces.length > 0) {
        totalResults += data.pieces.length;
        html += '<div class="suggestions-section"><div class="suggestions-title"><i class="fas fa-cog me-2"></i>Pièces trouvées</div>';
        data.pieces.slice(0, 10).forEach(piece => {
            html += `<a href="/piece/${piece.id}" class="suggestion-item piece-item">
                <div class="suggestion-piece-info">
                    <span class="suggestion-text">${highlightMatch(piece.name, dropdown.dataset.query || '')}</span>
                    ${piece.reference ? `<small class="text-muted d-block">Réf: ${highlightMatch(piece.reference, dropdown.dataset.query || '')}</small>` : ''}
                </div>
                <span class="suggestion-price">${parseFloat(piece.price).toFixed(2)} DH</span>
            </a>`;
        });
        html += '</div>';
    }
    
    // Brands
    if (data.brands && data.brands.length > 0) {
        totalResults += data.brands.length;
        html += '<div class="suggestions-section"><div class="suggestions-title"><i class="fas fa-tag me-2"></i>Marques</div>';
        data.brands.slice(0, 6).forEach(brand => {
            html += `<a href="/pieces?brand[]=${brand.id}" class="suggestion-item">
                <span class="suggestion-text">${highlightMatch(brand.label, dropdown.dataset.query || '')}</span>
                <i class="fas fa-arrow-right suggestion-arrow"></i>
            </a>`;
        });
        html += '</div>';
    }
    
    // Categories
    if (data.categories && data.categories.length > 0) {
        totalResults += data.categories.length;
        html += '<div class="suggestions-section"><div class="suggestions-title"><i class="fas fa-folder me-2"></i>Catégories</div>';
        data.categories.slice(0, 6).forEach(category => {
            html += `<a href="/pieces?catalog[]=${category.id}" class="suggestion-item">
                <span class="suggestion-text">${highlightMatch(category.title, dropdown.dataset.query || '')}</span>
                <i class="fas fa-arrow-right suggestion-arrow"></i>
            </a>`;
        });
        html += '</div>';
    }
    
    if (html === '') {
        html = '<div class="no-suggestions"><i class="fas fa-search me-2"></i>Aucun résultat trouvé pour votre recherche</div>';
    } else {
        // Add "See all results" link
        const query = dropdown.dataset.query || '';
        html += `<div class="suggestions-footer">
            <a href="/pieces?search=${encodeURIComponent(query)}" class="btn-see-all">
                Voir tous les résultats (${totalResults}+) <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>`;
    }
    
    dropdown.innerHTML = html;
    dropdown.style.display = 'block';
    dropdown.dataset.query = dropdown.dataset.query || '';
}

function highlightMatch(text, query) {
    if (!query) return text;
    const regex = new RegExp(`(${query})`, 'gi');
    return text.replace(regex, '<strong>$1</strong>');
}

function performSearch() {
    const input = document.querySelector('#searchInput');
    const query = input ? input.value : '';
    if (query.trim()) {
        window.location.href = `/pieces?search=${encodeURIComponent(query)}`;
    }
}

function performSearchMobile() {
    const input = document.querySelector('#searchInputMobile');
    const query = input ? input.value : '';
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





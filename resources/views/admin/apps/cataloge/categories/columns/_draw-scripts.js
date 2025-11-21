// Initialize KTMenu
KTMenu.createInstances();

// Search functionality
const filterSearch = document.querySelector('[data-kt-category-table-filter="search"]');
if (filterSearch) {
    filterSearch.addEventListener('keyup', function (e) {
        window.LaravelDataTables['catalog-categories-table'].search(e.target.value).draw();
    });
}

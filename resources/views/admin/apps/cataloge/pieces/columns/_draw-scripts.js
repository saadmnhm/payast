// Initialize KTMenu
KTMenu.createInstances();

// Search functionality
const filterSearch = document.querySelector('[data-kt-piece-table-filter="search"]');
if (filterSearch) {
    filterSearch.addEventListener('keyup', function (e) {
        window.LaravelDataTables['pieces-table'].search(e.target.value).draw();
    });
}

// Initialize KTMenu
KTMenu.createInstances();

// Search functionality
const filterSearch = document.querySelector('[data-kt-order-table-filter="search"]');
if (filterSearch) {
    filterSearch.addEventListener('keyup', function (e) {
        window.LaravelDataTables['orders-table'].search(e.target.value).draw();
    });
}

// Status filter
const filterStatus = document.querySelector('[data-kt-order-table-filter="status"]');
if (filterStatus) {
    filterStatus.addEventListener('change', function (e) {
        window.LaravelDataTables['orders-table'].column(4).search(e.target.value).draw();
    });
}

// Reset filter
const resetButton = document.querySelector('[data-kt-order-table-filter="reset"]');
if (resetButton) {
    resetButton.addEventListener('click', function () {
        filterStatus.value = '';
        filterSearch.value = '';
        window.LaravelDataTables['orders-table'].search('').columns().search('').draw();
    });
}

// Apply filter
const filterButton = document.querySelector('[data-kt-order-table-filter="filter"]');
if (filterButton) {
    filterButton.addEventListener('click', function () {
        window.LaravelDataTables['orders-table'].draw();
    });
}
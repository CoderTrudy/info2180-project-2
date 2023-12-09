document.addEventListener("DOMContentLoaded", function () {
    var filterOptions = document.querySelectorAll('.filter-option');
    filterOptions.forEach(function (option) {
        option.addEventListener('click', function () {
            // Remove underline from all options
            filterOptions.forEach(function (opt) {
                opt.style.textDecoration = 'none';
            });

            // Underline the clicked option
            option.style.textDecoration = 'underline';

            // Perform the filter action or update the selected value as needed
            // Example: document.getElementById('filter').value = option.dataset.value;
        });
    });
});
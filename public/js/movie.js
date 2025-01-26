document.addEventListener('DOMContentLoaded', function () {
    const genreSelect = document.querySelector('select[name="genre"]');
    const distributorSelect = document.querySelector('select[name="distributor"]');

    if (genreSelect) {
        genreSelect.addEventListener('change', function () {
            document.querySelector('.search-form').submit();
        });
    }

    if (distributorSelect) {
        distributorSelect.addEventListener('change', function () {
            document.querySelector('.search-form').submit();
        });
    }
});
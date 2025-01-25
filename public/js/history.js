document.addEventListener('DOMContentLoaded', function () {
    const historyButtons = document.querySelectorAll('.button.history');
    const historyModal = document.getElementById('historyModal');
    const closeHistoryModal = historyModal.querySelector('.close-modal');
    const historyList = document.getElementById('historyList');

    historyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            if (historyModal) {
                historyModal.style.display = 'block';
                loadUserHistory(userId);
            }
        });
    });

    if (closeHistoryModal) {
        closeHistoryModal.addEventListener('click', function () {
            historyModal.style.display = 'none';
        });
    }

    window.addEventListener('click', function (event) {
        if (event.target === historyModal) {
            historyModal.style.display = 'none';
        }
    });

    function loadUserHistory(userId) {
        fetch(`${BASE_URL}/api/history/getUserHistory.php?userId=${userId}`)
            .then(response => response.json())
            .then(data => {
                historyList.innerHTML = '';

                if (data.error) {
                    console.error(data.error);
                    return;
                }

                if (data.length > 0) {
                    data.forEach(movie => {
                        const listItem = document.createElement('li');
                        listItem.textContent = `${movie.title} - ${movie.room_name} (${movie.movie_begin})`;
                        historyList.appendChild(listItem);
                    });
                } else {
                    const listItem = document.createElement('li');
                    listItem.textContent = 'No movie history found.';
                    historyList.appendChild(listItem);
                }
            })
            .catch(error => {
                console.error('Error loading movie history:', error);
                const listItem = document.createElement('li');
                listItem.textContent = 'Error loading movie history.';
                historyList.appendChild(listItem);
            });
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const historyButtons = document.querySelectorAll('.button.history');
    const historyModal = document.getElementById('historyModal');
    const addHistoryModal = document.getElementById('addHistoryModal');
    const closeHistoryModal = historyModal.querySelector('.close-modal');
    const closeAddHistoryModal = addHistoryModal.querySelector('.close-modal');
    const addHistoryButton = document.getElementById('addHistoryButton');
    const historyList = document.getElementById('historyList');
    const addHistoryForm = document.getElementById('addHistoryForm');
    const historyRoomSelect = document.getElementById('historyRoomId');

    historyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id');
            if (historyModal) {
                historyModal.style.display = 'block';
                document.getElementById('userId').value = userId;
                loadUserHistory(userId);
            }
        });
    });

    if (addHistoryButton) {
        addHistoryButton.addEventListener('click', function () {
            historyModal.style.display = 'none';
            addHistoryModal.style.display = 'block';
            loadMoviesAndRooms();
        });
    }

    if (closeHistoryModal) {
        closeHistoryModal.addEventListener('click', function () {
            historyModal.style.display = 'none';
        });
    }

    if (closeAddHistoryModal) {
        closeAddHistoryModal.addEventListener('click', function () {
            addHistoryModal.style.display = 'none';
        });
    }

    window.addEventListener('click', function (event) {
        if (event.target === historyModal) {
            historyModal.style.display = 'none';
        }
        if (event.target === addHistoryModal) {
            addHistoryModal.style.display = 'none';
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

    function loadMoviesAndRooms() {
        fetch(`${BASE_URL}/api/movies/getMovies.php`)
            .then(response => response.json())
            .then(data => {
                const movieSelect = document.getElementById('movieId');
                movieSelect.innerHTML = '';

                if (data.error) {
                    console.error(data.error);
                    return;
                }

                if (data.length > 0) {
                    data.forEach(movie => {
                        const option = document.createElement('option');
                        option.value = movie.id;
                        option.textContent = movie.title;
                        movieSelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error loading movies:', error);
            });

        fetch(`${BASE_URL}/api/rooms/getRooms.php`)
            .then(response => response.json())
            .then(data => {
                if (historyRoomSelect) {
                    historyRoomSelect.innerHTML = '';

                    if (data.error) {
                        console.error(data.error);
                        return;
                    }

                    if (data.length > 0) {
                        data.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.id;
                            option.textContent = room.name;
                            historyRoomSelect.appendChild(option);
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error loading rooms:', error);
            });
    }

    if (addHistoryForm) {
        addHistoryForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const userId = document.getElementById('userId').value;
            const movieId = document.getElementById('movieId').value;
            const roomId = document.getElementById('historyRoomId').value;
            const movieDate = document.getElementById('movieDate').value;

            fetch(`${BASE_URL}/api/history/addHistory.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ userId, movieId, roomId, movieDate })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Movie added to history successfully!');
                        addHistoryModal.style.display = 'none';
                        historyModal.style.display = 'block';
                        loadUserHistory(userId);
                    } else {
                        alert('Error: ' + (data.message || 'Failed to add movie to history.'));
                    }
                })
                .catch(error => {
                    console.error('Error adding movie to history:', error);
                    alert('Error adding movie to history.');
                });
        });
    }
});
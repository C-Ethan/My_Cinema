document.addEventListener('DOMContentLoaded', function () {
    const sessionButtons = document.querySelectorAll('.button.session');
    const sessionModal = document.getElementById('sessionModal');

    if (sessionButtons && sessionModal) {
        sessionButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const movieId = this.getAttribute('data-movie-id');
                if (sessionModal) {
                    sessionModal.style.display = 'block';
                    document.getElementById('sessionMovieId').value = movieId;
                    loadRooms();
                }
            });
        });
    }

    const closeButtons = document.querySelectorAll('.close-modal');

    closeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const modal = this.closest('.modal');
            if (modal) {
                modal.style.display = 'none';
            }
        });
    });

    window.addEventListener('click', function (event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    });

    const createSessionForm = document.getElementById('createSessionForm');

    if (createSessionForm) {
        createSessionForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const movieId = document.getElementById('sessionMovieId').value;
            const roomId = document.getElementById('sessionRoomId').value;
            const sessionDate = document.getElementById('sessionDate').value;

            fetch(`${BASE_URL}/api/sessions/createSession.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ movieId, roomId, sessionDate })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Session created successfully!');
                        sessionModal.style.display = 'none';
                        if (document.getElementById('sessionsList')) {
                            loadSessions();
                        }
                    } else {
                        alert('Error: ' + (data.message || 'Failed to create session.'));
                    }
                })
                .catch(error => {
                    console.error('Error creating session:', error);
                    alert('Error creating session.');
                });
        });
    }

    const sessionsList = document.getElementById('sessionsList');

    if (sessionsList) {
        loadSessions();

        function loadSessions() {
            fetch(`${BASE_URL}/api/sessions/getSessions.php`)
                .then(response => response.json())
                .then(data => {
                    sessionsList.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(session => {
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td>${session.movie_title}</td>
                                <td>${session.room_name}</td>
                                <td>${session.session_date}</td>
                                <td>
                                    <button class="button deletesession" data-session-id="${session.id}">Delete</button>
                                </td>
                            `;
                            sessionsList.appendChild(row);
                        });

                        const deleteButtons = document.querySelectorAll('.button.deletesession');
                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function () {
                                const sessionId = this.getAttribute('data-session-id');
                                deleteSession(sessionId);
                            });
                        });
                    } else {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td colspan="4">No sessions found.</td>`;
                        sessionsList.appendChild(row);
                    }
                })
                .catch(error => {
                    console.error('Error loading sessions:', error);
                });
        }

        function deleteSession(sessionId) {
            if (confirm('Are you sure you want to delete this session?')) {
                fetch(`${BASE_URL}/api/sessions/deleteSession.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ sessionId })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Session deleted successfully!');
                            loadSessions();
                        } else {
                            alert('Error: ' + (data.message || 'Failed to delete session.'));
                        }
                    })
                    .catch(error => {
                        console.error('Error deleting session:', error);
                        alert('Error deleting session.');
                    });
            }
        }
    }

    function loadRooms() {
        const sessionRoomSelect = document.getElementById('sessionRoomId');

        if (sessionRoomSelect) {
            fetch(`${BASE_URL}/api/rooms/getRooms.php`)
                .then(response => response.json())
                .then(data => {
                    sessionRoomSelect.innerHTML = '';

                    if (data.length > 0) {
                        data.forEach(room => {
                            const option = document.createElement('option');
                            option.value = room.id;
                            option.textContent = room.name;
                            sessionRoomSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading rooms:', error);
                });
        }
    }
});
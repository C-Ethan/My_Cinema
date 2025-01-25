document.addEventListener('DOMContentLoaded', function () {
    const historyButtons = document.querySelectorAll('.button.history'); // Boutons "History"
    const historyModal = document.getElementById('historyModal'); // Modal pour l'historique
    const closeHistoryModal = historyModal.querySelector('.close-modal'); // Bouton pour fermer la modal
    const historyList = document.getElementById('historyList'); // Liste pour afficher l'historique

    // Ouvrir la modal et charger l'historique des films
    historyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const userId = this.getAttribute('data-user-id'); // Récupérer l'ID de l'utilisateur
            if (historyModal) {
                historyModal.style.display = 'block'; // Afficher la modal
                loadUserHistory(userId); // Charger l'historique des films
            }
        });
    });

    // Fermer la modal
    if (closeHistoryModal) {
        closeHistoryModal.addEventListener('click', function () {
            historyModal.style.display = 'none';
        });
    }

    // Fermer la modal en cliquant en dehors
    window.addEventListener('click', function (event) {
        if (event.target === historyModal) {
            historyModal.style.display = 'none';
        }
    });

    // Fonction pour charger l'historique des films
    function loadUserHistory(userId) {
        fetch(`${BASE_URL}/api/history/getUserHistory.php?userId=${userId}`)
            .then(response => response.json())
            .then(data => {
                historyList.innerHTML = ''; // Vider la liste actuelle

                if (data.error) {
                    console.error(data.error);
                    return;
                }

                // Afficher les films dans la liste
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
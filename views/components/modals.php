<!-- Modal for subscription management -->
<div id="subscriptionModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Manage Subscriptions</h2>
        <ul id="subscriptionList"></ul>
        <form id="addSubscriptionForm">
            <input type="hidden" id="userId" name="userId">
            <select id="subscriptionId" name="subscriptionId">
            </select>
            <button type="submit" class="button add">Add Subscription</button>
            <button type="button" id="modifySubscriptionButton" class="button modify">Modify Subscription</button>
        </form>
    </div>
</div>

<!-- Modal for movie history -->
<div id="historyModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Movie History</h2>
        <ul id="historyList"></ul>
    </div>
</div>

<!-- Modal to add a movie to history -->
<div id="addHistoryModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Ajouter un film à l'historique</h2>
        <form id="addHistoryForm">
            <label for="movieId">Film :</label>
            <select id="movieId" name="movieId">
            </select>

            <label for="roomId">Salle :</label>
            <select id="roomId" name="roomId">
            </select>

            <label for="movieDate">Date :</label>
            <input type="datetime-local" id="movieDate" name="movieDate" required>

            <button type="submit" class="button add">Ajouter à l'historique</button>
        </form>
    </div>
</div>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>
<script src="<?= BASE_URL ?>/public/js/subscription.js"></script>
<script src="<?= BASE_URL ?>/public/js/history.js"></script>
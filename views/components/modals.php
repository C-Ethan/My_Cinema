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

<div id="historyModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Movie History</h2>
        <ul id="historyList"></ul>
        <button id="addHistoryButton" class="button add">Ajouter un film</button>
    </div>
</div>

<div id="addHistoryModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Ajouter un film à l'historique</h2>
        <form id="addHistoryForm">
            <input type="hidden" id="userId" name="userId">

            <div class="form-group">
                <label for="movieId">Film :</label>
                <select id="movieId" name="movieId" class="form-control">
                </select>
            </div>

            <div class="form-group">
                <label for="roomId">Salle :</label>
                <select id="roomId" name="roomId" class="form-control">
                </select>
            </div>

            <div class="form-group">
                <label for="movieDate">Date :</label>
                <input type="datetime-local" id="movieDate" name="movieDate" class="form-control" required min="1900-01-01T00:00" max="2100-12-31T23:59">
            </div>

            <button type="submit" class="button add">Ajouter à l'historique</button>
        </form>
    </div>
</div>

<script>const BASE_URL = "<?= BASE_URL ?>";</script>
<script src="<?= BASE_URL ?>/public/js/subscription.js"></script>
<script src="<?= BASE_URL ?>/public/js/history.js"></script>
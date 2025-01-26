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
        <button id="addHistoryButton" class="button add">Add a movie</button>
        <ul id="historyList"></ul>
    </div>
</div>

<div id="addHistoryModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Add a movie to history</h2>
        <form id="addHistoryForm">
            <input type="hidden" id="userId" name="userId">

            <div class="form-group">
                <label for="movieId">Movie :</label>
                <select id="movieId" name="movieId" class="form-control">
                </select>
            </div>

            <div class="form-group">
                <label for="historyRoomId">Room :</label>
                <select id="historyRoomId" name="roomId" class="form-control">
                </select>
            </div>

            <div class="form-group">
                <label for="movieDate">Date :</label>
                <input type="datetime-local" id="movieDate" name="movieDate" class="form-control" required min="1900-01-01T00:00" max="2100-12-31T23:59">
            </div>

            <button type="submit" class="button add">Add to history</button>
        </form>
    </div>
</div>

<div id="sessionModal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Create a Viewing Session</h2>
        <form id="createSessionForm">
            <input type="hidden" id="sessionMovieId" name="movieId">

            <div class="form-group">
                <label for="sessionRoomId">Room:</label>
                <select id="sessionRoomId" name="roomId" class="form-control">
                </select>
            </div>

            <div class="form-group">
                <label for="sessionDate">Date and Time:</label>
                <input type="datetime-local" id="sessionDate" name="sessionDate" class="form-control" required min="1900-01-01T00:00" max="2100-12-31T23:59">
            </div>

            <button type="submit" class="button add">Create Session</button>
        </form>
    </div>
</div>

<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>

<script src="<?= BASE_URL ?>/public/js/subscription.js"></script>
<script src="<?= BASE_URL ?>/public/js/history.js"></script>
<script src="<?= BASE_URL ?>/public/js/session.js"></script>
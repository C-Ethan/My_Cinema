document.addEventListener('DOMContentLoaded', function () {
  const modalTriggers = document.querySelectorAll('.button.subscription');
  const modal = document.getElementById('subscriptionModal');
  const closeBtn = document.querySelector('.close-modal');
  const addSubscriptionForm = document.getElementById('addSubscriptionForm');
  const modifySubscriptionButton = document.getElementById('modifySubscriptionButton');
  const addSubscriptionButton = document.querySelector('#addSubscriptionForm button.add');

  let currentSubscriptionId = null; // Variable to store the current subscription ID

  function loadSubscriptions(userId) {
    fetch(`${BASE_URL}/api/subscriptions/getSubscriptions.php?userId=${userId}`)
        .then(response => response.json())
        .then(data => {
            const subscriptionList = document.getElementById('subscriptionList');
            const subscriptionSelect = document.getElementById('subscriptionId');
            subscriptionList.innerHTML = '';
            subscriptionSelect.innerHTML = '';

            if (data.error) {
                showAlert(data.error, false);
                return;
            }

            // Store the current subscription ID (if it exists)
            if (data.userSubscriptions && data.userSubscriptions.length > 0) {
                currentSubscriptionId = data.userSubscriptions[0].id;
                if (addSubscriptionButton) addSubscriptionButton.style.display = 'none';
                if (modifySubscriptionButton) modifySubscriptionButton.style.display = 'inline-block';
            } else {
                currentSubscriptionId = null;
                if (addSubscriptionButton) addSubscriptionButton.style.display = 'inline-block';
                if (modifySubscriptionButton) modifySubscriptionButton.style.display = 'none';
            }

            if (data.userSubscriptions && data.userSubscriptions.length > 0) {
                data.userSubscriptions.forEach(subscription => {
                    const listItem = document.createElement('li');
                    listItem.textContent = subscription.name;

                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Delete';
                    deleteButton.classList.add('button', 'deletesubs');
                    deleteButton.addEventListener('click', function () {
                        deleteSubscription(userId, subscription.id);
                    });

                    listItem.appendChild(deleteButton);
                    subscriptionList.appendChild(listItem);
                });
            }

            if (data.allSubscriptions && data.allSubscriptions.length > 0) {
                data.allSubscriptions.forEach(subscription => {
                    const option = document.createElement('option');
                    option.value = subscription.id;
                    option.textContent = subscription.name;
                    subscriptionSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading subscriptions:', error);
            showAlert('Error loading subscriptions', false);
        });
}

  function addSubscription(userId, subscriptionId) {
      fetch(`${BASE_URL}/api/subscriptions/addSubscription.php`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ userId, subscriptionId })
      })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  showAlert('Subscription added successfully!');
                  loadSubscriptions(userId);
              } else {
                  showAlert(data.message || 'Failed to add subscription', false);
              }
          })
          .catch(error => {
              console.error('Error adding subscription:', error);
              showAlert('Error adding subscription', false);
          });
  }

  function deleteSubscription(userId, subscriptionId) {
      if (confirm('Are you sure you want to delete this subscription?')) {
          fetch(`${BASE_URL}/api/subscriptions/deleteSubscription.php`, {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json'
              },
              body: JSON.stringify({ userId, subscriptionId })
          })
              .then(response => response.json())
              .then(data => {
                  if (data.success) {
                      showAlert('Subscription deleted successfully!');
                      loadSubscriptions(userId);
                  } else {
                      showAlert(data.message || 'Failed to delete subscription', false);
                  }
              })
              .catch(error => {
                  console.error('Error deleting subscription:', error);
                  showAlert('Error deleting subscription', false);
              });
      }
  }

  function modifySubscription(userId, currentSubscriptionId, newSubscriptionId) {
      fetch(`${BASE_URL}/api/subscriptions/modifySubscription.php`, {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json'
          },
          body: JSON.stringify({ userId, currentSubscriptionId, newSubscriptionId })
      })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  showAlert('Subscription modified successfully!');
                  loadSubscriptions(userId);
              } else {
                  showAlert(data.message || 'Failed to modify subscription', false);
              }
          })
          .catch(error => {
              console.error('Error modifying subscription:', error);
              showAlert('Error modifying subscription', false);
          });
  }

  modalTriggers.forEach(button => {
      button.addEventListener('click', function () {
          const userId = this.getAttribute('data-user-id');
          if (modal) {
              modal.style.display = 'block';
              document.getElementById('userId').value = userId;
              loadSubscriptions(userId);
          }
      });
  });

  if (closeBtn) {
      closeBtn.addEventListener('click', function () {
          modal.style.display = 'none';
      });
  }

  window.addEventListener('click', function (event) {
      if (event.target === modal) {
          modal.style.display = 'none';
      }
  });

  if (addSubscriptionForm) {
      addSubscriptionForm.addEventListener('submit', function (event) {
          event.preventDefault();

          const userId = document.getElementById('userId').value;
          const subscriptionId = document.getElementById('subscriptionId').value;

          addSubscription(userId, subscriptionId);
      });
  }

  if (modifySubscriptionButton) {
      modifySubscriptionButton.addEventListener('click', function () {
          const userId = document.getElementById('userId').value;
          const newSubscriptionId = document.getElementById('subscriptionId').value;

          if (currentSubscriptionId) {
              modifySubscription(userId, currentSubscriptionId, newSubscriptionId);
          } else {
              showAlert('No current subscription to modify.', false);
          }
      });
  }
});
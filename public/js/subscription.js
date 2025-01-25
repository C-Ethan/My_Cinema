document.addEventListener('DOMContentLoaded', function () {
  const modalTriggers = document.querySelectorAll('.button.subscription');
  const modal = document.getElementById('subscriptionModal');
  const closeBtn = document.querySelector('.close-modal');
  const addSubscriptionForm = document.getElementById('addSubscriptionForm');
  const modifySubscriptionButton = document.getElementById('modifySubscriptionButton');
  const addSubscriptionButton = document.querySelector('#addSubscriptionForm button.add');

  let currentSubscriptionId = null; // Variable to store the current subscription ID

  // Function to display a success or error alert
  function showAlert(message, isSuccess = true) {
      if (isSuccess) {
          alert(message);
      } else {
          alert('Error: ' + message);
      }
  }

  // Function to load a user's subscriptions
  function loadSubscriptions(userId) {
      fetch(`${BASE_URL}/api/subscriptions/getSubscriptions.php?userId=${userId}`)
          .then(response => response.json())
          .then(data => {
              const subscriptionList = document.getElementById('subscriptionList');
              subscriptionList.innerHTML = ''; // Clear the current list

              if (data.error) {
                  showAlert(data.error, false);
                  return;
              }

              // Store the current subscription ID (if it exists)
              if (data.length > 0) {
                  currentSubscriptionId = data[0].id; // Assume a user has only one subscription
                  if (addSubscriptionButton) addSubscriptionButton.style.display = 'none';
                  if (modifySubscriptionButton) modifySubscriptionButton.style.display = 'inline-block';
              } else {
                  currentSubscriptionId = null;
                  if (addSubscriptionButton) addSubscriptionButton.style.display = 'inline-block';
                  if (modifySubscriptionButton) modifySubscriptionButton.style.display = 'none';
              }

              // Display subscriptions in the list
              data.forEach(subscription => {
                  const listItem = document.createElement('li');
                  listItem.textContent = subscription.name;

                  // Add a button to delete the subscription
                  const deleteButton = document.createElement('button');
                  deleteButton.textContent = 'Delete';
                  deleteButton.classList.add('button', 'deletesubs');
                  deleteButton.addEventListener('click', function () {
                      deleteSubscription(userId, subscription.id);
                  });

                  listItem.appendChild(deleteButton);
                  subscriptionList.appendChild(listItem);
              });
          })
          .catch(error => {
              console.error('Error loading subscriptions:', error);
              showAlert('Error loading subscriptions', false);
          });
  }

  // Function to add a subscription
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
                  loadSubscriptions(userId); // Reload the subscription list
              } else {
                  showAlert(data.message || 'Failed to add subscription', false);
              }
          })
          .catch(error => {
              console.error('Error adding subscription:', error);
              showAlert('Error adding subscription', false);
          });
  }

  // Function to delete a subscription
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
                      loadSubscriptions(userId); // Reload the subscription list
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

  // Function to modify a subscription
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
                  loadSubscriptions(userId); // Reload the subscription list
              } else {
                  showAlert(data.message || 'Failed to modify subscription', false);
              }
          })
          .catch(error => {
              console.error('Error modifying subscription:', error);
              showAlert('Error modifying subscription', false);
          });
  }

  // Open the modal and load subscriptions
  modalTriggers.forEach(button => {
      button.addEventListener('click', function () {
          const userId = this.getAttribute('data-user-id');
          if (modal) {
              modal.style.display = 'block';
              document.getElementById('userId').value = userId; // Set the user ID in the form
              loadSubscriptions(userId); // Load the user's subscriptions
          }
      });
  });

  // Close the modal
  if (closeBtn) {
      closeBtn.addEventListener('click', function () {
          modal.style.display = 'none';
      });
  }

  // Close the modal by clicking outside
  window.addEventListener('click', function (event) {
      if (event.target === modal) {
          modal.style.display = 'none';
      }
  });

  // Event handler for the add subscription form
  if (addSubscriptionForm) {
      addSubscriptionForm.addEventListener('submit', function (event) {
          event.preventDefault(); // Prevent page reload

          const userId = document.getElementById('userId').value;
          const subscriptionId = document.getElementById('subscriptionId').value;

          addSubscription(userId, subscriptionId); // Call the function to add a subscription
      });
  }

  // Event handler for the modify subscription button
  if (modifySubscriptionButton) {
      modifySubscriptionButton.addEventListener('click', function () {
          const userId = document.getElementById('userId').value;
          const newSubscriptionId = document.getElementById('subscriptionId').value;

          if (currentSubscriptionId) {
              modifySubscription(userId, currentSubscriptionId, newSubscriptionId); // Call the function to modify a subscription
          } else {
              showAlert('No current subscription to modify.', false);
          }
      });
  }
});
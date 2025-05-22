/* search script */
const searchBar = document.querySelector('.search_bar');
if (searchBar) {
   searchBar.addEventListener('submit', function (event) {
      event.preventDefault(); // Prevent the default form submission
      const query = document.querySelector('input[name="query"]').value;
      window.location.href = `index.php?query=${encodeURIComponent(query)}`;
   });
}

/* hamburger menu script */
const menuToggle = document.querySelector('#menu_toggle');
const navMenu = document.querySelector('#nav_menu');
if (menuToggle && navMenu) {
   menuToggle.addEventListener('click', () => {
      navMenu.classList.toggle('active');
   });

   document.addEventListener('click', (event) => {
      if (!navMenu.contains(event.target)) {
         navMenu.classList.remove('active');
      }
   });
}

/* when the page reloads after submitting the search, the input field retains the text in the search-bar */
const urlParams = new URLSearchParams(window.location.search);   // global variable urlParams

const query = urlParams.get('query');
if (query) {
   const queryInput = document.querySelector('input[name="query"]');
   if (queryInput) {
      queryInput.value = query;
   }
}

/* when the page reloads after selecting the category, the input field retains the selected category*/
const category = urlParams.get('category');
if (category) {
   const radio = document.querySelector(`input[name="category"][value="${category}"]`);
   if (radio) {
      radio.checked = true;
   }
}

/* when the page reloads after submitting the rating range, the input field retains the selected range */
const ratingRange = urlParams.get('rating_range');
if (ratingRange) {
   const radio = document.querySelector(`input[name="rating_range"][value="${ratingRange}"]`);
   if (radio) {
      radio.checked = true;
   }
}

/* when the page reloads after submitting the price range, the input field retains the selected range */
const priceRange = urlParams.get('price_range');
if (priceRange) {
   const radio = document.querySelector(`input[name="price_range"][value="${priceRange}"]`);
   if (radio) {
      radio.checked = true;
   }
}

/* category button script */
const categoryButton = document.querySelector('#category');
const dropdownMenu = document.querySelector('.category_menu');
if (categoryButton && dropdownMenu) {
   categoryButton.addEventListener('click', () => {
      dropdownMenu.classList.toggle('visible');
   });

   /* detect clicks outside of the "Category" button and its dropdown menu. */
   document.addEventListener('click', (event) => {
      if (!categoryButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
         dropdownMenu.classList.remove('visible');
      }
   });
}

/* price button script */
const priceButton = document.querySelector('#price');
const priceMenu = document.querySelector('.price_menu');
if (priceButton && priceMenu) {
   priceButton.addEventListener('click', () => {
      priceMenu.classList.toggle('visible');
   });

   /* detect clicks outside of the "Price" button and its dropdown menu. */
   document.addEventListener('click', (event) => {
      if (!priceButton.contains(event.target) && !priceMenu.contains(event.target)) {
         priceMenu.classList.remove('visible');
      }
   });
}

/* rating button script */
const ratingButton = document.querySelector('#rating');
const ratingMenu = document.querySelector('.rating_menu');
if (ratingButton && ratingMenu) {
   ratingButton.addEventListener('click', () => {
      ratingMenu.classList.toggle('visible');
   });

   /* detect clicks outside of the "Rating" button and its dropdown menu. */
   document.addEventListener('click', (event) => {
      if (!ratingButton.contains(event.target) && !ratingMenu.contains(event.target)) {
         ratingMenu.classList.remove('visible');
      }
   });
}

/* clear button script */
const clearButtons = document.querySelectorAll('.clear_button');
clearButtons.forEach(button => {
   button.addEventListener('click', () => {
      const target = button.dataset.clear;
      const radios = document.querySelectorAll(`input[name="${target}_range"]`);
      radios.forEach(radio => (radio.checked = false));
   });
});

/* category rating filter */
function applyCategoryFilter() {
   const selectedCategory = document.querySelector('input[name="category"]:checked').value;
   const urlParams = new URLSearchParams(window.location.search);
   urlParams.set('category', selectedCategory);
   window.location.search = urlParams.toString();
}

function clearCategoryFilter() {
   const urlParams = new URLSearchParams(window.location.search);
   urlParams.delete('category');
   window.location.search = urlParams.toString();
}

/* rating filter script */
function applyRatingFilter() {
   const selectedRating = document.querySelector('input[name="rating_range"]:checked').value;
   const urlParams = new URLSearchParams(window.location.search);
   urlParams.set('rating_range', selectedRating);
   window.location.search = urlParams.toString();
}

function clearRatingFilter() {
   const urlParams = new URLSearchParams(window.location.search);
   urlParams.delete('rating_range');
   window.location.search = urlParams.toString();
}

/* price filter script */
function applyPriceFilter() {
   const selectedPrice = document.querySelector('input[name="price_range"]:checked').value;
   const urlParams = new URLSearchParams(window.location.search);
   urlParams.set('price_range', selectedPrice);
   window.location.search = urlParams.toString();
}

function clearPriceFilter() {
   const urlParams = new URLSearchParams(window.location.search);
   urlParams.delete('price_range');
   window.location.search = urlParams.toString();
}

/* Star rating system */
const stars = document.querySelectorAll('.stars input');
if (stars) {
   stars.forEach(star => {
      star.addEventListener('change', () => {
         const starValue = parseInt(star.value);

         stars.forEach(s => {
            const label = s.nextElementSibling;
            const val = parseInt(s.value);

            if (val <= starValue) {
               label.classList.add('selected');
            }
            else {
               label.classList.remove('selected');
            }
         });
      });
   });
}

const errorMessage = document.querySelector('.error_message');
const successMessage = document.querySelector('.success_message');

if (errorMessage || successMessage) {
   setTimeout(() => {
      if (errorMessage) errorMessage.style.display = 'none';
      if (successMessage) successMessage.style.display = 'none';
   }, 5000);
}




/* chat script */
const contactButton = document.querySelector('.contact_freelancer');
const chatContainer = document.querySelector('#chat_container');
const closeButton = document.querySelector('#close_chat');
const messageForm = document.querySelector('#message_form');
const messageInput = document.querySelector('#message_input');
const chatMessages = document.querySelector('#chat_messages');

if (contactButton && chatContainer && closeButton && messageForm && messageInput && chatMessages) {
   contactButton.addEventListener('click', () => {
      chatContainer.classList.remove('hidden');
      loadChatMessages();
   });

   closeButton.addEventListener('click', () => {
      chatContainer.classList.add('hidden');
   });

   messageForm.addEventListener('submit', (e) => {
      e.preventDefault();

      const message = messageInput.value.trim();
      const receiverId = document.getElementById('receiver_id').value;

      if (!message) return;

      fetch('actions/action.send_message.php', {
         method: 'POST',
         headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
         },
         body: `receiver_id=${receiverId}&message=${encodeURIComponent(message)}`
      })
         .then(response => response.json())
         .then(data => {
            if (data.success) {
               addMessageToChat('sent', message, new Date().toLocaleTimeString());
               messageInput.value = '';
            }
            else {
               alert('Error sending message. Please try again.');
            }
         })
         .catch(error => {
            console.error('Error:', error);
         });
   });

   function loadChatMessages() {
      const receiverId = document.querySelector('#receiver_id').value;

      fetch(`actions/action.get_messages.php?receiver_id=${receiverId}`)
         .then(response => response.json())
         .then(data => {
            chatMessages.innerHTML = '';

            data.messages.forEach(msg => {
               const type = msg.senderId == data.currentUserId ? 'sent' : 'received';
               addMessageToChat(type, msg.content, formatDateTime(msg.sentAt));
            });

            chatMessages.scrollTop = chatMessages.scrollHeight;
         })
         .catch(error => {
            console.error('Error:', error);
         });
   }

   function addMessageToChat(type, content, time) {
      const messageElement = document.createElement('article');
      messageElement.classList.add('message', type);

      const messageContent = document.createElement('div');
      messageContent.textContent = content;

      const messageTime = document.createElement('div');
      messageTime.classList.add('message_time');
      messageTime.textContent = time;

      messageElement.appendChild(messageContent);
      messageElement.appendChild(messageTime);

      chatMessages.appendChild(messageElement);
      chatMessages.scrollTop = chatMessages.scrollHeight;
   }

   function formatDateTime(dateTimeStr) {
      const date = new Date(dateTimeStr);
      return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
   }

   setInterval(() => {
      if (!chatContainer.classList.contains('hidden')) {
         loadChatMessages();
      }
   }, 5000);
}



/* payment script */
const paymentForm = document.querySelector('#payment_form');
if (paymentForm) {
   paymentForm.onsubmit = async function (e) {
      e.preventDefault();

      const errorContainer = document.querySelector('#payment_errors');
      errorContainer.innerHTML = '';

      document.querySelectorAll('.input-error').forEach(input => {
         input.classList.remove('input-error');
      });

      const data = {
         type: document.querySelector('[name="type"]').value,
         service_id: document.querySelector('[name="service_id"]').value,
         name: document.querySelector('[name="name"]').value,
         address: document.querySelector('[name="address"]').value,
         cc_number: document.querySelector('[name="cc_number"]').value,
         expiry: document.querySelector('[name="expiry"]').value,
         cvv: document.querySelector('[name="cvv"]').value,
         csrf: document.querySelector('[name="csrf"]').value,
      };

      const response = await fetch('api/api.payment.php', {
         method: 'POST',
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify(data)
      });

      const result = await response.json();
      if (result.success) {
         if (data.type === 'promotion') {
            window.location.href = 'my_services.php';
         } else {
            window.location.href = 'service.php?id=' + data.service_id;
         }
      }
      else {
         errorContainer.style.display = 'block';

         if (result.errors) {
            const errorList = document.createElement('ul');
            const errorArray = typeof result.errors === 'string' ? [result.errors] : result.errors;

            errorArray.forEach(error => {
               const li = document.createElement('li');
               li.textContent = error;
               errorList.appendChild(li);

               if (error.includes('name')) {
                  document.querySelector('[name="name"]').classList.add('input-error');
               }
               if (error.includes('address')) {
                  document.querySelector('[name="address"]').classList.add('input-error');
               }
               if (error.includes('credit card')) {
                  document.querySelector('[name="cc_number"]').classList.add('input-error');
               }
               if (error.includes('expiry')) {
                  document.querySelector('[name="expiry"]').classList.add('input-error');
               }
               if (error.includes('CVV')) {
                  document.querySelector('[name="cvv"]').classList.add('input-error');
               }
            });

            errorContainer.appendChild(errorList);
         }
         else if (result.error) {
            errorContainer.textContent = result.error;
         }
         else {
            errorContainer.textContent = "Payment failed. Please try again.";
         }

         errorContainer.scrollIntoView({ behavior: 'smooth' });
      }
   }
}

// edit and cancel buttons on service management
function toggleEdit(serviceId) {
   const card = document.getElementById(`service-${serviceId}`);
   const view = card.querySelector('.view-mode');
   const edit = card.querySelector('.edit-mode');

   view.style.display = view.style.display === 'none' ? 'flex' : 'none';
   edit.style.display = edit.style.display === 'block' ? 'none' : 'block';
}

function toggleCancel(serviceId) {
   const card = document.getElementById(`service-${serviceId}`);
   const view = card.querySelector('.view-mode');
   const edit = card.querySelector('.edit-mode');

   view.style.display = view.style.display === 'none' ? 'flex' : 'none';
   edit.style.display = edit.style.display === 'block' ? 'none' : 'block';


   if (edit.style.display === "none") {
      const preview = document.getElementById("prevImage" + serviceId);
      const fileInput = document.getElementById("image" + serviceId);

      if (preview && preview.dataset.originalSrc) {
         preview.src = preview.dataset.originalSrc;
      }
      if (fileInput) {
         fileInput.value = "";
      }
   }
}

// this ables to preview the image when updating service
const imageInputs = document.querySelectorAll('input[type="file"][name="image"]');
if (imageInputs) {
   imageInputs.forEach(input => {
      const id = input.id.replace('image', '');
      const prev = document.getElementById('prevImage' + id);

      if (prev) {
         input.addEventListener("change", event => {
            const file = event.target.files[0];
            if (file) {
               const reader = new FileReader();
               reader.onload = function (e) {
                  prev.src = e.target.result;
               };
               reader.readAsDataURL(file);
            }
         });
      }
   });
}
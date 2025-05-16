/* search script */
document.querySelector('.search_bar').addEventListener('submit', function (event) {
   event.preventDefault();
   const query = document.querySelector('input[name="query"]').value;
   window.location.href = `index.php?query=${encodeURIComponent(query)}`;
});

/* when the page reloads after submitting the search, the input field retains the text in the search-bar */
document.addEventListener('DOMContentLoaded', () => {
   const urlParams = new URLSearchParams(window.location.search);
   const query = urlParams.get('query');
   if (query) {
      document.querySelector('input[name="query"]').value = query;
   }
});

/* when the page reloads after selecting the category, the input field retains the selected category*/
document.addEventListener('DOMContentLoaded', () => {
   const urlParams = new URLSearchParams(window.location.search);
   const category = urlParams.get('category');
   if (category) {
      const radio = document.querySelector(`input[name="category"][value="${category}"]`);
      if (radio) {
         radio.checked = true;
      }
   }
});

/* when the page reloads after submitting the rating range, the input field retains the selected range */
document.addEventListener('DOMContentLoaded', () => {
   const urlParams = new URLSearchParams(window.location.search);
   const ratingRange = urlParams.get('rating_range');
   if (ratingRange) {
      const radio = document.querySelector(`input[name="rating_range"][value="${ratingRange}"]`);
      if (radio) {
         radio.checked = true;
      }
   }
});

/* when the page reloads after submitting the price range, the input field retains the selected range */
document.addEventListener('DOMContentLoaded', () => {
   const urlParams = new URLSearchParams(window.location.search);
   const priceRange = urlParams.get('price_range');
   if (priceRange) {
      const radio = document.querySelector(`input[name="price_range"][value="${priceRange}"]`);
      if (radio) {
         radio.checked = true;
      }
   }
});

/* 
The DOMContentLoaded event fires when the HTML document has been completely parsed, 
and all deferred scripts have downloaded and executed.
*/

/* category button script */
document.addEventListener('DOMContentLoaded', () => {
   const categoryButton = document.querySelector('#category');
   const dropdownMenu = document.querySelector('.category_menu');

   categoryButton.addEventListener('click', () => {
      dropdownMenu.classList.toggle('visible');
   });

   /* detect clicks outside of the "Category" button and its dropdown menu. */
   document.addEventListener('click', (event) => {
      if (!categoryButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
         dropdownMenu.classList.remove('visible');
      }
   });
});



/* price button script */
document.addEventListener('DOMContentLoaded', () => {
   const priceButton = document.querySelector('#price');
   const priceMenu = document.querySelector('.price_menu');

   priceButton.addEventListener('click', () => {
      priceMenu.classList.toggle('visible');
   });

   /* detect clicks outside of the "Price" button and its dropdown menu. */
   document.addEventListener('click', (event) => {
      if (!priceButton.contains(event.target) && !priceMenu.contains(event.target)) {
         priceMenu.classList.remove('visible');
      }
   });
});

/* rating button script */
document.addEventListener('DOMContentLoaded', () => {
   const ratingButton = document.querySelector('#rating');
   const ratingMenu = document.querySelector('.rating_menu');

   ratingButton.addEventListener('click', () => {
      ratingMenu.classList.toggle('visible');
   });

   /* detect clicks outside of the "Rating" button and its dropdown menu. */
   document.addEventListener('click', (event) => {
      if (!ratingButton.contains(event.target) && !ratingMenu.contains(event.target)) {
         ratingMenu.classList.remove('visible');
      }
   });
});

/* clear button script */
document.querySelectorAll('.clear_button').forEach(button => {
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
document.addEventListener('DOMContentLoaded', () => {
   const stars = document.querySelectorAll('.stars input');

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
});

document.addEventListener('DOMContentLoaded', () => {
   const errorMessage = document.querySelector('.error_message');
   const successMessage = document.querySelector('.success_message');

   if (errorMessage || successMessage) {
      setTimeout(() => {
         if (errorMessage) errorMessage.style.display = 'none';
         if (successMessage) successMessage.style.display = 'none';
      }, 5000);
   }
});


/* chat script */
document.addEventListener('DOMContentLoaded', () => {
   const contactButton = document.querySelector('.contact_freelancer');
   const chatContainer = document.querySelector('#chat_container');
   const closeButton = document.querySelector('#close_chat');
   const messageForm = document.querySelector('#message_form');
   const messageInput = document.querySelector('#message_input');
   const chatMessages = document.querySelector('#chat_messages');

   if (!contactButton) return;

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
      return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
   }

   if (chatContainer) {
      setInterval(() => {
         if (!chatContainer.classList.contains('hidden')) {
            loadChatMessages();
         }
      }, 5000);
   }
});

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
document.addEventListener("DOMContentLoaded", () => {
   const imageInputs = document.querySelectorAll('input[type="file"][name="image"]');

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
});





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
   const dropdownItems = document.querySelectorAll('.dropdown_item');

   categoryButton.addEventListener('click', () => {
      dropdownMenu.classList.toggle('visible');
   });

   /* detect clicks outside of the "Category" button and its dropdown menu. */
   document.addEventListener('click', (event) => {
      if (!categoryButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
         dropdownMenu.classList.remove('visible');
      }
   });

   dropdownItems.forEach(item => {
      item.addEventListener('click', () => {
         dropdownItems.forEach(i => i.querySelector('.selected_icon').style.display = 'none');

         item.querySelector('.selected_icon').style.display = 'inline';
      });
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
/* search script */
document.querySelector('.search_bar').addEventListener('submit', function (event) {
   event.preventDefault();
   const query = document.querySelector('input[name="query"]').value;
   window.location.href = `index.php?query=${encodeURIComponent(query)}`;
});

/* when the page reloads after submitting the search, the input field retains the text in the search-bar*/
document.addEventListener('DOMContentLoaded', () => {
   const urlParams = new URLSearchParams(window.location.search);
   const query = urlParams.get('query');
   if (query) {
      document.querySelector('input[name="query"]').value = query;
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
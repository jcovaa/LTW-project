document.querySelector('.search_bar').addEventListener('submit', function (event) {
   event.preventDefault();
   const query = document.querySelector('input[name="query"]').value;
   window.location.href = `index.php?query=${encodeURIComponent(query)}`;
});

/* 
The DOMContentLoaded event fires when the HTML document has been completely parsed, 
and all deferred scripts have downloaded and executed.
*/

document.addEventListener('DOMContentLoaded', () => {
   const categoryButton = document.querySelector('#category');
   const dropdownMenu = document.querySelector('.dropdown_menu');
   const dropdownItems = document.querySelectorAll('.dropdown_item');

   categoryButton.addEventListener('click', () => {
      dropdownMenu.classList.toggle('visible');
   });

   dropdownItems.forEach(item => {
      item.addEventListener('click', () => {
         dropdownItems.forEach(i => i.querySelector('.selected_icon').style.display = 'none');

         item.querySelector('.selected_icon').style.display = 'inline';
      });
   });

   const allCategoriesItem = document.querySelector('.dropdown_item[data-category-id="all"]');
   if (allCategoriesItem) {
      allCategoriesItem.querySelector('.selected_icon').style.display = 'inline';
   }
});
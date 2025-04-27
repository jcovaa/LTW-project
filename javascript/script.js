document.querySelector('.search_bar').addEventListener('submit', function (event) {
   event.preventDefault();
   const query = document.querySelector('input[name="query"]').value;
   window.location.href = `index.php?query=${encodeURIComponent(query)}`;
});
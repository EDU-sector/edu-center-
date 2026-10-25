document.addEventListener('DOMContentLoaded', () => {
  const searchForm = document.querySelector('.search');
  const searchInput = document.querySelector('.search input');
  const suggestForm = document.getElementById('suggest-form');

  if (searchForm && searchInput) {
    searchForm.addEventListener('submit', (event) => {
      event.preventDefault();
      const query = searchInput.value.trim();
      const url = new URL(window.location.href);
      if (query) {
        url.searchParams.set('q', query);
      } else {
        url.searchParams.delete('q');
      }
      window.location.href = url.toString();
    });
  }

  if (suggestForm) {
    suggestForm.addEventListener('submit', (event) => {
      event.preventDefault();
      const formData = new FormData(suggestForm);
      const institution = (formData.get('institution') || '').toString().trim();
      if (!institution) {
        return;
      }
      suggestForm.submit();
    });
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const root = document.documentElement;
  const themeToggle = document.querySelector('.theme-toggle');
  const searchForm = document.querySelector('.search');
  const searchInput = document.querySelector('.search input');
  const suggestForm = document.querySelector('.suggest-form');

  const applyTheme = (theme) => {
    root.setAttribute('data-theme', theme === 'dark' ? 'dark' : 'light');

    if (themeToggle) {
      const icon = themeToggle.querySelector('.theme-toggle-icon');
      if (icon) {
        icon.textContent = root.getAttribute('data-theme') === 'dark' ? '☀️' : '🌙';
      }
      themeToggle.setAttribute(
        'aria-label',
        root.getAttribute('data-theme') === 'dark' ? 'Switch to light mode' : 'Switch to dark mode'
      );
    }
  };

  const storedTheme = localStorage.getItem('edutricity-theme') || 'light';
  applyTheme(storedTheme);

  if (themeToggle) {
    themeToggle.addEventListener('click', () => {
      const nextTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      applyTheme(nextTheme);
      localStorage.setItem('edutricity-theme', nextTheme);
    });
  }

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

const searchForm = document.querySelector("#search-form");
const searchInput = document.querySelector("#search-input");
const results = document.querySelector("#results");
const cards = [...document.querySelectorAll(".institution-card")];

const filterCards = (query) => {
  const normalized = query.trim().toLowerCase();

  cards.forEach((card) => {
    const name = card.dataset.name || "";
    const location = card.dataset.location || "";
    const match = !normalized || name.includes(normalized) || location.includes(normalized);
    card.style.display = match ? "block" : "none";
  });
};

searchForm.addEventListener("submit", (event) => {
  event.preventDefault();
  const query = searchInput.value.trim();
  filterCards(query);

  if (!query) {
    searchInput.focus();
    return;
  }

  const visibleCards = cards.filter((card) => card.style.display !== "none");
  if (!visibleCards.length) {
    results.innerHTML = `
      <article class="institution-card">
        <div class="badge neutral">No matches</div>
        <h3>No institution found</h3>
        <p class="meta">Try another keyword or location.</p>
        <p>Examples: Chandigarh, Mohali, engineering, school, coaching.</p>
      </article>
    `;
  } else {
    results.innerHTML = "";
    visibleCards.forEach((card) => results.appendChild(card));
  }
});

const suggestForm = document.querySelector("#suggest-form");
const statusText = document.querySelector("#form-status");

suggestForm.addEventListener("submit", (event) => {
  event.preventDefault();
  const formData = new FormData(suggestForm);
  const institution = formData.get("institution")?.toString().trim();

  if (!institution) {
    statusText.textContent = "Please enter at least an institution name.";
    return;
  }

  statusText.textContent = `Thank you! “${institution}” has been queued for review.`;
  suggestForm.reset();
});

const faqDetails = document.querySelectorAll(".faq-list details");
faqDetails.forEach((item) => {
  item.addEventListener("toggle", () => {
    if (!item.open) return;
    faqDetails.forEach((other) => {
      if (other !== item) other.removeAttribute("open");
    });
  });
});

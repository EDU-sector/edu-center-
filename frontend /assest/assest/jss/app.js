
const searchForm = document.querySelector("#search-form");
const searchInput = document.querySelector("#search-input");
const results = document.querySelector("#results");

searchForm.addEventListener("submit", (event) => {
  event.preventDefault();

  const query = searchInput.value.trim();

  if (!query) {
    searchInput.focus();
    return;
  }

  results.replaceChildren();

  const card = document.createElement("article");
  card.className = "institution";

  const title = document.createElement("h3");
  title.textContent = "Search is ready for integration";

  const description = document.createElement("p");
  description.textContent =
    `Your search: "${query}". Connect the institution API to retrieve real results.`;

  card.append(title, description);
  results.append(card);
});

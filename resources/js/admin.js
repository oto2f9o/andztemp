document.addEventListener("click", (e) => {
  if (e.target.id == "delivery-copy-btn") {
    navigator.clipboard.writeText(e.target.dataset.key);
    e.target.innerText = e.target.dataset.copied;
    setTimeout(() => {
      e.target.innerText = e.target.dataset.copy;
    }, 3000);
  }
});

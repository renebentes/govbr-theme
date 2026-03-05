export function toggleContrastMode() {
  var toggler = document.querySelector('.toggle-contrast');
  toggler?.addEventListener('click', (event) => {
    event.stopPropagation();
    document.body.classList.toggle('contrast-mode');
  });
}

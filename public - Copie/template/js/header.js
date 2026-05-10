document.addEventListener('DOMContentLoaded', () => {
  document.addEventListener('click', (event) => {
    const target = event.target.closest('[data-prompt]');

    if (!target || typeof window.sendPrompt !== 'function') {
      return;
    }

    event.preventDefault();
    window.sendPrompt(target.dataset.prompt);
  });
});

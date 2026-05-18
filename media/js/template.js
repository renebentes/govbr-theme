import { initGovBR } from './core';
import { toggleContrastMode } from './components/contrast-mode';
import '@fortawesome/fontawesome-free/css/all.min.css';
import '../scss/template.scss';

window.addEventListener('DOMContentLoaded', () => {
  initGovBR();

  toggleContrastMode();
});

import * as core from '@govbr-ds/core/dist/core.min.js';
import { toggleContrastMode } from './contrast-mode';

export function instantiateHeader() {
  const brHeader = document.querySelector('.br-header');
  new core.BRHeader('br-header', brHeader);
}

toggleContrastMode();

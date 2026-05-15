import * as core from '@govbr-ds/core/dist/core.min.js';
export function instantiateMenus() {
  const menuList = [];
  for (const brMenu of window.document.querySelectorAll('.br-menu')) {
    menuList.push(new core.BRMenu('br-menu', brMenu));
  }
}

import { BRMenu } from '@govbr-ds/core';

export function initBRMenu(root = document) {
  const menuList = [];
  for (const brMenu of root.querySelectorAll('.br-menu')) {
    menuList.push(new BRMenu('br-menu', brMenu));
  }
}

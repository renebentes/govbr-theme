import { BRFooter } from '@govbr-ds/core';

export function initBRFooter(root = document) {
  const listFooter = [];
  for (const brFooter of root.querySelectorAll('.br-footer')) {
    listFooter.push(new BRFooter('br-footer', brFooter));
  }
}

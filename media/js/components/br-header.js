import { BRHeader } from '@govbr-ds/core';

export function initBRHeader(root = document) {
  const brHeader = root.querySelector('.br-header');
  new BRHeader('br-header', brHeader);
}

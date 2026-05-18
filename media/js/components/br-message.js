import { BRAlert } from '@govbr-ds/core';

export function initBRMessage(root = document) {
  const alertList = [];
  for (const brAlert of root.querySelectorAll('.br-message')) {
    alertList.push(new BRAlert('br-message', brAlert));
  }
}

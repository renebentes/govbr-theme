import { BRSelect } from '@govbr-ds/core';

export function initBRSelect(root = document) {
  const selectList = [];
  for (const brSelect of root.querySelectorAll('.br-select')) {
    selectList.push(new BRSelect('br-select', brSelect));
  }
}

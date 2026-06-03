import { BRInput } from '@govbr-ds/core';

export function initBRInput(root = document) {
  const inputList = [];
  for (const brInput of root.querySelectorAll('.br-input')) {
    inputList.push(new BRInput('br-input', brInput));
  }
}

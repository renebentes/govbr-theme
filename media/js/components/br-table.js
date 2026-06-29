import { BRTable } from '@govbr-ds/core';

export function initBRTable(root = document) {
  const tables = [];
  for (const brTable of root.querySelectorAll('.br-table')) {
    tables.push(new BRTable('br-table', brTable));
  }
}

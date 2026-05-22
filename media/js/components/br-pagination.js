import { BRPagination } from '@govbr-ds/core';

export function initBRPagination(root = document) {
  const paginationList = [];
  for (const brPagination of root.querySelectorAll('.br-pagination')) {
    paginationList.push(new BRPagination('br-pagination', brPagination));
  }
}

const paginationList = [];
for (const brPagination of window.document.querySelectorAll('.br-pagination')) {
  paginationList.push(new core.BRPagination('br-pagination', brPagination));
}

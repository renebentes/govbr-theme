const listFooter = [];
for (const brFooter of window.document.querySelectorAll('.br-footer')) {
  listFooter.push(new core.BRFooter('br-footer', brFooter));
}

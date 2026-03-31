const alertList = [];
for (const brAlert of window.document.querySelectorAll('.br-message')) {
  alertList.push(new core.BRAlert('br-message', brAlert));
}

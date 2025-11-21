export const headerList = [];

for (const brHeader of window.document.querySelectorAll('.br-header')) {
  headerList.push(new core.BRHeader('br-header', brHeader));
}

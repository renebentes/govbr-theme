export function instantiateMenus() {
  const menuList = [];
  for (const brMenu of window.document.querySelectorAll('.br-menu')) {
    menuList.push(new core.BRMenu('br-menu', brMenu));
  }
}

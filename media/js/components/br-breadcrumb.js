function instantiateBreadcrumbs() {
  const breadcrumbs = [];
  for (const brBreadcrumb of window.document.querySelectorAll(
    '.br-breadcrumb'
  )) {
    breadcrumbs.push(new core.BRBreadcrumb('br-breadcrumb', brBreadcrumb));
  }
}

window.addEventListener('DOMContentLoaded', () => {
  instantiateBreadcrumbs();
});

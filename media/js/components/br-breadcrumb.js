import { BRBreadcrumb } from '@govbr-ds/core';

export function initBRBreadcrumb(root = document) {
  const breadcrumbs = [];
  for (const brBreadcrumb of root.querySelectorAll('.br-breadcrumb')) {
    breadcrumbs.push(new BRBreadcrumb('br-breadcrumb', brBreadcrumb));
  }
}

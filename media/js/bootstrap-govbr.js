import { BRBreadcrumb, BRHeader, BRMenu } from '@govbr-ds/core';

export function initGovBR(root = document) {
  root
    .querySelectorAll('.br-header')
    .forEach((el) => new BRHeader('br-header', el));

  root.querySelectorAll('.br-menu').forEach((el) => new BRMenu('br-menu', el));

  root
    .querySelectorAll('.br-breadcrumb')
    .forEach((el) => new BRBreadcrumb('br-breadcrumb', el));
}

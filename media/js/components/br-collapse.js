import { Collapse } from "@govbr-ds/core";

export function initBRCollapse(root = document) {
  root.querySelectorAll('[data-toggle="collapse"]').forEach((trigger) => {
  const config = {
    trigger,
  };
  const collapse = new Collapse(config);
  collapse.setBehavior();
})}

import '@govbr-ds/core/dist/core.css';
import { initBRHeader } from './components/br-header';
import { initBRMenu } from './components/br-menu';
import { initBRBreadcrumb } from './components/br-breadcrumb';
import { initBRMessage } from './components/br-message';
import { initBRFooter } from './components/br-footer';
import { initBRTooltip } from './components/br-tooltip';
import { initBRPagination } from './components/br-pagination';
import { initBRSelect } from './components/br-select';
import { initBRInput } from './components/br-input';

export function initGovBR(root = document) {
  initBRHeader(root);
  initBRMenu(root);
  initBRBreadcrumb(root);
  initBRMessage(root);
  initBRFooter(root);
  initBRTooltip(root);
  initBRPagination(root);
  initBRSelect(root);
  initBRInput(root);
}

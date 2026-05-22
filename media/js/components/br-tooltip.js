import { Tooltip } from '@govbr-ds/core';

export function initBRTooltip(root = document) {
  const tooltipList = [];
  for (const trigger of root.querySelectorAll(
    '[data-tooltip-text],[data-tooltip-target]'
  )) {
    const config = {
      activator: trigger,
      place: 'bottom'
    };

    for (const target of root.querySelectorAll(trigger.dataset.tooltipTarget)) {
      config.component = target;
    }

    if (trigger.dataset.tooltipText !== null) {
      config.textTooltip = trigger.dataset.tooltipText;
    }

    tooltipList.push(Tooltip(config));
  }
}

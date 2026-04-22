const tooltipList = [];
for (const trigger of window.document.querySelectorAll(
  '[data-tooltip-text],[data-tooltip-target]'
)) {
  const config = {
    activator: trigger,
    place: 'bottom'
  };

  for (const target of window.document.querySelectorAll(
    trigger.dataset.tooltipTarget
  )) {
    config.component = target;
  }

  if (trigger.dataset.tooltipText !== null) {
    config.textTooltip = trigger.dataset.tooltipText;
  }

  tooltipList.push(new core.Tooltip(config));
}

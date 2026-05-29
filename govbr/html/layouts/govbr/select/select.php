<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (C) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @since       __DEPLOY_VERSION__
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

extract($displayData, EXTR_OVERWRITE);

/**
 * Layout variables
 *
 * @var string $name
 * @var string $label
 * @var string $placeholder
 * @var array  $options
 * @var string $selected
 * @var string $attribs
 */

?>
<div class="br-select"
    <?= $attribs; ?>>
    <div class="br-input">
        <label for="<?= $this->escape($name); ?>"><?= $this->escape($label); ?></label>
        <input
            id="<?= $name; ?>"
            type="text"
            <?= isset($placeholder) ? ' placeholder="' . $this->escape($placeholder) . '"' : ''; ?> />
        <button
            class="br-button"
            type="button"
            aria-label="<?= Text::_('JGLOBAL_LIST_LIMIT'); ?>"
            tabindex="-1"
            data-trigger="data-trigger">
            <i class="fas fa-angle-down" aria-hidden="true"></i>
        </button>
    </div>
    <div class="br-list" tabindex="0">
        <?php foreach ($options as $option) : ?>
            <?php $optionName = $name . '-' . $option->value; ?>
            <div class="br-item<?= $selected == $option->value ? ' selected' : ''; ?>" tabindex="-1">
                <div class="br-radio">
                    <input id="<?= $optionName; ?>" type="radio" name="<?= $name; ?>" value="<?= $optionName; ?>" />
                    <label for="<?= $optionName; ?>"><?= $option->text; ?></label>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

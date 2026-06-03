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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Pagination\Pagination;

extract($displayData, EXTR_OVERWRITE);

/**
 * @var  Pagination  $pagination  The pagination object
 * @var  string      $class       Classes for the pagination container.
 */
$pagination = $displayData['pagination'] ?? null;

$limits = [];

// Make the option list.
for ($i = 5; $i <= 30; $i += 5) {
    $limits[] = HTMLHelper::_('select.option', "$i");
}

$limits[] = HTMLHelper::_('select.option', '50', Text::_('J50'));
$limits[] = HTMLHelper::_('select.option', '100', Text::_('J100'));
$limits[] = HTMLHelper::_('select.option', '200', Text::_('J200'));
$limits[] = HTMLHelper::_('select.option', '500', Text::_('J500'));
$limits[] = HTMLHelper::_('select.option', '0', Text::_('JALL'));

$selected = $pagination->limit;

?>

<div class="pagination-per-page<?= $class ?? ''; ?>">
    <?php echo LayoutHelper::render(
        'govbr.form.select',
        [
            'name'      => 'limit',
            'label'     => Text::_('JGLOBAL_DISPLAY_NUM'),
            'ariaLabel' => Text::_('JGLOBAL_LIST_LIMIT'),
            'options'   => $limits,
            'selected'  => $selected,
            'onchange'  => 'this.closest(\'form\').submit();',
        ]
    ); ?>
</div>

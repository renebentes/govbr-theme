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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$item      = $displayData['data'];
$display   = $item->text;
$app       = Factory::getApplication();
$classType = 'br-button circle';

switch ((string) $item->text) {
    // Check for "Start" item
    case Text::_('JLIB_HTML_START'):
        $icon = $app->getLanguage()->isRtl() ? 'fa-double-right' : 'fa-angle-double-left';
        $aria = Text::_('JLIB_HTML_GOTO_POSITION_START');
        break;

        // Check for "Prev" item
    case Text::_('JPREV'):
        $icon = $app->getLanguage()->isRtl() ? 'fa-angle-right' : 'fa-angle-left';
        $aria = Text::_('JLIB_HTML_GOTO_POSITION_PREVIOUS');
        break;

        // Check for "Next" item
    case Text::_('JNEXT'):
        $icon = $app->getLanguage()->isRtl() ? 'fa-angle-left' : 'fa-angle-right';
        $aria = Text::_('JLIB_HTML_GOTO_POSITION_NEXT');
        break;

        // Check for "End" item
    case Text::_('JLIB_HTML_END'):
        $icon = $app->getLanguage()->isRtl() ? 'fa-angle-double-left' : 'fa-angle-double-right';
        $aria = Text::_('JLIB_HTML_GOTO_POSITION_END');
        break;

    default:
        $icon      = null;
        $aria      = Text::sprintf('JLIB_HTML_GOTO_PAGE', strtolower($item->text));
        $classType = 'page';
        break;
}

if ($icon !== null) {
    $display = '<i class="fas ' . $icon . '" aria-hidden="true"></i>';
}

if ($displayData['active']) {
    if ($item->base > 0) {
        $limit = 'limitstart.value=' . $item->base;
    } else {
        $limit = 'limitstart.value=0';
    }

    $class = 'active';

    if ($app->isClient('administrator')) {
        $link = 'href="#" onclick="document.adminForm.' . $item->prefix . $limit . '; Joomla.submitform();return false;"';
    } elseif ($app->isClient('site')) {
        $link = 'href="' . $item->link . '"';
    }
} else {
    $class = (property_exists($item, 'active') && $item->active) ? 'active' : 'disabled';
}

?>
<?php if ($displayData['active']) : ?>
    <li>
        <a aria-label="<?= $aria; ?>" <?= $link; ?> class="<?= $classType; ?>">
            <?= $display; ?>
        </a>
    </li>
<?php elseif (isset($item->active) && $item->active) : ?>
    <?php $aria = Text::sprintf('JLIB_HTML_PAGE_CURRENT', strtolower($item->text)); ?>
    <li>
        <a aria-current="true" aria-label="<?= $aria; ?>" href="#" class="<?= $classType; ?> <?= $class; ?>"><?= $display; ?></a>
    </li>
<?php else : ?>
    <li>
        <span class="<?= $classType; ?> <?= $class; ?>" aria-hidden="true"><?= $display; ?></span>
    </li>
<?php endif; ?>

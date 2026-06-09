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
use Joomla\CMS\Router\Route;

/**
 * @var \Joomla\Plugin\Content\PageNavigation\Extension\PageNavigation  $this
 */
$this->loadLanguage();
$lang = Factory::getApplication()->getLanguage();
?>

<nav class="br-pagination mt-4" aria-label="<?php echo Text::_('PLG_PAGENAVIGATION_ARIA_LABEL'); ?>">
    <div class="pagination-arrows">
    <?php if ($row->prev) : ?>
        <?php $direction = $lang->isRtl() ? 'right' : 'left'; ?>
        <?php $label     = Text::sprintf('JPREVIOUS_TITLE', htmlspecialchars($rows[$location - 1]->title)); ?>
            <a class="br-button circle"
                href="<?php echo Route::_($row->prev); ?>"
                rel="prev"
                aria-label="<?php echo $label; ?>"
                data-tooltip-text="<?php echo $label ; ?>">
                <i class="fas fa-chevron-<?php echo $direction; ?>" aria-hidden="true"></i>
            </a>
    <?php endif; ?>
    <?php if ($row->next) : ?>
        <?php $direction = $lang->isRtl() ? 'left' : 'right'; ?>
        <?php $label     = Text::sprintf('JNEXT_TITLE', htmlspecialchars($rows[$location + 1]->title)); ?>
            <a class="br-button circle"
                href="<?php echo Route::_($row->next); ?>"
                rel="next"
                aria-label="<?php echo $label; ?>"
                data-tooltip-text="<?php echo $label; ?>">
                <i class="fas fa-chevron-<?php echo $direction; ?>" aria-hidden="true"></i>
            </a>
    <?php endif; ?>
    </div>
</nav>

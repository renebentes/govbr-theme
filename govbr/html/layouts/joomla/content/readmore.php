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
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

$params    = $displayData['params'];
$item      = $displayData['item'];
$direction = Factory::getLanguage()->isRtl() ? 'left' : 'right';
?>


<?php if (!$params->get('access-view')) : ?>
    <a class="br-button secondary" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::_('JGLOBAL_REGISTER_TO_READ_MORE') . ' ' . $this->escape($item->title); ?>">
        <i class="fas fa-chevron-<?= $direction; ?>" aria-hidden="true"></i>
        <?php echo Text::_('JGLOBAL_REGISTER_TO_READ_MORE'); ?>
    </a>
<?php elseif ($readmore = $item->alternative_readmore) : ?>
    <a class="br-button secondary" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo $this->escape($readmore . ' ' . $item->title); ?>">
        <i class="fas fa-chevron-<?= $direction; ?>" aria-hidden="true"></i>
        <?= $readmore; ?>
        <?php if ($params->get('show_readmore_title', 0) != 0) : ?>
            <?php echo HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit')); ?>
        <?php endif; ?>
    </a>
<?php elseif ($params->get('show_readmore_title', 0) == 0) : ?>
    <a class="br-button secondary" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::sprintf('JGLOBAL_READ_MORE_TITLE', $this->escape($item->title)); ?>">
        <i class="fas fa-chevron-<?= $direction; ?>" aria-hidden="true"></i>
        <?php echo Text::_('JGLOBAL_READ_MORE'); ?>
    </a>
<?php else : ?>
    <a class="br-button secondary" href="<?php echo $displayData['link']; ?>" aria-label="<?php echo Text::sprintf('JGLOBAL_READ_MORE_TITLE', $this->escape($item->title)); ?>">
        <i class="fas fa-chevron-<?= $direction; ?>" aria-hidden="true"></i>
        <?php echo Text::sprintf('JGLOBAL_READ_MORE_TITLE', HTMLHelper::_('string.truncate', $item->title, $params->get('readmore_limit'))); ?>
    </a>
<?php endif; ?>

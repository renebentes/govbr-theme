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

?>
<dd class="br-item">
    <i class="fas fa-user mr-3" aria-hidden="true"></i>
    <?php $author = ($displayData['item']->created_by_alias ?: $displayData['item']->author); ?>
    <?php if (!empty($displayData['item']->contact_link) && $displayData['params']->get('link_author')) : ?>
        <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $displayData['item']->contact_link, $author)); ?>
    <?php else : ?>
        <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
    <?php endif; ?>
</dd>

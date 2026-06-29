<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */
\defined('_JEXEC') or exit;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

?>
<dd class="modified">
    <i class="fas fa-calendar mx-1" aria-hidden="true"></i>
    <time datetime="<?php echo HTMLHelper::_('date', $displayData['item']->modified, 'c'); ?>">
        <?php echo Text::sprintf('COM_CONTENT_LAST_UPDATED', HTMLHelper::_('date', $displayData['item']->modified, Text::_('DATE_FORMAT_LC5'))); ?>
    </time>
</dd>

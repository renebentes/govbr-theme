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

?>
<dd class="br-item">
    <i class="fas fa-eye mr-3" aria-hidden="true"></i>
    <meta content="UserPageVisits:<?php echo $displayData['item']->hits; ?>">
    <?php echo Text::sprintf('COM_CONTENT_ARTICLE_HITS', $displayData['item']->hits); ?>
</dd>

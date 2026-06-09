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

$list = $displayData['list'];

?>
<nav class="br-pagination" aria-label="<?php echo Text::_('JLIB_HTML_PAGINATION'); ?>" data-total="<?php echo \count($list); ?>">
    <ul>
        <?php echo $list['start']['data']; ?>
        <?php echo $list['previous']['data']; ?>

        <?php foreach ($list['pages'] as $page) : ?>
            <?php echo $page['data']; ?>
        <?php endforeach; ?>

        <?php echo $list['next']['data']; ?>
        <?php echo $list['end']['data']; ?>
    </ul>
</nav>

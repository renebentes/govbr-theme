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

?>
<?php if ($displayData->params->get('show_page_heading')) : ?>
    <header class="page-header">
        <h1> <?php echo $displayData->escape($displayData->params->get('page_heading')); ?></h1>
    </header>
<?php endif; ?>

<?php if ($displayData->params->get('show_base_description')) : ?>
    <div class="description">
        <?php // If there is a description in the menu parameters use that;
        ?>
        <?php if ($displayData->params->get('categories_description')) : ?>
            <?php echo HTMLHelper::_('content.prepare', $displayData->params->get('categories_description'), '', $displayData->get('extension') . '.categories'); ?>

        <?php else : ?>
            <?php // Otherwise get one from the database if it exists.
            ?>
            <?php if ($displayData->parent->description) : ?>
                <?php echo HTMLHelper::_('content.prepare', $displayData->parent->description, '', $displayData->parent->extension . '.categories'); ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

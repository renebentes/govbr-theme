<?php

/**
 * GovBR Theme based on Brazilian Design System available on https://gov.br/ds
 * for Joomla! Content Management System.
 *
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @since       __DEPLOY_VERSION__
 */

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;
use Joomla\Registry\Registry;

$authorised = Factory::getUser()->getAuthorisedViewLevels();

?>
<?php if (!empty($displayData)) : ?>
    <h6 class="text-capitalize"><?php echo Text::_('JTAG'); ?>:
    <?php foreach ($displayData as $i => $tag) : ?>
        <?php if (\in_array($tag->access, $authorised)) : ?>
            <?php $tagParams  = new Registry($tag->params); ?>
            <?php $link_class = $tagParams->get('tag_link_class', 'interaction'); ?>
            <a href="<?php echo Route::_(RouteHelper::getComponentTagRoute($tag->tag_id . ':' . $tag->alias, $tag->language)); ?>"
                class="br-tag <?php echo $link_class; ?> tag-<?php echo $tag->tag_id; ?> tag-list-<?php echo $i; ?>">
                <?php echo $this->escape($tag->title); ?>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
    </h6>
<?php endif; ?>

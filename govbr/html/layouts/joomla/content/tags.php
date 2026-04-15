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
use Joomla\Component\Tags\Site\Helper\RouteHelper;
use Joomla\Registry\Registry;

$authorised = Factory::getUser()->getAuthorisedViewLevels();

?>
<?php if (!empty($displayData)) : ?>
    <h4><?= Text::_('JTAG'); ?></h4>
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
<?php endif; ?>

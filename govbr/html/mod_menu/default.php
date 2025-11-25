<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (C) 2025 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @since       __DEPLOY_VERSION__
 */

// No direct access.
\defined('_JEXEC') or die('Restricted access!');

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Utilities\ArrayHelper;

$attributes          = [];
$attributes['class'] = trim('br-list ' . $params->get('moduleclass_sfx'));

if ($tagId = $params->get('tag_id', '')) {
    $attributes['id'] = htmlspecialchars($tagId, ENT_QUOTES, 'UTF-8');
}

?>
<ul <?php echo ArrayHelper::toString($attributes); ?>>

    <?php if ($module->showtitle) : ?>
    <li class="header">
        <div class="title">
            <?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    </li>
    <li class="br-divider"></li>
    <?php endif; ?>

    <?php foreach ($list as $i => &$item) {
        $itemParams = $item->getParams();
        $class      ="";
        $class .= 'br-item item-' . $item->id;

        if ($item->id == $default_id) {
            $class .= ' default';
        }

        if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
            $class .= ' current';
        }

        if (\in_array($item->id, $path)) {
            $class .= ' active';
        } elseif ($item->type === 'alias') {
            $aliasToId = $itemParams->get('aliasoptions');

            if (\count($path) > 0 && $aliasToId == $path[\count($path) - 1]) {
                $class .= ' active';
            } elseif (\in_array($aliasToId, $path)) {
                $class .= ' alias-parent-active';
            }
        }

        if ($item->type === 'separator') {
            $class .= ' divider';
        }

        if ($item->deeper) {
            $class .= ' deeper';
        }

        if ($item->parent) {
            $class .= ' parent';
        }

        echo '<li class="' . $class . '">';

        switch ($item->type) :
            case 'separator':
            case 'component':
            case 'heading':
            case 'url':
                require ModuleHelper::getLayoutPath('mod_menu', 'default_' . $item->type);
                break;

            default:
                require ModuleHelper::getLayoutPath('mod_menu', 'default_url');
                break;
        endswitch;


        // The next item is deeper.
        if ($item->deeper) {
            echo '<ul class="mod-menu__sub list-unstyled small">';
        } elseif ($item->shallower) {
            // The next item is shallower.
            echo '</li>';
            echo str_repeat('</ul></li>', $item->level_diff);
        } else {
            // The next item is on the same level.
            echo '</li>';
        }

    }
?>

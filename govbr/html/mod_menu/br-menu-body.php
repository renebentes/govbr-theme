<?php

/**
 * GovBR Theme based on Brazilian Design System available on https://gov.br/ds
 * for Joomla! Content Management System.
 *
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2025 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */

// No direct access.
\defined('_JEXEC') or exit('Restricted access!');

use Joomla\CMS\Helper\ModuleHelper;
use Joomla\Utilities\ArrayHelper;

$attributes          = [];
$attributes['class'] = trim('menu-body ' . $params->get('moduleclass_sfx'));

if ($tagId = $params->get('tag_id', '')) {
    $attributes['id'] = htmlspecialchars($tagId, ENT_QUOTES, 'UTF-8');
}

$attributes['role'] = 'tree';
$startLevel         = (int) $params->get('startLevel', 1);

?>
<nav <?php echo ArrayHelper::toString($attributes); ?>>
    <ul>
    <?php foreach ($list as $i => &$item) {
        $attributes['class'] = 'menu-item';
        $attributes['role']  = 'treeitem';

        if ($item->deeper && (int) $item->level === $startLevel) {
            echo '<li class="menu-folder">';
        } elseif ($item->deeper && (int) $item->level > $startLevel) {
            echo '<li class="side-menu">';
        } else {
            echo '<li>';
        }

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
            echo '<ul>';
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
    </ul>
</nav>

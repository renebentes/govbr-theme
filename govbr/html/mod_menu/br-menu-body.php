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
$attributes['class'] = trim('menu-body ' . $params->get('moduleclass_sfx'));

if ($tagId = $params->get('tag_id', '')) {
    $attributes['id'] = htmlspecialchars($tagId, ENT_QUOTES, 'UTF-8');
}

$attributes['role'] = 'tree';

?>
<nav <?php echo ArrayHelper::toString($attributes); ?>>
    <?php foreach ($list as $i => &$item) {
        $attributes['class'] = 'menu-item';
        $attributes['role']  = 'treeitem';

        if ($item->deeper) {
            echo '<div class="menu-folder">';
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
            echo '<li>';
        } elseif ($item->shallower) {
            // The next item is shallower.
            echo '</li>';
            echo str_repeat('</ul></li>', $item->level_diff);
            echo '</div>';
        }
    }
?>
</nav>

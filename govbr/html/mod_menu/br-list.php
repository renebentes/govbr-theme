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
<div <?php echo ArrayHelper::toString($attributes); ?>>

    <?php if ($module->showtitle) : ?>
    <div class="header">
        <div class="title">
            <?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>
        </div>
    </div>
    <?php endif; ?>

    <?php foreach ($list as $i => &$item) {
        $attributes['class'] = 'br-item';

        switch ($item->type) :
            case 'separator':
            case 'component':
            case 'heading':
            case 'url':
                require ModuleHelper::getLayoutPath('mod_menu', 'br-list_' . $item->type);
                break;

            default:
                require ModuleHelper::getLayoutPath('mod_menu', 'br-list_url');
                break;
        endswitch;

        // The next item is deeper.
        if ($item->deeper) {
            echo '<div>';
        } elseif ($item->shallower) {
            // The next item is shallower.
            echo '</div>';
        }

    }
?>

</div>

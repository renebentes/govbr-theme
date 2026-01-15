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
$attributes['class'] = trim('br-menu contextual ' . $params->get('moduleclass_sfx'));

if ($tagId = $params->get('tag_id', '')) {
    $attributes['id'] = htmlspecialchars($tagId, ENT_QUOTES, 'UTF-8');
}

?>
<div <?php echo ArrayHelper::toString($attributes); ?>>
    <div class="menu-trigger d-sm-none">
        <button class="br-button primary block py-4" type="button" data-toggle="contextual" aria-expanded="aria-expanded">
            <span class="mr-1"><?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?></span>
            <i class="fas fa-chevron-up ml-5" aria-hidden="true"></i>
        </button>
    </div>
    <div class="menu-container">
        <div class="menu-panel">
            <?php require ModuleHelper::getLayoutPath('mod_menu', 'br-menu-body'); ?>
        </div>
    </div>
</div>

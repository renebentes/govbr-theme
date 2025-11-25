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

use Joomla\CMS\Language\Text;
use Joomla\Utilities\ArrayHelper;

$module  = $displayData['module'];
$params  = $displayData['params'];
$attribs = $displayData['attribs'];

if ($module->content === null || $module->content === '') {
    return;
}

$moduleAttribs          = [];
$moduleAttribs['class'] = $module->position . ' ' . trim(htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_QUOTES, 'UTF-8') . ' dropdown');
$headerClass            = htmlspecialchars($params->get('header_class', ''), ENT_QUOTES, 'UTF-8');
$headerAttribs          = [];
$headerAttribs['class'] = $headerClass;

?>

<div <?php echo ArrayHelper::toString($moduleAttribs); ?>>
    <button class="br-button circle small" type="button" data-toggle="dropdown"
        aria-label="<?php echo Text::_('JOPEN') . ' ' . $module->title; ?>">
        <i <?php echo ArrayHelper::toString($headerAttribs);?> aria-hidden="true"></i>
    </button>

    <?php echo $module->content; ?>
</div>

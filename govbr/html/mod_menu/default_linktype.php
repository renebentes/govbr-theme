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

use Joomla\CMS\HTML\HTMLHelper;

$linktype = '';

if ($item->menu_icon
    || $item->menu_image) {
    $linktype = '<span class="icon">';

    if ($item->menu_icon) {
        $linktype .= '<i class="' . $item->menu_icon . '" aria-hidden="true"></i>';
    } elseif ($item->menu_image) {
        $image_attributes=[];

        if ($item->menu_image_css) {
            $image_attributes['class'] = trim('img-fluid ' . $item->menu_image_css);
        }

        $linktype = HTMLHelper::_('image', $item->menu_image, '', $image_attributes);
    }

    $linktype .= '</span>';
}

$linktype .= '<span class="content">' . $item->title . '</span>';

return $linktype;

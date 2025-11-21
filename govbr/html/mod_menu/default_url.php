<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBRDS
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (C) 2025 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @since       __DEPLOY_VERSION__
 */

// No direct access.
\defined('_JEXEC') or die('Restricted access!');

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Filter\OutputFilter;

$attributes = [];

if ($item->anchor_title) {
    $attributes['title'] = $item->anchor_title;
}

if ($item->anchor_css) {
    $attributes['class'] = $item->anchor_css;
}

if ($item->anchor_rel) {
    $attributes['rel'] = $item->anchor_rel;
}

$linktype = $item->title;

if ($item->menu_icon) {
    $linktype = '<i class="' . $item->menu_icon . '" aria-hidden="true"></i>';
    $linktype .= $itemParams->get('menu_text', 1) ? $item->title : '<span class="text">' . $item->title . '</span>';
} elseif ($item->menu_image) {
    $image_attributes=[];

    if ($item->menu_image_css) {
        $image_attributes['class'] = trim('img-fluid ' .$item->menu_image_css);
    }

    $linktype = HTMLHelper::_('image', $item->menu_image, '', $image_attributes);
    $linktype .= $itemParams->get('menu_text', 1) ? $item->title : '<span class="text">' . $item->title . '</span>';
}


if ($item->browserNav == 1) {
    $attributes['target'] = '_blank';
    $attributes['rel']    = 'noopener noreferrer';

    if ($item->anchor_rel == 'nofollow') {
        $attributes['rel'] .= ' nofollow';
    }
} elseif ($item->browserNav == 2) {
    $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');

    $attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo HTMLHelper::link(
    OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)),
    $linktype,
    $attributes
);

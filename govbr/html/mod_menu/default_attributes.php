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

$itemParams          = $item->getParams();
$attributes['class'] .= ' item-' . $item->id;

if ($item->id == $default_id) {
    $attributes['class'] .= ' default';
}

if ($item->id == $active_id || ($item->type === 'alias' && $itemParams->get('aliasoptions') == $active_id)) {
    $attributes['class'] .= ' current';
}

if (\in_array($item->id, $path)) {
    $attributes['class'] .= ' active';
} elseif ($item->type === 'alias') {
    $aliasToId = $itemParams->get('aliasoptions');

    if (\count($path) > 0 && $aliasToId == $path[\count($path) - 1]) {
        $attributes['class'] .= ' active';
    } elseif (\in_array($aliasToId, $path)) {
        $attributes['class'] .= ' alias-parent-active';
    }
}

if ($item->deeper) {
    $attributes['class'] .= ' deeper';
}

if ($item->parent) {
    $attributes['class'] .= ' parent';
}

if ($item->anchor_title) {
    $attributes['title'] = $item->anchor_title;
}

if ($item->anchor_css) {
    $attributes['class'] .= $item->anchor_css;
}

if ($item->anchor_rel) {
    $attributes['rel'] = $item->anchor_rel;
}

return $attributes;

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

use Joomla\Utilities\ArrayHelper;

// Convert icomoon to fa
$icon       = $displayData['icon'];

// Get fixed width icon or not
$iconFixed  = $displayData['fixed'] ?? null;

// Set default prefix to be fontawesome
$iconPrefix = $displayData['prefix'] ?? 'fas';

// Get other classNames if set, like icon-white, text-danger
$iconSuffix = $displayData['suffix'] ?? null;

// Get other attributes besides classNames
$tabindex   = $displayData['tabindex'] ?? null;
$title      = $displayData['title'] ?? null;

// Default output in <i>. ClassNames if set to false
$html       = $displayData['html'] ?? true;

if ($iconFixed) {
    $iconFixed = 'fa-fw';
}

// Just render icon as className
$icon = trim(implode(' ', [$iconPrefix, $icon, $iconFixed, $iconSuffix]));

// Convert icon to html output when HTML !== false
if ($html !== false) {
    $iconAttribs = [
        'class'       => $icon,
        'aria-hidden' => "true",
    ];

    if ($tabindex) {
        $iconAttribs['tabindex'] = $tabindex;
    }

    if ($title) {
        $iconAttribs['title'] = $title;
    }

    $icon = '<i ' . ArrayHelper::toString($iconAttribs) . '></i>';
}

echo $icon;

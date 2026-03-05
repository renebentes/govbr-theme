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

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\Filter\OutputFilter;

require __DIR__ . '/default_attributes.php';
require __DIR__ . '/br-list_linktype.php';

if ($item->id == $active_id) {
    $attributes['aria-current'] = 'location';

    if ($item->current) {
        $attributes['aria-current'] = 'page';
    }
}

if ($item->browserNav == 1) {
    $attributes['target'] = '_blank';
} elseif ($item->browserNav == 2) {
    $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';

    $attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo HTMLHelper::_(
    'link',
    OutputFilter::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)),
    $linktype,
    $attributes
);

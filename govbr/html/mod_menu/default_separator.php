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

use Joomla\Utilities\ArrayHelper;

require __DIR__ . '/default_attributes.php';

require __DIR__ . '/default_linktype.php';

$attributes['class'] = $attributes['class'] ? 'br-divider' . $attributes['class'] : 'br-divider';

?>
<span <?php echo ArrayHelper::toString($attributes); ?>><?php echo $linktype; ?></span>

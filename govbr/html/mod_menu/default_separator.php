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

use Joomla\Utilities\ArrayHelper;

require __DIR__ . '/default_attributes.php';
require __DIR__ . '/default_linktype.php';

$attributes['class'] = $attributes['class'] ? 'br-divider' . $attributes['class'] : 'br-divider';

?>
<span <?php echo ArrayHelper::toString($attributes); ?>><?php echo $linktype; ?></span>

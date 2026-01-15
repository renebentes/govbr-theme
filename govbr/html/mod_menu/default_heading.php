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

use Joomla\Utilities\ArrayHelper;

require __DIR__ . '/default_attributes.php';
require __DIR__ . '/default_linktype.php';

?>
<div <?php echo ArrayHelper::toString($attributes); ?>>
    <?php echo $linktype;?>
</div>

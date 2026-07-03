<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */
\defined('_JEXEC') or exit;

$items = $displayData;

if (!empty($items)) : ?>
    <ul class="br-list horizontal">
        <?php foreach ($items as $id => $item) : ?>
            <?php if (\is_array($item) && isset($item['link'])) : ?>
                <li class="br-item">
                    <?php echo $item['link']; ?>
                </li>
            <?php elseif (isset($item->link)) : ?>
                <li class="br-item">
                    <?php echo $item->link; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

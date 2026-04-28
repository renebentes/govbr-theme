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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\WebAsset\WebAssetManager;

/** @var WebAssetManager $wa */
$wa = Factory::getDocument()->getWebAssetManager();
$wa->useScript('govbr.pagination');

$list = $displayData['list'];

?>
<nav class="br-pagination" aria-label="<?php echo Text::_('JLIB_HTML_PAGINATION'); ?>" data-total="<?= \count($list); ?>">
    <ul>
        <?= $list['start']['data']; ?>
        <?= $list['previous']['data']; ?>

        <?php foreach ($list['pages'] as $page) : ?>
            <?= $page['data']; ?>
        <?php endforeach; ?>

        <?= $list['next']['data']; ?>
        <?= $list['end']['data']; ?>
    </ul>
</nav>

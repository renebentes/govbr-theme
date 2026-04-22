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
$wa->useScript('govbr.tooltip');

if (isset($displayData['ariaDescribed'])) {
    $aria_described = $displayData['ariaDescribed'];
} elseif (isset($displayData['article'])) {
    $article        = $displayData['article'];
    $aria_described = 'editarticle-' . (int) $article->id;
} elseif (isset($displayData['contact'])) {
    $contact        = $displayData['contact'];
    $aria_described = 'editcontact-' . (int) $contact->id;
}

$tooltip = $displayData['tooltip'];
?>

<i class="fas fa-eye-slash" aria-hidden="true"></i>
<span class="sr-only"><?php echo Text::_('JLIB_HTML_CHECKED_OUT'); ?></span>
<div class="br-tooltip" id="<?= $aria_described; ?>" role="tooltip">
    <?= $tooltip; ?>
</div>

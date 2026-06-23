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

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$article = $displayData['article'];
$tooltip = $displayData['tooltip'];
$nowDate = strtotime(Factory::getDate());

$icon          = $article->state ? 'edit' : 'eye-slash';
$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($article->publish_up > $currentDate)
    || !\is_null($article->publish_down) && ($article->publish_down < $currentDate);

if ($isUnpublished) {
    $icon = 'eye-slash';
}
$aria_described = 'editarticle-' . (int) $article->id;

?>
<i class="fas fa-<?php echo $icon; ?>" aria-hidden="true"></i>
<span class="sr-only"><?php echo Text::_('JGLOBAL_EDIT'); ?></span>
<div class="br-tooltip" id="<?php echo $aria_described; ?>" role="tooltip">
    <?php echo $tooltip; ?>
</div>

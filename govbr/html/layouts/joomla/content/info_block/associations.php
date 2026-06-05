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

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>

<?php if (!empty($displayData['item']->associations)) : ?>
    <?php $associations = $displayData['item']->associations; ?>

    <dd class="associations">
        <i class="fas fa-globe mx-1" aria-hidden="true"></i>
        <?php echo Text::_('JASSOCIATIONS'); ?>
        <?php foreach ($associations as $association) : ?>
            <?php $class = 'br-button secondary circle small ml-1'; ?>
            <?php if ($displayData['item']->params->get('flags', 1) && $association['language']->image) : ?>
                <?php $flag = HTMLHelper::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, ['title' => $association['language']->title_native], true); ?>
                <a href="<?php echo Route::_($association['item']); ?>" class="<?= $class; ?>"><?php echo $flag; ?></a>
            <?php else : ?>
                <?php $class .= strtolower($association['language']->lang_code); ?>
                <a href="<?php echo Route::_($association['item']); ?>" class="<?= $class; ?>" title="<?= $association['language']->title_native; ?>">
                    <?= $association['language']->lang_code; ?>
                    <span class="sr-only"><?= $association['language']->title_native; ?></span>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </dd>
<?php endif; ?>

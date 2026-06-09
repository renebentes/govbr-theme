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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

?>
<div class="br-menu contextual" aria-labelledby="#toc">
    <div class="menu-trigger">
        <button type="button" class="br-button primary block" data-toggle="contextual">
            <span id="toc" class="mr-1"><?php echo Text::_('PLG_CONTENT_PAGEBREAK_TOC_LABEL'); ?></span>
            <i class="fas fa-chevron-up ml-5" aria-hidden="true"></i>
        </button>
    </div>
    <div class="menu-container position-static">
        <div class="menu-panel">
            <nav class="menu-body">
                <div class="menu-folder">
                    <?php if ($headingtext) : ?>
                        <div class="menu-item">
                            <h4 class="content"><?php echo $headingtext; ?></h4>
                        </div>

                    <?php endif; ?>
                    <ul>
                        <?php foreach ($list as $listItem) : ?>
                            <?php $class = $listItem->active ? ' active' : ''; ?>
                            <li role="none">
                                <a href="<?php echo Route::_($listItem->link); ?>" class="menu-item<?php echo $class; ?>">
                                    <?php echo htmlspecialchars($listItem->title, ENT_QUOTES, 'UTF-8'); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="menu-scrim" data-dismiss="menu" tabindex="0"></div>
    </div>
</div>

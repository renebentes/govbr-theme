<?php

/**
 * GovBR Theme based on Brazilian Design System available on https://gov.br/ds
 * for Joomla! Content Management System.
 *
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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Plugin\Content\PageBreak\Extension\PageBreak;

/**
 * @var PageBreak $this
 * @var array     $links  Array with keys 'previous' and 'next' with non-SEO links to the previous and next pages
 * @var int       $page   The page number
 */
$lang = $this->getApplication()->getLanguage();

?>
<nav class="br-pagination mt-4">
    <div class="pagination-arrows">
        <?php if ($links['previous']) :
            $direction = $lang->isRtl() ? 'right' : 'left';
            $title     = htmlspecialchars($this->list[$page]->title, ENT_QUOTES, 'UTF-8');
            $ariaLabel = Text::_('JPREVIOUS') . ': ' . $title . ' (' . Text::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', $page, $n) . ')';
            ?>
        <a class="br-button secondary"
            href="<?php echo Route::_($links['previous']); ?>"
            title="<?php echo $title; ?>"
            aria-label="<?php echo $ariaLabel; ?>"
            rel="prev">
            <i class="fas fa-chevron-<?php echo $direction; ?>" aria-hidden="true"></i>
            <?php echo Text::_('JPREV'); ?>
        </a>
        <?php endif; ?>
        <?php if ($links['next']) :
            $direction = $lang->isRtl() ? 'left' : 'right';
            $title     = htmlspecialchars($this->list[$page + 2]->title, ENT_QUOTES, 'UTF-8');
            $ariaLabel = Text::_('JNEXT') . ': ' . $title . ' (' . Text::sprintf('JLIB_HTML_PAGE_CURRENT_OF_TOTAL', $page + 2, $n) . ')';
            ?>
        <a class="br-button secondary"
            href="<?php echo Route::_($links['next']); ?>"
            title="<?php echo $title; ?>"
            aria-label="<?php echo $ariaLabel; ?>"
            rel="next">
            <?php echo Text::_('JNEXT'); ?>
            <i class="fas fa-chevron-<?php echo $direction; ?>" aria-hidden="true"></i>
        </a>
        <?php endif; ?>
    </div>
</nav>

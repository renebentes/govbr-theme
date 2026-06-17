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
 * @since       __DEPLOY_VERSION__
 */

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Component\Content\Site\Helper\RouteHelper;

/** @var \Joomla\Component\Content\Site\View\Category\HtmlView $this */
$lang   = $this->getLanguage();
$user   = $this->getCurrentUser();
$groups = $user->getAuthorisedViewLevels();
?>

<?php if (\count($this->children[$this->category->id]) > 0) : ?>
    <?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
        <?php // Check whether category access level allows access to subcategories.
        ?>
        <?php if (\in_array($child->access, $groups)) : ?>
            <?php if ($this->params->get('show_empty_categories') || $child->getNumItems(true) || \count($child->getChildren())) : ?>
                <div class="br-item" role="listitem" <?php echo (\count($child->getChildren()) > 0 && $this->maxLevel > 1) ? ' data-toggle="collapse" data-target="category-' . $child->id . '"' : ''; ?>>
                    <div class="row">
                        <div class="col">
                            <h4 class="my-1">
                                <?php if ($lang->isRtl()) : ?>
                                    <?php if ($this->params->get('show_cat_num_articles', 1)) : ?>
                                        <span class="br-tag count bg-info" data-tooltip-text="<?php echo HTMLHelper::_('tooltipText', 'COM_CONTENT_NUM_ITEMS'); ?>">
                                            <?php echo $child->getNumItems(true); ?>
                                        </span>
                                    <?php endif; ?>
                                    <a href="<?php echo Route::_(RouteHelper::getCategoryRoute($child->id, $child->language)); ?>">
                                        <?php echo $this->escape($child->title); ?></a>
                                <?php else : ?>
                                    <a href="<?php echo Route::_(RouteHelper::getCategoryRoute($child->id, $child->language)); ?>">
                                        <?php echo $this->escape($child->title); ?></a>
                                    <?php if ($this->params->get('show_cat_num_articles', 1)) : ?>
                                        <span class="br-tag count bg-info" data-tooltip-text="<?php echo HTMLHelper::_('tooltipText', 'COM_CONTENT_NUM_ITEMS'); ?>">
                                            <?php echo $child->getNumItems(true); ?>
                                        </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </h4>
                            <?php if ($this->params->get('show_subcat_desc') == 1) : ?>
                                <?php if ($child->description) : ?>
                                    <div class="description">
                                        <?php echo HTMLHelper::_('content.prepare', $child->description, '', 'com_content.category'); ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                        <?php if (\count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
                            <div class="col-auto">
                                <button type="button" class="br-button circle small" aria-label="<?php echo Text::_('JGLOBAL_EXPAND_CATEGORIES'); ?>">
                                    <i class="fas fa-chevron-down" aria-hidden="true"></i>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (\count($child->getChildren()) > 0 && $this->maxLevel > 1) : ?>
                    <div class="br-list ease" id="category-<?php echo $child->id; ?>" role="list" hidden>
                        <?php $this->children[$child->id] = $child->getChildren(); ?>
                        <?php $this->category             = $child; ?>
                        <?php $this->maxLevel--; ?>
                        <?php echo $this->loadTemplate('children'); ?>
                        <?php $this->category = $child->getParent(); ?>
                        <?php $this->maxLevel++; ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

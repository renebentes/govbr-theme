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

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Associations;
use Joomla\CMS\Language\Multilanguage;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Component\Content\Administrator\Extension\ContentComponent;
use Joomla\Component\Content\Site\Helper\AssociationHelper;
use Joomla\Component\Content\Site\Helper\RouteHelper;

/** @var \Joomla\Component\Content\Site\View\Category\HtmlView $this */
/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $this->getDocument()->getWebAssetManager();
$wa->useScript('com_content.articles-list');

// Create some shortcuts.
$n          = \count($this->items);
$listOrder  = $this->escape($this->state->get('list.ordering'));
$listDirn   = $this->escape($this->state->get('list.direction'));
$langFilter = false;

// Tags filtering based on language filter
if (($this->params->get('filter_field') === 'tag') && (Multilanguage::isEnabled())) {
    $tagfilter = ComponentHelper::getParams('com_tags')->get('tag_list_language_filter');

    switch ($tagfilter) {
        case 'current_language':
            $langFilter = Factory::getApplication()->getLanguage()->getTag();
            break;

        case 'all':
            $langFilter = false;
            break;

        default:
            $langFilter = $tagfilter;
    }
}

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items)) {
    foreach ($this->items as $article) {
        if ($article->params->get('access-edit')) {
            $isEditable = true;
            break;
        }
    }
}

$currentDate = Factory::getDate()->format('Y-m-d H:i:s');
?>

<form action="<?php echo htmlspecialchars(Uri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm">
    <?php if ($this->params->get('filter_field') !== 'hide') : ?>
        <legend><?php echo Text::_('COM_CONTENT_FORM_FILTER_LEGEND'); ?></legend>
        <div class="col-sm-5 col-lg-4 mb-3">
            <?php if ($this->params->get('filter_field') === 'tag') : ?>
                <?php echo LayoutHelper::render(
                    'govbr.form.select',
                    [
                        'name'        => 'filter-tag',
                        'id'          => 'filter-search',
                        'label'       => Text::_('JOPTION_SELECT_TAG'),
                        'labelclass'  => 'sr-only',
                        'placeholder' => Text::_('JOPTION_SELECT_TAG'),
                        'options'     => HTMLHelper::_('tag.options', ['filter.published' => [1], 'filter.language' => $langFilter], true),
                        'selected'    => $this->state->get('filter.tag'),
                        'onchange'    => 'document.adminForm.submit();',
                    ]
                ); ?>
            <?php elseif ($this->params->get('filter_field') === 'month') : ?>
                <?php echo LayoutHelper::render(
                    'govbr.form.select',
                    [
                        'name'        => 'filter-search',
                        'id'          => 'filter-search',
                        'label'       => Text::_('JOPTION_SELECT_MONTH'),
                        'labelclass'  => 'sr-only',
                        'placeholder' => Text::_('JOPTION_SELECT_MONTH'),
                        'options'     => HTMLHelper::_('content.months', $this->state),
                        'selected'    => $this->state->get('list.filter'),
                        'onchange'    => 'document.adminForm.submit();',
                    ]
                ); ?>
            <?php else : ?>
                <?php echo LayoutHelper::render(
                    'joomla.form.field.text',
                    [
                        'name'        => 'filter-search',
                        'id'          => 'filter-search',
                        'label'       => Text::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'),
                        'value'       => $this->escape($this->state->get('list.filter')),
                        'onchange'    => 'document.adminForm.submit();',
                        'placeholder' => Text::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'),
                    ]
                ); ?>
            <?php endif; ?>
        </div>
        <div class="col-sm-5 col-lg-4 d-flex">
            <button type="reset" name="filter-clear-button" class="br-button secondary ml-auto"><?php echo Text::_('JSEARCH_FILTER_CLEAR'); ?></button>
            <?php if ($this->params->get('filter_field') !== 'tag' && $this->params->get('filter_field') !== 'month') : ?>
                <button type="submit" name="filter_submit" class="br-button primary ml-3"><?php echo Text::_('JGLOBAL_FILTER_BUTTON'); ?></button>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if ($this->category->getParams()->get('access-create')) : ?>
        <?php echo LayoutHelper::render(
            'govbr.content.icons.create',
            [
                'category' => $this->category,
                'params'   => $this->category->params,
                'attribs'  => [
                    'class' => 'mt-2',
                ],
            ]
        ); ?>

    <?php endif; ?>

    <hr>
    <div class="br-table">
        <div class="table-header">
            <div class="top-bar">
                <h3 class="title m-1"><?php echo Text::_('COM_CONTENT_ARTICLES_TABLE_CAPTION'); ?></h3>
            </div>
        </div>

        <?php if (empty($this->items)) : ?>
            <?php if ($this->params->get('show_no_articles', 1)) : ?>
                <div class="br-message info">
                    <div class="icon">
                        <i class="fas fa-info-circle" aria-hidden="true"></i>
                    </div>
                    <div class="content" aria-label="<?php echo Text::_('INFO'); ?>">
                        <span class="message-title"><?php echo Text::_('INFO'); ?>.</span>
                        <span class="message-body"><?php echo Text::_('COM_CONTENT_NO_ARTICLES'); ?></span>
                    </div>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <table>
                <caption>
                    <?php echo Text::_('COM_CONTENT_ARTICLES_TABLE_CAPTION'); ?>
                </caption>
                <thead<?php echo $this->params->get('show_headings', '1') ? '' : ' class="sr-only"'; ?>>
                    <tr>
                        <th scope="col">
                            <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'JGLOBAL_TITLE', 'order' => 'a.title', 'direction' => $listDirn, 'selected' => $listOrder, 'newDirection' => 'asc', 'form' => 'adminForm']); ?>
                        </th>
                        <?php if ($date = $this->params->get('list_show_date')) : ?>
                            <th scope="col">
                                <?php if ($date === 'created') : ?>
                                    <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'COM_CONTENT_' . $date . '_DATE', 'order' => 'a.created', 'direction' => $listDirn, 'selected' => $listOrder]); ?>
                                <?php elseif ($date === 'modified') : ?>
                                    <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'COM_CONTENT_' . $date . '_DATE', 'order' => 'a.modified', 'direction' => $listDirn, 'selected' => $listOrder]); ?>
                                <?php elseif ($date === 'published') : ?>
                                    <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'COM_CONTENT_' . $date . '_DATE', 'order' => 'a.publish_up', 'direction' => $listDirn, 'selected' => $listOrder]); ?>
                                <?php endif; ?>
                            </th>
                        <?php endif; ?>
                        <?php if ($this->params->get('list_show_author')) : ?>
                            <th scope="col">
                                <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'JAUTHOR', 'order' => 'author', 'direction' => $listDirn, 'selected' => $listOrder]); ?>
                            </th>
                        <?php endif; ?>
                        <?php if ($this->params->get('list_show_hits')) : ?>
                            <th scope="col">
                                <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'JGLOBAL_HITS', 'order' => 'a.hits', 'direction' => $listDirn, 'selected' => $listOrder]); ?>
                            </th>
                        <?php endif; ?>
                        <?php if ($this->params->get('list_show_votes', 0) && $this->vote) : ?>
                            <th scope="col">
                                <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'COM_CONTENT_VOTES', 'order' => 'rating_count', 'direction' => $listDirn, 'selected' => $listOrder]); ?>
                            </th>
                        <?php endif; ?>
                        <?php if ($this->params->get('list_show_ratings', 0) && $this->vote) : ?>
                            <th scope="col">
                                <?php echo LayoutHelper::render('govbr.content.grid.sort', ['title' => 'COM_CONTENT_RATINGS', 'order' => 'rating', 'direction' => $listDirn, 'selected' => $listOrder]); ?>
                            </th>
                        <?php endif; ?>
                        <?php if ($isEditable) : ?>
                            <th scope="col"><?php echo Text::_('COM_CONTENT_EDIT_ITEM'); ?></th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($this->items as $i => $article) : ?>
                            <tr class="cat-list-row<?php echo $i % 2; ?>">
                                <td scope="row">
                                    <?php if (\in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
                                        <a href="<?php echo Route::_(RouteHelper::getArticleRoute($article->slug, $article->catid, $article->language)); ?>">
                                            <?php echo $this->escape($article->title); ?>
                                        </a>
                                    <?php else : ?>
                                        <?php echo $this->escape($article->title) . ' : '; ?>
                                        <?php $itemId = Factory::getApplication()->getMenu()->getActive()->id; ?>
                                        <?php $link   = new Uri(Route::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false)); ?>
                                        <?php $link->setVar('return', base64_encode(RouteHelper::getArticleRoute($article->slug, $article->catid, $article->language))); ?>
                                        <a href="<?php echo $link; ?>">
                                            <?php echo Text::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (Associations::isEnabled() && $this->params->get('show_associations')) : ?>
                                        <?php $associations = AssociationHelper::displayAssociations($article->id); ?>
                                        <?php foreach ($associations as $association) : ?>
                                            <?php $class = 'br-button secondary circle small ml-1'; ?>
                                            <?php if ($this->params->get('flags', 1) && $association['language']->image) : ?>
                                                <?php $flag = HTMLHelper::_('image', 'mod_languages/' . $association['language']->image . '.gif', $association['language']->title_native, ['title' => $association['language']->title_native], true); ?>
                                                <a href="<?php echo Route::_($association['item']); ?>" class="<?php echo $class; ?>"><?php echo $flag; ?></a>
                                            <?php else : ?>
                                                <?php $class .= strtolower($association['language']->lang_code); ?>
                                                <a class="<?php echo $class; ?>" title="<?php echo $association['language']->title_native; ?>" href="<?php echo Route::_($association['item']); ?>"><?php echo $association['language']->lang_code; ?>
                                                    <span class="sr-only"><?php echo $association['language']->title_native; ?></span>
                                                </a>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if ($article->state == ContentComponent::CONDITION_UNPUBLISHED) : ?>
                                        <span class="br-tag bg-warning"><?php echo Text::_('JUNPUBLISHED'); ?></span>
                                    <?php endif; ?>
                                    <?php if ($article->publish_up > $currentDate) : ?>
                                        <span class="br-tag bg-warning"><?php echo Text::_('JNOTPUBLISHEDYET'); ?></span>
                                    <?php endif; ?>
                                    <?php if (!\is_null($article->publish_down) && $article->publish_down < $currentDate) : ?>
                                        <span class="br-tag bg-warning"><?php echo Text::_('JEXPIRED'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($this->params->get('list_show_date')) : ?>
                                    <td>
                                        <?php
                                        echo HTMLHelper::_(
                                            'date',
                                            $article->displayDate,
                                            $this->escape($this->params->get('date_format', Text::_('DATE_FORMAT_LC3')))
                                        ); ?>
                                    </td>
                                <?php endif; ?>
                                <?php if ($this->params->get('list_show_author', 1)) : ?>
                                    <td>
                                        <?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>
                                            <?php $author = $article->author ?>
                                            <?php $author = $article->created_by_alias ?: $author; ?>
                                            <?php if (!empty($article->contact_link) && $this->params->get('link_author')) : ?>
                                                <?php if ($this->params->get('show_headings')) : ?>
                                                    <?php echo HTMLHelper::_('link', $article->contact_link, $author); ?>
                                                <?php else : ?>
                                                    <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', HTMLHelper::_('link', $article->contact_link, $author)); ?>
                                                <?php endif; ?>
                                            <?php else : ?>
                                                <?php if ($this->params->get('show_headings')) : ?>
                                                    <?php echo $author; ?>
                                                <?php else : ?>
                                                    <?php echo Text::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                                <?php if ($this->params->get('list_show_hits', 1)) : ?>
                                    <td>
                                        <span class="br-tag count bg-info">
                                            <?php if ($this->params->get('show_headings')) : ?>
                                                <?php echo $article->hits; ?>
                                            <?php else : ?>
                                                <?php echo Text::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($this->params->get('list_show_votes', 0) && $this->vote) : ?>
                                    <td>
                                        <span class="br-tag count bg-success">
                                            <?php if ($this->params->get('show_headings')) : ?>
                                                <?php echo $article->rating_count; ?>
                                            <?php else : ?>
                                                <?php echo Text::sprintf('COM_CONTENT_VOTES_COUNT', $article->rating_count); ?>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($this->params->get('list_show_ratings', 0) && $this->vote) : ?>
                                    <td>
                                        <span class="br-tag count bg-warning">
                                            <?php if ($this->params->get('show_headings')) : ?>
                                                <?php echo $article->rating; ?>
                                            <?php else : ?>
                                                <?php echo Text::sprintf('COM_CONTENT_RATINGS_COUNT', $article->rating); ?>
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($isEditable) : ?>
                                    <td>
                                        <?php if ($article->params->get('access-edit')) : ?>
                                            <?php echo HTMLHelper::_('contenticon.edit', $article, $article->params); ?>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
            </table>

        <?php endif; ?>

        <?php if (
            $this->params->get('show_pagination_limit')
            || ($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2))
        ) : ?>
            <div class="table-footer">

                <nav
                    class="br-pagination"
                    aria-label="<?php echo Text::_('JLIB_HTML_PAGINATION'); ?>"
                    data-total="<?php echo $this->pagination->total; ?>"
                    data-per-page="<?php echo $this->pagination->limit; ?>">

                    <?php if ($this->params->get('show_pagination_limit')) : ?>
                        <?php echo LayoutHelper::render(
                            'govbr.pagination.limit_box',
                            [
                                'pagination' => $this->pagination,
                                'class'      => $this->pagination->pagesTotal = 1 ? ' mr-auto' : '',
                            ]
                        ); ?>
                    <?php endif; ?>

                    <?php if (!empty($this->items)) : ?>
                        <?php if (($this->params->def('show_pagination', 2) == 1 || ($this->params->get('show_pagination') == 2))
                            && ($this->pagination->pagesTotal > 1)
                        ) : ?>

                            <?php if ($this->params->get('show_pagination_limit')): ?>
                                <span class="br-divider d-none d-sm-block"></span>
                            <?php endif; ?>

                            <div class="pagination-arrows mx-auto">
                                <?php echo $this->pagination->getPagesLinks(); ?>
                            </div>

                            <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                                <span class="br-divider d-none d-sm-block mr-3"></span>
                                <div class="pagination-information d-none d-sm-flex">
                                    <?php echo $this->pagination->getPagesCounter(); ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>

    <input type="hidden" name="filter_order" value="">
    <input type="hidden" name="filter_order_Dir" value="">
    <input type="hidden" name="limitstart" value="">
    <input type="hidden" name="task" value="">

</form>

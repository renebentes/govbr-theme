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

use Joomla\CMS\Event\Content;
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\Component\Content\Site\View\Category\HtmlView;

$app = Factory::getApplication();

/**
 * @var HtmlView $this
 */
$this->category->text = $this->category->description;

$contentEventArguments = [
    'context' => $this->category->extension . '.categories',
    'subject' => &$this->category,
    'params'  => &$this->params,
    'page'    => 0,
];

$app->getDispatcher()
    ->dispatch(
        'onContentPrepare',
        new Content\ContentPrepareEvent(
            'onContentPrepare',
            $contentEventArguments
        )
    )
;
$this->category->description = $this->category->text;

$results = $app
    ->getDispatcher()
    ->dispatch(
        'onContentAfterTitle',
        new Content\AfterTitleEvent(
            'onContentAfterTitle',
            $contentEventArguments
        )
    )->getArgument('result', [])
;
$afterDisplayTitle = trim(implode("\n", $results));

$results = $app
    ->getDispatcher()
    ->dispatch(
        'onContentBeforeDisplay',
        new Content\BeforeDisplayEvent(
            'onContentBeforeDisplay',
            $contentEventArguments
        )
    )->getArgument('result', [])
;
$beforeDisplayContent = trim(implode("\n", $results));

$results = $app
    ->getDispatcher()
    ->dispatch(
        'onContentAfterDisplay',
        new Content\AfterDisplayEvent(
            'onContentAfterDisplay',
            $contentEventArguments
        )
    )->getArgument('result', [])
;
$afterDisplayContent = trim(implode("\n", $results));

$htag = $this->params->get('show_page_heading') ? 'h2' : 'h1';

?>
<section class="com-content-category-blog">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
        </div>
    <?php endif; ?>

    <?php if ($this->params->get('show_category_title', 1)) : ?>
        <<?php echo $htag; ?>>
            <?php echo $this->category->title; ?>
        </<?php echo $htag; ?>>
    <?php endif; ?>
    <?php echo $afterDisplayTitle; ?>

    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
        <?php $this->category->tagLayout = new FileLayout('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php endif; ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
        <div class="description">
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <?php echo LayoutHelper::render(
                    'joomla.html.image',
                    [
                        'src' => $this->category->getParams()->get('image'),
                        'alt' => empty($this->category->getParams()->get('image_alt')) && empty($this->category->getParams()->get('image_alt_empty')) ? false : $this->category->getParams()->get('image_alt'),
                    ]
                ); ?>
            <?php endif; ?>
            <?php echo $beforeDisplayContent; ?>
            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                <?php echo HTMLHelper::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
            <?php endif; ?>
            <?php echo $afterDisplayContent; ?>
        </div>
    <?php endif; ?>

    <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
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
    <?php endif; ?>

    <?php if (!empty($this->lead_items)) : ?>
        <?php $leadingClass = trim('blog-items items-leading ' . $this->params->get('blog_class_leading', '')); ?>
        <div class="<?php echo $leadingClass; ?>">
            <?php foreach ($this->lead_items as &$item) : ?>
                <div class="blog-item">
                    <?php $this->item = &$item; ?>
                    <?php echo $this->loadTemplate('item'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($this->intro_items)) : ?>
        <?php $blogClass = trim('blog-items ' . $this->params->get('blog_class', '')); ?>
        <?php if ((int) $this->params->get('num_columns') > 1) : ?>
            <?php $blogClass .= (int) $this->params->get('multi_column_order', 0) === 0 ? ' masonry-' : ' columns-'; ?>
            <?php $blogClass .= (int) $this->params->get('num_columns'); ?>
        <?php endif; ?>
        <div class="<?php echo $blogClass; ?>">
            <?php foreach ($this->intro_items as $key => &$item) : ?>
                <div class="blog-item">
                    <?php $this->item = &$item; ?>
                    <?php echo $this->loadTemplate('item'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($this->link_items)) : ?>
        <div class="items-more">
            <?php echo $this->loadTemplate('links'); ?>
        </div>
    <?php endif; ?>

    <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
        <hr>
        <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
            <h3> <?php echo Text::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
        <?php endif; ?>
        <div class="br-list" role="list">
            <?php echo $this->loadTemplate('children'); ?>
        </div>
    <?php endif; ?>
    <?php // Code to add a link to submit an article.
    ?>
    <?php if ($this->category->getParams()->get('access-create')) : ?>
        <?php echo LayoutHelper::render(
            'govbr.content.icons.create',
            [
                'category' => $this->category,
                'params'   => $this->category->params,
                'attribs'  => ['class' => 'mt-2'],
            ]
        ); ?>
    <?php endif; ?>

    <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
        <nav class="br-pagination"
            aria-label="<?php echo Text::_('JLIB_HTML_PAGINATION'); ?>"
            data-total="<?php echo $this->pagination->total; ?>">
            <div class="pagination-arrows mx-auto">
                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
            <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                <span class="br-divider d-none d-sm-block mr-3"></span>
                <div class="pagination-information d-none d-sm-flex">
                    <?php echo $this->pagination->getPagesCounter(); ?>
                </div>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>

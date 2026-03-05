<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (C) 2025 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @since       __DEPLOY_VERSION__
 */

// No direct access.
\defined('_JEXEC') or die('Restricted access!');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app   = Factory::getApplication();
$input = $app->getInput();
$wa    = $this->getWebAssetManager();

// Browsers support SVG favicons
$this->addHeadLink(
    HTMLHelper::_('image', 'favicon.svg', '', [], true, 1),
    'icon',
    'rel',
    ['type' => 'image/svg+xml']
);
$this->addHeadLink(
    HTMLHelper::_('image', 'favicon.ico', '', [], true, 1),
    'alternate icon',
    'rel',
    ['type' => 'image/vnd.microsoft.icon']
);
$this->addHeadLink(
    HTMLHelper::_('image', 'apple-icon-touch', '', [], true, 1),
    'apple-icon-touch',
    'rel',
    ['type' => 'image/png']
);
$this->addHeadLink(
    HTMLHelper::_('image', 'safari-pinned-tab.svg', '', [], true, 1),
    'mask-icon',
    'rel',
    ['color' => '#00a300']
);

// Detecting Active Variables
$sitename  = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu      = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

$logo = HTMLHelper::_(
    'image',
    'govbr.svg',
    $sitename,
    [
        'height'   => '40px',
        'loading'  => 'eager',
        'decoding' => 'async'
    ],
    true,
    0
);

if ($this->params->get('logo')) {
    $logo = HTMLHelper::_(
        'image',
        Uri::root(false) . htmlspecialchars($this->params->get('logo'), ENT_QUOTES),
        $sitename,
        [
            'height'   => '40px',
            'loading'  => 'eager',
            'decoding' => 'async',
        ],
        true,
        0
    );
}

$footerLogo = HTMLHelper::_(
    'image',
    'govbr-negativa.svg',
    $sitename,
    [
        'height'   => '40px',
        'loading'  => 'eager',
        'decoding' => 'async',
    ],
    true,
    0
);

if ($this->params->get('logo')) {
    $logo = HTMLHelper::_(
        'image',
        Uri::root(false) . htmlspecialchars($this->params->get('logo'), ENT_QUOTES),
        $sitename,
        [
            'height'   => '40px',
            'loading'  => 'eager',
            'decoding' => 'async',
        ],
        true,
        0
    );
}

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');

$wa->useStyle('template.govbr')
    ->useScript('template.govbr.script');

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
    <jdoc:include type="metas" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&amp;display=swap" />

    <jdoc:include type="styles" />
</head>

<body class="template-base<?php echo $pageclass ? ' ' . $pageclass : ''; ?>">

    <nav class="br-skiplink" role="menubar">
        <a class="br-item" href="#main-content" role="menuitem" accesskey="1">
            <?php echo Text::_('TPL_GOVBR_GO_TO_CONTENT'); ?>
            <span aria-hidden="true">(1/4)</span>
            <span aria-hidden="true" class="br-tag text ml-1">1</span>
        </a>
        <a class="br-item" href="#header-navigation" role="menuitem" accesskey="2">
            <?php echo Text::_('TPL_GOVBR_GO_TO_MENU'); ?>
            <span aria-hidden="true">(2/4)</span>
            <span aria-hidden="true" class="br-tag text ml-1">2</span>
        </a>
        <a class="br-item" href="#main-searchbox" role="menuitem" accesskey="3">
            <?php echo Text::_('TPL_GOVBR_GO_TO_SEARCH'); ?>
            <span aria-hidden="true">(3/4)</span>
            <span aria-hidden="true" class="br-tag text ml-1">3</span>
        </a>
        <a class="br-item" href="#footer" role="menuitem" accesskey="4">
            <?php echo Text::_('TPL_GOVBR_GO_TO_FOOTER'); ?>
            <span aria-hidden="true">(4/4)</span>
            <span aria-hidden="true" class="br-tag text ml-1">4</span>
        </a>
    </nav>
    <header class="br-header mb-4" id="header">
        <div class="container-lg">
            <div class="header-top">
                <div class="header-logo">
                    <a href="<?php echo $this->baseurl; ?>">
                        <?php echo $logo; ?>
                    </a>

                    <?php if ($this->params->get('sign', '')) : ?>
                        <span class="br-divider vertical"></span>
                        <div class="header-sign">
                            <?php echo $this->params->get('sign'); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="header-actions">
                    <jdoc:include type="modules" name="header-links" style="header-actions" />

                    <?php if ($this->countModules('header-links')): ?>
                        <span class="br-divider vertical mx-half mx-sm-1"></span>
                    <?php endif; ?>

                    <button class="br-button circle small toggle-contrast" type="button" aria-label="<?php echo Text::_('TPL_GOVBR_HIGH_CONTRAST'); ?>">
                        <i class="fas fa-adjust" aria-hidden="true"></i>
                    </button>

                    <jdoc:include type="modules" name="header-functions" style="header-actions" />
                </div>
            </div>

            <div class="header-bottom">
                <div class="header-menu">
                    <div class="header-menu-trigger">
                        <button class="br-button small circle" type="button" aria-label="<?php echo Text::_('TPL_GOVBR_OPEN_MENU'); ?>" data-toggle="menu"
                            data-target="#main-navigation" id="navigation">
                            <span class="fas fa-bars" aria-hidden="true"></span>
                        </button>
                    </div>
                    <div class="header-info">
                        <div class="header-title">
                            <?php echo $this->params->get('title', ''); ?>
                        </div>
                        <?php if ($this->params->get('subtitle', '')) : ?>
                            <div class="header-subtitle">
                                <?php echo $this->params->get('subtitle'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <jdoc:include type="modules" name="header-search" style="none" />
            </div>
        </div>
    </header>

    <main class="d-flex flex-fill mb-5">
        <div class="container-lg">
            <div class="row">
                <div class="br-menu" id="main-navigation">
                    <div class="menu-container">
                        <div class="menu-panel">
                            <?php if ($this->params->get('menuHeader')) : ?>
                                <div class="menu-header">
                                    <div class="menu-title">
                                        <?php echo $logo; ?>
                                        <span><?php echo $this->params->get('title', ''); ?></span>
                                    </div>
                                    <div class="menu-close">
                                        <button class="br-button circle" type="button" aria-label="<?php echo Text::_('TPL_GOVBR_CLOSE_MENU'); ?>"
                                            data-dismiss="menu">
                                            <i class="fas fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <jdoc:include type="modules" name="main-navigation" style="none" />

                            <div class="menu-footer"></div>
                        </div>
                        <div class="menu-scrim" data-dismiss="menu" tabindex="0"></div>
                    </div>
                </div>
            </div>

            <div class="main-content pl-sm-3 mt-4" id="main-content">
                <jdoc:include type="component" />
            </div>
        </div>
    </main>

    <footer class="br-footer pt-3" id="footer">
        <div class="container-lg">
            <div class="logo"><?php echo $footerLogo; ?></div>
        </div>

        <?php if ($this->params->get('legal', '')) : ?>
            <div class="info dark py-3">
                <?php echo $this->params->get('legal', ''); ?>
            </div>
        <?php endif; ?>
    </footer>
    <nav class="scroll-top">
        <button type="button" class="br-button primay circle"
            aria-label="<?php echo Text::_('TPL_GOVBR_GO_TO_TOP'); ?>">
            <i class="fa fa-chevron-up" aria-hidden="true"></i>
        </button>
    </nav>

    <jdoc:include type="scripts" />
    <jdoc:include type="modules" name="debug" style="none" />
</body>

</html>

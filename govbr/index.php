<?

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBRDS
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (C) 2025 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 * @since       __DEPLOY_VERSION__
 */

// No direct access.
defined('_JEXEC') or die('Restricted access!');

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Uri\Uri;

/** @var Joomla\CMS\Document\HtmlDocument $this */

$app   = Factory::getApplication();
$input = $app->getInput();
$wa    = $this->getWebAssetManager();

// Browsers support SVG favicons
$this->addHeadLink(HTMLHelper::_('image', 'favicon.svg', '', [], true, 1), 'icon', 'rel', ['type' => 'image/svg+xml']);
$this->addHeadLink(HTMLHelper::_('image', 'favicon.ico', '', [], true, 1), 'alternate icon', 'rel', ['type' => 'image/vnd.microsoft.icon']);
$this->addHeadLink(HTMLHelper::_('image', 'apple-icon-touch', '', [], true, 1), 'apple-icon-touch', 'rel', ['type' => 'image/png']);
$this->addHeadLink(HTMLHelper::_('image', 'safari-pinned-tab.svg', '', [], true, 1), 'mask-icon', 'rel', ['color' => '#00a300']);

// Detecting Active Variables
$option   = $input->getCmd('option', '');
$view     = $input->getCmd('view', '');
$layout   = $input->getCmd('layout', '');
$task     = $input->getCmd('task', '');
$itemid   = $input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');
$menu     = $app->getMenu()->getActive();
$pageclass = $menu !== null ? $menu->getParams()->get('pageclass_sfx', '') : '';

$this->setMetaData('viewport', 'width=device-width, initial-scale=1');


// $option
//     . ' view-' . $view
//     . ($layout ? ' layout-' . $layout : ' no-layout')
//     . ($task ? ' task-' . $task : ' no-task')
//     . ($itemid ? ' itemid-' . $itemid : '')

$wa->useStyle('template.govbr')
   ->useScript('template.govbr.scripts');

?>

<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,700,800,900&amp;display=swap" />

    <jdoc:include type="metas" />
    <jdoc:include type="styles" />
</head>

<body class="site<?php echo ($pageclass ? ' ' . $pageclass : ''); ?>">

    <main>
        <jdoc:include type="component" />
    </main>

    <footer>
        <p class="text-center">Template GovBR DS - Padrão Digital do Governo Brasileiro.</p>
    </footer>

    <jdoc:include type="scripts" />
    <jdoc:include type="modules" name="debug" style="none" />
</body>

</html>

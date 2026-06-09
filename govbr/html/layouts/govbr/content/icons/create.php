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
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

$attribs = [];
extract($displayData, EXTR_OVERWRITE);

/**
 * Layout variables
 * -----------------
 * @var  object    $category  The category information
 * @var  Registry  $params    The item parameters
 * @var  array     $attribs   Optional attributes for the link
 */

$uri = Uri::getInstance();

$url = 'index.php?option=com_content&task=article.add&return=' . base64_encode($uri) . '&a_id=0&catid=' . $category->id;

$text = '';

if ($params->get('show_icons')) {
    $text .= '<i class="fas fa-plus fa-fw" aria-hidden="true"></i>';
}

$text .= Text::_('COM_CONTENT_NEW_ARTICLE');

// Add the button classes to the attribs array
$attribs['class'] = 'br-button primary' . (key_exists('class', $attribs) ? ' ' . $attribs['class'] : '');

echo HTMLHelper::_('link', Route::_($url), $text, $attribs);

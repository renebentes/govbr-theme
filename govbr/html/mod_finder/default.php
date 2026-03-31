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

\defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;

// Load the smart search component language file.
$lang = $app->getLanguage();
$lang->load('com_finder', JPATH_SITE);

Text::script('MOD_FINDER_SEARCH_VALUE');

/** @var Joomla\CMS\WebAsset\WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->getRegistry()->addExtensionRegistryFile('com_finder');

$attributes          = [];
$attributes['class'] = trim($params->get('moduleclass_sfx'));

if ($tagId = $params->get('tag_id', '')) {
    $attributes['id'] = htmlspecialchars($tagId, ENT_QUOTES, 'UTF-8');
}

/*
 * This segment of code sets up the autocompleter.
 */
if ($params->get('show_autosuggest', 1)) {
    $wa->usePreset('awesomplete');
    $app->getDocument()
        ->addScriptOptions(
            'finder-search',
            ['url' => Route::_('index.php?option=com_finder&task=suggestions.suggest&format=json&tmpl=component', false)]
        );

    Text::script('COM_FINDER_SEARCH_FORM_LIST_LABEL');
    Text::script('JLIB_JS_AJAX_ERROR_OTHER');
    Text::script('JLIB_JS_AJAX_ERROR_PARSE');
}

$wa->useScript('com_finder.finder');
$finderHelper = $app->bootModule('mod_finder', 'site')
    ->getHelper('FinderHelper');

?>
<search>
    <form action="<?php echo Route::_($route); ?>" method="get"
        role="search">
        <div <?php echo ArrayHelper::toString($attributes); ?>>
            <div
                class="br-input input-highlight<?php echo $params->get('show_button', 0) ? ' has-icon' : ''; ?>">
                <label
                    for="searchword<?php echo $module->id; ?>"><?php echo $module->title; ?></label>
                <input type="text" name="q"
                    id="searchword<?php echo $module->id; ?>"
                    value="<?php echo htmlspecialchars($app->getInput()->get('q', '', 'string'), ENT_COMPAT, 'UTF-8'); ?>"
                    placeholder="<?php echo $params->get('alt_label', Text::_('JSEARCH_FILTER_SUBMIT')); ?>"
                    autocomplete="off" aria-autocomplete="list" />

                <?php if ($params->get('show_button', 0)) : ?>
                    <button class="br-button circle small" type="submit"
                        aria-label="<?php echo Text::_('JSEARCH_FILTER_SUBMIT'); ?>">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </button>
                <?php endif; ?>
            </div>

            <?php $show_advanced = $params->get('show_advanced', 0); ?>
            <?php if ($show_advanced == 2) : ?>
                <a href="<?php echo Route::_($route); ?>"
                    class="br-button circle ml-1" aria-label="<?php echo Text::_('COM_FINDER_ADVANCED_SEARCH'); ?>">
                    <i class="fas fa-arrow-up-right-from-square" aria-hidden="true"></i>
                </a>
            <?php elseif ($show_advanced == 1) : ?>
                <button class="br-button circle small ml-1" type="button" data-toggle="dropdown" data-target="finder-advanced"
                    aria-label="<?php echo Text::_('JOPEN') . ' ' . Text::_('COM_FINDER_ADVANCED_SEARCH'); ?>">
                    <i class="fas fa-sliders-h" aria-hidden="true"></i>
                </button>
                <div class="br-list" id="finder-advanced">
                    <div class="br-item">
                        <?php echo HTMLHelper::_('filter.select', $query, $params); ?>
                    </div>
                </div>

            <?php endif; ?>

            <?php echo $finderHelper->getHiddenFields($route); ?>

            <button class="br-button circle search-close ml-1" type="button"
                aria-label="<?php echo Text::_('JCLOSE'); ?>"
                data-dismiss="search">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
    </form>
</search>

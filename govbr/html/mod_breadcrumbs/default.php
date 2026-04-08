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
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\WebAsset\WebAssetManager;

/** @var WebAssetManager $wa */
$wa = $app->getDocument()->getWebAssetManager();
$wa->useScript('govbr.breadcrumb');

?>
<nav class="br-breadcrumb" aria-label="<?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>">

    <ol class="crumb-list" role="list">
        <li class="crumb home">
            <?php if ($params->get('showHere', 1)) : ?>
                <span aria-hidden="true" aria-label="<?php echo Text::_('MOD_BREADCRUMBS_HERE'); ?>"><?php echo Text::_('MOD_BREADCRUMBS_HERE'); ?>&#160;</span>
            <?php endif; ?>

            <?php if ($params->get('showHome', 1)) : ?>
                <?php $home = array_shift($list); ?>
                <a href="<?= Route::_($home->link); ?>" class="br-button circle"><i class="fas fa-home" aria-hidden="true" aria-label="<?= $home->name; ?>"></i></a>
            <?php else: ?>
                <i class="fas fa-home" aria-hidden="true"></i>
            <?php endif; ?>
        </li>

        <?php
        // Get rid of duplicated entries on trail including home page when using multilanguage
        for ($i = 0; $i < $count; $i++) {
            if ($i === 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link === $list[$i - 1]->link) {
                unset($list[$i]);
            }
        }

        // Find last and penultimate items in breadcrumbs list
        end($list);
        $last_item_key = key($list);
        prev($list);
        $penult_item_key = key($list);

        // Make a link if not the last item in the breadcrumbs
        $show_last = $params->get('showLast', 1);

        // Generate the trail
        foreach ($list as $key => $item) :
            if ($key !== $last_item_key) :
                if (!empty($item->link)) :
                    $breadcrumbItem = HTMLHelper::_('link', Route::_($item->link), $item->name);
                else :
                    $breadcrumbItem = $item->name;
                endif;
                echo '<li class="crumb"><i class="icon fas fa-chevron-right"></i>' . $breadcrumbItem . '</li>';
            elseif ($show_last) :
                // Render last item if required.
                $breadcrumbItem = '<span tabindex="0" aria-current="page">' . $item->name . '</span>';
                echo '<li class="crumb" data-active="active"><i class="icon fas fa-chevron-right"></i>' . $breadcrumbItem . '</li>';
            endif;
        endforeach; ?>
    </ol>
    <?php

    // Structured data as JSON
    $data = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        '@id'             => Uri::root() . '#/schema/BreadcrumbList/' . (int) $module->id,
        'itemListElement' => [],
    ];

    // Use an independent counter for positions. E.g. if Heading items in pathway.
    $itemsCounter = 0;

    // If showHome is disabled use the fallback $homeCrumb for startpage at first position.
    if (isset($homeCrumb)) {
        $data['itemListElement'][] = [
            '@type'    => 'ListItem',
            'position' => ++$itemsCounter,
            'item'     => [
                '@id'  => Route::_($homeCrumb->link, true, Route::TLS_IGNORE, true),
                'name' => $homeCrumb->name,
            ],
        ];
    }

    foreach ($list as $key => $item) {
        // Only add item to JSON if it has a valid link, otherwise skip it.
        if (!empty($item->link)) {
            $data['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => ++$itemsCounter,
                'item'     => [
                    '@id'  => Route::_($item->link, true, Route::TLS_IGNORE, true),
                    'name' => $item->name,
                ],
            ];
        } elseif ($key === $last_item_key) {
            // Add the last item (current page) to JSON, but without a link.
            // Google accepts items without a URL only as the current page.
            $data['itemListElement'][] = [
                '@type'    => 'ListItem',
                'position' => ++$itemsCounter,
                'item'     => [
                    'name' => $item->name,
                ],
            ];
        }
    }

    if ($itemsCounter) {

        $prettyPrint = JDEBUG ? JSON_PRETTY_PRINT : 0;
        $wa->addInline(
            'script',
            json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | $prettyPrint),
            ['name' => 'inline.breadcrumbs-schemaorg'],
            ['type' => 'application/ld+json']
        );
    }
    ?>
</nav>

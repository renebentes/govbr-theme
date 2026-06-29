<?php

/**
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */

// No direct access.
\defined('_JEXEC') or exit;

use Joomla\CMS\Language\Text;

$displayData += [
    'title'        => '',
    'order'        => '',
    'direction'    => 'asc',
    'selected'     => '',
    'task'         => null,
    'newDirection' => 'asc',
    'form'         => null,
];

extract($displayData, EXTR_OVERWRITE);

/**
 * Layout variables.
 *
 * @var array|string $title         the heading title or translated string key
 * @var string       $order         the order field name
 * @var string       $direction     the current ordering direction
 * @var string       $selected      the currently selected order field
 * @var null|string  $task          the ordering task
 * @var string       $newDirection  the direction to use when ordering changes
 * @var null|string  $form          the form element id
 */
$direction = strtolower($direction);
$icon      = ['arrow-up', 'arrow-down'];
$index     = (int) ($direction === 'desc');

if ($order != $selected) {
    $direction = $newDirection;
} else {
    $direction = $direction === 'desc' ? 'asc' : 'desc';
}

if ($form) {
    $form = ', document.getElementById(\'' . $form . '\')';
}

?>

<a href="#" onclick="Joomla.tableOrdering('<?php echo $order; ?>', '<?php echo $direction; ?>', '<?php echo $task; ?>'<?php echo $form; ?>); return false;"
    data-tooltip-text="<?php echo htmlspecialchars(Text::_('JGLOBAL_CLICK_TO_SORT_THIS_COLUMN')); ?>">
    <?php if (isset($title['0']) && $title['0'] === '<') : ?>
        <?php echo $title; ?>
    <?php else : ?>
        <?php echo Text::_($title); ?>
    <?php endif; ?>

    <?php if ($order == $selected) : ?>
        <i class="fas fa-<?php echo $icon[$index]; ?> fa-fw"></i>
    <?php endif; ?>
</a>

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

namespace ReneBentes\Templates\GovBR\Site\HTML\Helpers;

use Joomla\CMS\Language\Text;

\defined('_JEXEC') or die;


/**
 * Grid helper for the GovBR template.
 *
 * Provides HTML helper methods used by the template.
 *
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 * @since       __DEPLOY_VERSION__
 */
final class BrGrid
{
    /**
     * Build a sortable column heading link.
     *
     * @param   string|array  $title         The heading title or translated string key.
     * @param   string        $order         The order field name.
     * @param   string        $direction     The current ordering direction.
     * @param   string        $selected      The currently selected order field.
     * @param   string|null   $task          The ordering task.
     * @param   string        $newDirection  The direction to use when ordering changes.
     * @param   string        $tip           Tooltip text (unused legacy parameter).
     * @param   string|null   $form          The form element id.
     *
     * @return  string  The HTML for the sortable heading.
     * @since   __DEPLOY_VERSION__
     */
    public static function sort($title, $order, $direction = 'asc', $selected = '', $task = null, $newDirection = 'asc', $tip = '', $form = null)
    {
        $direction = strtolower($direction);
        $icon      = ['sort-up', 'sort-down'];
        $index     = (int) ($direction === 'desc');

        if ($order != $selected) {
            $direction = $newDirection;
        } else {
            $direction = $direction === 'desc' ? 'asc' : 'desc';
        }

        if ($form) {
            $form = ', document.getElementById(\'' . $form . '\')';
        }

        $html = '<a href="#" onclick="Joomla.tableOrdering(\'' . $order . '\',\'' . $direction . '\',\'' . $task . '\'' . $form . ');return false;"'
        . ' data-tooltip-text="' . htmlspecialchars(Text::_('JGLOBAL_CLICK_TO_SORT_THIS_COLUMN')) . '">';

        if (isset($title['0']) && $title['0'] === '<') {
            $html .= $title;
        } else {
            $html .= Text::_($title);
        }

        if ($order == $selected) {
            $html .= '<i class="fas fa-' . $icon[$index] . '"></i>';
        }

        $html .= '</a>';

        return $html;
    }
}

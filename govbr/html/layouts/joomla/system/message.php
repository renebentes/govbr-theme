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

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/* @var $displayData array */

$msgList   = $displayData['msgList'];
$document  = Factory::getDocument();
$msgOutput = '';
$alert     = [
    CMSApplication::MSG_EMERGENCY => 'danger',
    CMSApplication::MSG_ALERT     => 'danger',
    CMSApplication::MSG_CRITICAL  => 'danger',
    CMSApplication::MSG_ERROR     => 'danger',
    CMSApplication::MSG_WARNING   => 'warning',
    CMSApplication::MSG_NOTICE    => 'info',
    CMSApplication::MSG_INFO      => 'info',
    CMSApplication::MSG_DEBUG     => 'info',
    CMSApplication::MSG_MESSAGE   => 'success',
];

$document->getWebAssetManager()
    ->useScript('govbr.message');

if (\is_array($msgList) && !empty($msgList)) {

    foreach ($msgList as $type => $msgs) {
        if (!empty($msgs)) {
            $msgTitle = match ($alert[$type] ?? $type) {
                'danger'  => Text::_('ERROR'),
                'success' => Text::_('MESSAGE'),
                'warning' => Text::_('WARNING'),
                default   => Text::_('NOTICE'),
            };

            $msgIcon = match ($alert[$type] ?? $type) {
                'danger'  => 'fa-times-circle',
                'success' => 'fa-check-circle',
                'warning' => 'fa-exclamation-triangle',
                default   => 'fa-info-circle',
            };

            $msgOutput .= '<div class="br-message ' . ($alert[$type] ?? $type) . '">';
            $msgOutput .= '<div class="icon"><i class="fas ' . $msgIcon . '" aria-hidden="true"></i></div>';
            foreach ($msgs as $msg) :
                $msgOutput .= '<div class="content" aria-label="' . $msgTitle . '" role="alert">';
                $msgOutput .= '<span class="message-title">' . $msgTitle . '.</span> ';
                $msgOutput .= '<span class="message-body">' . $msg  . '</span>';
                $msgOutput .= '</div>';
            endforeach;

            $msgOutput .= '<div class="close">';
            $msgOutput .= '<button class="br-button circle small" type="button" aria-label="' . Text::_('JCLOSE') . '">';
            $msgOutput .= '<i class="fas fa-times" aria-hidden="true"></i>';
            $msgOutput .= '</button>';
            $msgOutput .= '</div>';
            $msgOutput .= '</div>';
        }
    }
}

echo $msgOutput;

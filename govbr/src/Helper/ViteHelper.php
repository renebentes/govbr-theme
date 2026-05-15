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

namespace ReneBentes\Templates\GovBR\Site\Helper;

\defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Document\HtmlDocument;

/**
 * Helper to detect and load the Vite development environment.
 *
 * This class checks if the Vite development server is available
 * and injects the necessary scripts into the Joomla document when in dev mode.
 *
 * @since  __DEPLOY_VERSION__
 */
class ViteHelper
{
    /**
     * Vite host used in development mode.
     *
     * @since  __DEPLOY_VERSION__
     */
    protected const string VITE_HOST = 'http://localhost:5173';

    /**
     * Checks if the Vite development server is active in development mode.
     *
     * @return bool True if the Vite server is available, false otherwise.
     *
     * @since  __DEPLOY_VERSION__
     */
    public static function isDev(): bool
    {
        $headers = @get_headers(self::VITE_HOST);
        return $headers !== false;
    }

    /**
     * Loads the Vite scripts into the HTML document.
     *
     * Inserts the Vite client scripts and the main template file
     * to enable hot reloading and local development.
     *
     * @return void
     *
     * @since  __DEPLOY_VERSION__
     */
    public static function load(): void
    {
        /** @var HtmlDocument $doc */;
        $doc = Factory::getApplication()->getDocument();
        $doc->addCustomTag(
            '<script type="module" src="' . self::VITE_HOST . '/@vite/client"></script>'
        );
        $doc->addCustomTag(
            '<script type="module" src="' . self::VITE_HOST . '/media/js/template.js"></script>'
        );
    }
}

<?php

/**
 * GovBR Theme based on Brazilian Design System available on https://gov.br/ds
 * for Joomla! Content Management System.
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */

declare(strict_types=1);

namespace ReneBentes\Plugin\Console\GovBR\Services;

use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\Database\DatabaseInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use ReneBentes\Plugin\Console\GovBR\Extension\Govbr;

// No direct access.
\defined('_JEXEC') or exit;

return new class implements ServiceProviderInterface {
    /**
     * Registers the service provider with a DI container.
     *
     * @param Container $container the DI container
     *
     * @since   __DEPLOY_VERSION__
     */
    public function register(Container $container): void
    {
        $container->set(
            PluginInterface::class,
            $container->lazy(
                Govbr::class,
                function (Container $container) {
                    $config     = (array) PluginHelper::getPlugin('console', 'govbr');
                    $plugin     = new Govbr($config);
                    $plugin->setApplication(Factory::getApplication());
                    $plugin->setDatabase($container->get(DatabaseInterface::class));

                    return $plugin;
                }
            )
        );
    }
};

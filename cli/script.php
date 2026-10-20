<?php

/**
 * GovBR Theme based on Brazilian Design System available on https://gov.br/ds
 * for Joomla! Content Management System.
 *
 * @package     Joomla.Plugin
 * @subpackage  Console.GovBR
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */

declare(strict_types=1);

namespace ReneBentes\Plugin\Console\GovBR\Services;

use Joomla\CMS\Application\AdministratorApplication;
use Joomla\CMS\Installer\InstallerAdapter;
use Joomla\CMS\Installer\InstallerScriptInterface;
use Joomla\CMS\Installer\InstallerScriptTrait;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Log\Log;
use Joomla\Database\DatabaseInterface;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;

/**
 * Service provider for the GovBR plugin installer script.
 *
 * This service provider enables the GovBR plugin after installation,
 * ensuring that it is immediately available for use in the Joomla! console.
 *
 * @since __DEPLOY_VERSION__
 */
return new class implements ServiceProviderInterface {
    public function register(Container $container): void
    {
        $container->set(
            InstallerScriptInterface::class,
            new class($container->get(AdministratorApplication::class), $container->get(DatabaseInterface::class)) implements InstallerScriptInterface {
                use InstallerScriptTrait {
                    InstallerScriptTrait::preflight as iScriptTraitPreflight;
                    InstallerScriptTrait::postflight as iScriptTraitPostflight;
                }

                /**
                 * @var AdministratorApplication
                 *
                 * @since  __DEPLOY_VERSION__
                 */
                private AdministratorApplication $app;

                /**
                 * @var DatabaseInterface
                 *
                 * @since  __DEPLOY_VERSION__
                 */
                private DatabaseInterface $db;

                public function __construct(AdministratorApplication $app, DatabaseInterface $db)
                {
                    $this->minimumPhp    = '8.3';
                    $this->minimumJoomla = '6.1.0';
                    $this->app           = $app;
                    $this->db            = $db;
                }

                public function install(InstallerAdapter $parent): bool
                {
                    return true;
                }

                public function update(InstallerAdapter $parent): bool
                {
                    return true;
                }

                public function uninstall(InstallerAdapter $parent): bool
                {
                    return true;
                }

                public function preflight(string $type, InstallerAdapter $parent): bool
                {
                    $this->iScriptTraitPreflight($type, $parent);

                    if(!$this->checkTemplateExists()) {
                        $this->app->enqueueMessage(Text::_('PLG_CONSOLE_GOVBR_INSTALLATION_TEMPLATE_NOT_FOUND'), 'error');
                        return false;
                    }

                    return true;
                }

                public function postflight(string $type, InstallerAdapter $parent): bool
                {
                    $this->iScriptTraitPostflight($type, $parent);

                    if (\in_array(
                        $parent->getRoute(),
                        ['discover_install', 'install', 'update'],
                        true
                    )) {
                        $this->enablePlugin();
                    }

                    return true;
                }

                private function checkTemplateExists(): bool
                {
                    $query = $this->db->getQuery(true)
                        ->select($this->db->quoteName('template'))
                        ->from($this->db->quoteName('#__template_styles'))
                        ->where($this->db->quoteName('template') . ' = ' . $this->db->quote('govbr'))
                    ;

                    return (bool) $this->db->setQuery($query)->loadResult();
                }

                /**
                 * Publishes the plugin after an installation. So, the plugin
                 * will be used by console immediately just after the installation.
                 *
                 * @since __DEPLOY_VERSION__
                 */
                private function enablePlugin(): void
                {
                    try {
                        $query = $this->db->getQuery(true)
                            ->update($this->db->quoteName('#__extensions'))
                            ->set($this->db->quoteName('enabled') . ' = 1')
                            ->where([
                                $this->db->quoteName('type') . ' = ' . $this->db->quote('plugin'),
                                $this->db->quoteName('folder') . ' = ' . $this->db->quote('console'),
                                $this->db->quoteName('element') . ' = ' . $this->db->quote('govbr'),
                                $this->db->quoteName('enabled') . ' = 0',
                            ])
                        ;

                        $this->db->setQuery($query)->execute();
                        $this->app->enqueueMessage(Text::_('PLG_CONSOLE_GOVBR_INSTALLATION_SUCCESS'), 'success');
                    } catch (\Throwable $e) {
                        Log::add($e->getMessage(), Log::ERROR, 'jerror');
                    }
                }
            }
        );
    }
};

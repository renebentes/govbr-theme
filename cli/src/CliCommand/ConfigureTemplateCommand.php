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

namespace ReneBentes\Plugin\Console\GovBR\CliCommand;

use Joomla\CMS\Cache\CacheControllerFactoryInterface;
use Joomla\CMS\Factory;
use Joomla\Console\Command\AbstractCommand;
use Joomla\Database\DatabaseAwareTrait;
use Joomla\Database\DatabaseInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

\defined('_JEXEC') or exit;

/**
 * Configures the GovBR site template style.
 *
 * @since __DEPLOY_VERSION__
 */
final class ConfigureTemplateCommand extends AbstractCommand
{
    use DatabaseAwareTrait;

    private const string TEMPLATE_NAME = 'govbr';

    private const int CONFIGURATION_FAILED = 1;

    private const int CONFIGURATION_SUCCESSFUL = 0;

    /**
     * The default command name.
     *
     * @var string
     *
     * @since  __DEPLOY_VERSION__
     */
    protected static $defaultName = 'govbr:template:configure';

    /**
     * @var SymfonyStyle
     *
     * @since  __DEPLOY_VERSION__
     */
    protected $ioStyle;

    /**
     * @var InputInterface
     *
     * @since __DEPLOY_VERSION_
     */
    private $cliInput;

    /**
     * @param array<string, string> $defaults
     */
    private array $defaults;

    public function __construct(DatabaseInterface $database, array $defaults = [])
    {
        parent::__construct();

        $this->setDatabase($database);
        $this->defaults = $defaults;
    }

    protected function configure(): void
    {
        $this->setDescription('Set the GovBR site template as default and apply missing parameters');
        $this->setHelp(
            'Configures the installed GovBR template style. Existing values are preserved unless overridden with --param.'
        );
        $this->addOption(
            'param',
            null,
            InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
            'Set a template parameter as NAME=VALUE; may be repeated'
        );
    }

    protected function doExecute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Configure GovBR template');

        $style = $this->findStyle();

        if ($style === null) {
            $io->error('The GovBR site template style was not found. Install it before running this command.');

            return self::CONFIGURATION_FAILED;
        }

        try {
            $paramsJson     = trim((string) $style->params);
            $decodedParams  = json_decode($paramsJson === '' ? '{}' : $paramsJson, false, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $exception) {
            $io->error('The GovBR template style contains invalid JSON parameters: ' . $exception->getMessage());

            return self::CONFIGURATION_FAILED;
        }

        if (!$decodedParams instanceof \stdClass) {
            $io->error('The GovBR template style parameters must be a JSON object.');

            return self::CONFIGURATION_FAILED;
        }

        $params          = get_object_vars($decodedParams);
        $appliedDefaults = [];

        foreach ($this->defaults as $name => $value) {
            if (!\array_key_exists($name, $params)) {
                $params[$name]     = $value;
                $appliedDefaults[] = $name;
            }
        }

        $overriddenParams = [];

        foreach ($input->getOption('param') as $parameter) {
            $separator = strpos($parameter, '=');

            if ($separator === false || $separator === 0) {
                $io->error('Invalid parameter. Use --param=NAME=VALUE.');

                return self::CONFIGURATION_FAILED;
            }

            $name               = substr($parameter, 0, $separator);
            $params[$name]      = substr($parameter, $separator + 1);
            $overriddenParams[] = $name;
        }

        try {
            $encodedParams = json_encode(
                (object) $params,
                JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
            );
        } catch (\JsonException $exception) {
            $io->error('Could not encode the GovBR template style parameters: ' . $exception->getMessage());

            return self::CONFIGURATION_FAILED;
        }

        $database = $this->getDatabase();
        $styleId  = (int) $style->id;
        $query    = $database->createQuery()
            ->update($database->quoteName('#__template_styles'))
            ->set(
                $database->quoteName('home')
                    . ' = CASE WHEN '
                    . $database->quoteName('id')
                    . ' = '
                    . $styleId
                    . ' THEN '
                    . $database->quote('1')
                    . ' ELSE '
                    . $database->quote('0')
                    . ' END'
            )
            ->set(
                $database->quoteName('params')
                    . ' = CASE WHEN '
                    . $database->quoteName('id')
                    . ' = '
                    . $styleId
                    . ' THEN '
                    . $database->quote($encodedParams)
                    . ' ELSE '
                    . $database->quoteName('params')
                    . ' END'
            )
            ->where($database->quoteName('client_id') . ' = 0')
        ;

        $database->setQuery($query)->execute();
        Factory::getContainer()
            ->get(CacheControllerFactoryInterface::class)
            ->createCacheController('output', ['defaultgroup' => '_system'])
            ->clean()
        ;

        $io->success(\sprintf('GovBR template style %d is now the default site style.', $styleId));

        if ($appliedDefaults !== []) {
            $io->text('Applied missing defaults: ' . implode(', ', $appliedDefaults));
        } else {
            $io->text('No missing defaults needed to be applied.');
        }

        if ($overriddenParams !== []) {
            $io->text('Applied parameter overrides: ' . implode(', ', $overriddenParams));
        }

        return self::CONFIGURATION_SUCCESSFUL;
    }

    private function findStyle(): ?object
    {
        $database = $this->getDatabase();
        $query    = $database->createQuery()
            ->select($database->quoteName(['id', 'home', 'params']))
            ->from($database->quoteName('#__template_styles'))
            ->where($database->quoteName('template') . ' = ' . $database->quote(self::TEMPLATE_NAME))
            ->where($database->quoteName('client_id') . ' = 0')
            ->order($database->quoteName('home') . ' DESC, ' . $database->quoteName('id') . ' ASC')
        ;

        return $database->setQuery($query)->loadObject() ?: null;
    }
}

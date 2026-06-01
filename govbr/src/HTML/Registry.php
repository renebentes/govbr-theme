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

namespace ReneBentes\Templates\GovBR\Site\HTML;

use Joomla\CMS\HTML\HTMLHelper;
use ReneBentes\Templates\GovBR\Site\HTML\Helpers\BrGrid;

\defined('_JEXEC') or die;

/**
 * Registry helper for the GovBR template.
 *
 * Registers HTML helpers for the template.
 *
 * @package     Joomla.Site
 * @subpackage  Templates.GovBR
 * @since       __DEPLOY_VERSION__
 */
final class Registry
{
    /**
     * The decorated helper instance.
     *
     * @var   object
     * @since __DEPLOY_VERSION__
     */
    private object $decoratedHelper;

    /**
     * Constructor.
     *
     * @param object $decoratedHelper  The helper being decorated/proxied.
     *
     * @since __DEPLOY_VERSION__
     */
    public function __construct(object $decoratedHelper)
    {
        $this->decoratedHelper = $decoratedHelper;
    }

    /**
     * Register custom template HTML helpers.
     *
     * @return void
     * @since  __DEPLOY_VERSION__
     */
    public static function registerAll(): void
    {
        $registry = HTMLHelper::getServiceRegistry();
        $registry->register('brgrid', BrGrid::class);
    }

    /**
     * Proxy calls to the decorated helper.
     *
     * @param  string  $name       The method name being called.
     * @param  array   $arguments  The arguments to pass to the method.
     *
     * @return mixed
     * @throws \BadMethodCallException  If the called method does not exist.
     * @since  __DEPLOY_VERSION__
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (!method_exists($this->decoratedHelper, $name)) {
            throw new \BadMethodCallException("Method {$name} does not exist in {get_class($this->decoratedHelper)}.");
        }

        return $this->decoratedHelper->{$name}(...$arguments);
    }
}

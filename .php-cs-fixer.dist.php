<?php

/**
 * GovBR Theme based on Brazilian Design System available on https://gov.br/ds
 * for Joomla! Content Management System.
 *
 * This is the configuration file for php-cs-fixer
 *
 * @link https://github.com/FriendsOfPHP/PHP-CS-Fixer
 * @link https://mlocati.github.io/php-cs-fixer-configurator/#version:3.0
 *
 * If you would like to run the automated clean up, then open a command line and type one of the commands below.
 *
 * You can run php-cs-fixer from vendor/bin directory or using composer scripts.
 *
 * To run a quick dry run to see the files that would be modified:
 *
 *        ./vendor/bin/php-cs-fixer check
 * or
 *        composer cs:check
 *
 * To run a full check, with automated fixing of each problem :
 *
 *        ./vendor/bin/php-cs-fixer fix
 * or
 *        composer cs:fix
 *
 * You can run the clean up on a single file if you need to, this is faster
 *
 *        composer cs:check index.php
 *        composer cs:fix index.php
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$headerContent = [
    <<<CONTENT
        GovBR Theme based on Brazilian Design System available on https://gov.br/ds
        for Joomla! Content Management System.
        CONTENT,
    <<<CONTENT
        @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
        @license     GNU General Public License version 2 or later; see LICENSE
        CONTENT,
    <<<CONTENT
        @since       __DEPLOY_VERSION__
        CONTENT];

$headerValidator = [
    '/',
    preg_quote($headerContent[0], '/'),
    '(?P<EXTRA>.*?)',
    '\s*',
    preg_replace(
        '/@copyright\s*Copyright \\\\\(c\\\\\) \d{4}/',
        '@copyright\s*Copyright \(c\) \d{4}',
        preg_quote($headerContent[1])
    ),
    '\s*@since\s*(?:__DEPLOY_VERSION__|\d+\.\d+(?:\.\d+)?).*',
    '/s'];

// Add all the source folders
$finder = Finder::create()
    ->in([
        __DIR__,
    ])
    ->exclude([
        'node_modules',
        'vendor',
    ])
;

$config = new Config();
$config
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRiskyAllowed(true)
    ->setHideProgress(false)
    ->setUsingCache(false)
    ->setRules([
        // Basic ruleset is Auto
        '@auto'                           => true,
        // Align elements in multiline array and variable declarations on new lines below each other
        'binary_operator_spaces'          => ['operators' => ['=>' => 'align_single_space_minimal_by_scope', '=' => 'align', '??=' => 'align']],
        // Using isset($var) && multiple times should be done in one call.
        'combine_consecutive_issets'      => true,
        // Calling unset on multiple items should be done in one call
        'combine_consecutive_unsets'      => true,
        // Forces <?php echo
        'echo_tag_syntax'                 => ['format' => 'long'],
        // Classes from the global namespace should not be imported
        'global_namespace_import'         => ['import_classes' => false, 'import_constants' => false, 'import_functions' => false],
        // Configuring default header
        'header_comment'                  => [
            'comment_type' => 'PHPDoc',
            'header'       => implode(PHP_EOL . PHP_EOL, $headerContent),
            'location'     => 'after_open',
            'validator'    => implode('', $headerValidator),
        ],
        // Native function invocation
        'native_function_invocation'      => ['include' => ['@compiler_optimized']],
        // The "No break" comment in switch statements
        'no_break_comment'                => ['comment_text' => 'No break'],
        // List of values separated by a comma is contained on a single line should not have a trailing comma like [$foo, $bar,] = ...
        'no_trailing_comma_in_singleline' => true,
        // Removes unneeded parentheses around control statements
        'no_unneeded_control_parentheses' => true,
        // Remove unused imports
        'no_unused_imports'               => true,
        // There should not be useless else cases
        'no_useless_else'                 => true,
        // There must be no sprintf calls with only the first argument
        'no_useless_sprintf'              => true,
        // Alpha order imports
        'ordered_imports'                 => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
    ])
    ->setFinder($finder)
;

return $config;

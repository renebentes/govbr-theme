<?php

/**
 * GovBR Theme based on Brazilian Design System available on https://gov.br/ds
 * for Joomla! Content Management System.
 *
 * This is the configuration file for php-cs-fixer
 *
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer
 * @see https://mlocati.github.io/php-cs-fixer-configurator/#version:3.0
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
 * @package     Joomla.Templates
 *
 * @author      Rene Bentes Pinto <renebentes@yahoo.com.br>
 * @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 *
 * @since       __DEPLOY_VERSION__
 */

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

$headerContent = [
    <<<'CONTENT'
        GovBR Theme based on Brazilian Design System available on https://gov.br/ds
        for Joomla! Content Management System.
        CONTENT,
    <<<'CONTENT'
        @copyright   Copyright (c) 2026 Rene Bentes Pinto. All rights reserved.
        @license     GNU General Public License version 2 or later; see LICENSE
        CONTENT,
    <<<'CONTENT'
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
        // Basic ruleset is Auto and PhpCsFixer
        '@auto'                      => true,
        '@auto:risky'                => true,
        '@PhpCsFixer'                => true,
        // Align elements in multiline array and variable declarations on new lines below each other
        'binary_operator_spaces'     => ['operators' => ['=>' => 'align_single_space_minimal_by_scope', '=' => 'align', '??=' => 'align']],
        // Add one space on concatenation operator
        'concat_space'               => ['spacing' => 'one'],
        // Configuring default header
        'header_comment'             => [
            'comment_type' => 'PHPDoc',
            'header'       => implode(PHP_EOL . PHP_EOL, $headerContent),
            'location'     => 'after_open',
            'validator'    => implode('', $headerValidator),
        ],
        // Native function invocation
        'native_function_invocation' => ['include' => ['@compiler_optimized']],
        // Using endif, endforeach on mixed HTML/PHP files
        'no_alternative_syntax'      => ['fix_non_monolithic_code' => false],
        // The "No break" comment in switch statements
        'no_break_comment'           => ['comment_text' => 'No break'],
        // There must be no sprintf calls with only the first argument
        'no_useless_sprintf'         => true,
        // Allow @package and @subpackage tags
        'phpdoc_no_package'          => false,
        // Ignoring @var tags
        'phpdoc_to_comment'          => ['allow_before_return_statement' => false, 'ignored_tags' => ['var']],
        // Disable Yoda style in conditions like null == a
        'yoda_style'                 => false,
    ])
    ->setFinder($finder)
;

return $config;

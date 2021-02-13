<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$rules = [
    '@PhpCsFixer' => true,
    '@PHP80Migration' => true,
    'no_superfluous_phpdoc_tags' => false,
    'phpdoc_add_missing_param_annotation' => [
        'only_untyped' => false,
    ],
    'nullable_type_declaration_for_default_null_value' => [
        'use_nullable_type_declaration' => true,
    ],
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'concat_space' => [
        'spacing' => 'one',
    ],
];

$project_path = getcwd();
$finder = Finder::create()
    ->in([
        $project_path . '/app',
        $project_path . '/config',
        $project_path . '/database',
        $project_path . '/resources',
        $project_path . '/routes',
        $project_path . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config())
    ->setFinder($finder)
    ->setRules($rules)
    ->setRiskyAllowed(false)
    ->setUsingCache(false);

<?php

$header = <<<'EOF'
This file is part of forecast.it.fill project.
(c) Patrick Jaja <patrickjaja@web.de>
This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/src',__DIR__.'/tests']);

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules(
        [ // https://mlocati.github.io/php-cs-fixer-configurator/#version:3.1|fixer:php_unit_internal_class
            '@PHP71Migration' => true,
            '@PhpCsFixer' => true,
            'general_phpdoc_annotation_remove' => ['annotations' => ['expectedDeprecation']],
            'header_comment' => ['header' => $header],
            '@PHP80Migration' => true,
            'heredoc_indentation' => false,
            '@PSR2' => true,
            'array_syntax' => ['syntax' => 'short'],
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'no_unused_imports' => true,
            'not_operator_with_successor_space' => true,
            'trailing_comma_in_multiline' => true,
            'phpdoc_scalar' => true,
            'unary_operator_spaces' => true,
            'binary_operator_spaces' => true,
            'blank_line_before_statement' => [
                'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
            ],
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_var_without_name' => true,
            'class_attributes_separation' => [
                'elements' => [
                    'method' => 'one',
                ],
            ],
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
                'keep_multiple_spaces_after_comma' => true,
            ],
            'single_trait_insert_per_statement' => true,
        ]
    )
    ->setFinder($finder);

return $config;

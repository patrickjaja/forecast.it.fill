<?php

$header = <<<'EOF'
This file is part of forecast.it.fill project.
(c) Patrick Jaja <patrickjajaa@gmail.com>
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
            '@Symfony' => true,
            '@Symfony:risky' => true,
            'align_multiline_comment' => true,
            'array_syntax' => ['syntax' => 'short'],
            'blank_line_before_statement' => true,
            'combine_consecutive_issets' => true,
            'combine_consecutive_unsets' => true,
            'declare_strict_types' => true,
            // one should use PHPUnit methods to set up expected exception instead of annotations
            'general_phpdoc_annotation_remove' => ['annotations' => ['expectedException', 'expectedExceptionMessage', 'expectedExceptionMessageRegExp']],
            'header_comment' => ['header' => $header],
            'heredoc_to_nowdoc' => true,
            'list_syntax' => ['syntax' => 'long'],
            'method_chaining_indentation' => false,
            'native_function_invocation' => false,
            'native_constant_invocation' => false,
            'no_extra_blank_lines' => ['tokens' => ['break', 'continue', 'extra', 'return', 'throw', 'use', 'parenthesis_brace_block', 'square_brace_block', 'curly_brace_block']],
            'no_null_property_initialization' => true,
            'echo_tag_syntax' => ['format' => 'long'],
            'no_superfluous_phpdoc_tags' => ['allow_mixed' => false],
            'no_unneeded_curly_braces' => true,
            'no_unneeded_final_method' => true,
            'no_unreachable_default_argument_value' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'ordered_class_elements' => [
                'order' => [
                    'use_trait',
                    'constant_public',
                    'constant_protected',
                    'constant_private',
                    'property_public',
                    'property_protected',
                    'property_private',
                    'construct',
                    'destruct',
                    'magic',
                    'phpunit',
                    'method_public_static',
                    'method_protected_static',
                    'method_private_static',
                    'method_public',
                    'method_public_abstract',
                    'method_protected',
                    'method_protected_abstract',
                    'method_private',
                ],
                'sort_algorithm' => 'alpha'
            ],
            'php_unit_construct' => true,
            'php_unit_method_casing' => ['case' => 'camel_case'],
            'php_unit_test_class_requires_covers' => true,
            'php_unit_dedicate_assert' => true,
            'phpdoc_order' => true,
            'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
            'semicolon_after_instruction' => true,
            'single_line_comment_style' => true,
            'yoda_style' => true,
            '@PHP71Migration' => true,
            '@PhpCsFixer' => true,
            '@PHP80Migration' => true,
            'heredoc_indentation' => false,
            '@PSR2' => true,
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'not_operator_with_successor_space' => true,
            'trailing_comma_in_multiline' => true,
            'phpdoc_scalar' => true,
            'unary_operator_spaces' => true,
            'binary_operator_spaces' => true,
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_var_without_name' => true,
            'class_attributes_separation' => [
                'elements' => [
                    'method' => 'one',
                ],
            ],
            // disabled for guzzle promise usage passed as &$wrappedReference to be resolved later
            'return_assignment'=>false,
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
                'keep_multiple_spaces_after_comma' => true,
            ],
            'single_trait_insert_per_statement' => true,
        ]
    )
    ->setFinder($finder);

return $config;

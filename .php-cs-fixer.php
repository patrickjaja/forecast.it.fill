<?php

$header = 'This file is part of forecast.it.fill project. (c) Patrick Jaja <patrickjaja@web.de> This source file is subject to the MIT license that is bundled with this source code in the file LICENSE.';

$finder = PhpCsFixer\Finder::create()
    ->in([__DIR__.'/src',__DIR__.'/tests']);

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@PHP71Migration' => true,
            '@PHP71Migration:risky' => true,
            '@PHPUnit75Migration:risky' => true,
            '@PhpCsFixer' => true,
            '@PhpCsFixer:risky' => true,
            'general_phpdoc_annotation_remove' => ['annotations' => ['expectedDeprecation']],
            'header_comment' => ['header' => $header],
            '@PHP80Migration' => true,
            '@PHP80Migration:risky' => true,
            'heredoc_indentation' => false,
        ]
    )
    ->setFinder($finder);

return $config;

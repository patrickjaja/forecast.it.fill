<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Architecture\Analyzer;

use Arkitect\Analyzer\PatternString as ArkitectPatternString;

class PatternString extends ArkitectPatternString
{
    private string $value;

    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->value = $value;
    }

    public function matches(string $pattern): bool
    {
        if (! parent::matches($pattern)) {
            return 1 === preg_match($pattern, $this->value);
        }
    }
}

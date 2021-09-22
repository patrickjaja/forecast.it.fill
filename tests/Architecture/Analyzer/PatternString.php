<?php
declare(strict_types=1);

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
        if (!parent::matches($pattern))
        {
            return preg_match($pattern, $this->value) === 1;
        }
    }
}

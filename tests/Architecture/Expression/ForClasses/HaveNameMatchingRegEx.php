<?php

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Architecture\Expression\ForClasses;

use Architecture\Analyzer\FullyQualifiedClassName;
use Arkitect\Analyzer\ClassDescription;
use Arkitect\Expression\Description;
use Arkitect\Expression\Expression;
use Arkitect\Expression\PositiveDescription;
use Arkitect\Rules\Violation;
use Arkitect\Rules\Violations;

class HaveNameMatchingRegEx implements Expression
{
    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function describe(ClassDescription $theClass): Description
    {
        return new PositiveDescription("should [have|not have] a name that matches {$this->name}");
    }

    public function evaluate(ClassDescription $theClass, Violations $violations): void
    {
        $fqcn = FullyQualifiedClassName::fromString($theClass->getFQCN());
        if (!$fqcn->classMatches($this->name)) {
            $violation = Violation::create(
                $theClass->getFQCN(),
                $this->describe($theClass)->toString()
            );
            $violations->add($violation);
        }
    }
}

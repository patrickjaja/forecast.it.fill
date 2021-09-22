<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjaja@web.de>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Architecture;

use Arkitect\ClassSet as ArkitectClassSet;
use Arkitect\Glob;
use Symfony\Component\Finder\Finder;

class FlatClassSet extends ArkitectClassSet
{
    private string $directory;

    private array $exclude;

    private function __construct(string $directory)
    {
        $this->directory = $directory;
        $this->exclude = [];
    }

    public function excludePath(string $pattern): self
    {
        $this->exclude[] = Glob::toRegex($pattern);

        return $this;
    }

    public static function fromDir(string $directory): self
    {
        return new self($directory);
    }

    public function getDir(): string
    {
        return $this->directory;
    }

    public function getIterator()
    {
        $finder = (new Finder())
            ->files()
            ->in($this->directory)
            ->name('*.php')
            ->sortByName()
            ->depth('< 2')
            ->followLinks()
            ->ignoreUnreadableDirs(true)
            ->ignoreVCS(true)
        ;

        if ($this->exclude) {
            $finder->notPath($this->exclude);
        }

        return $finder;
    }
}

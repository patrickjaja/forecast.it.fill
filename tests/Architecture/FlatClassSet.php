<?php
declare(strict_types=1);

namespace Architecture;

use Arkitect\ClassSet as ArkitectClassSet;

class FlatClassSet extends ArkitectClassSet
{
    public function getIterator()
    {
        return parent::getIterator()->depth('< 2');
    }
}

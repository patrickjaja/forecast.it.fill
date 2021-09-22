<?php
declare(strict_types=1);

use Architecture\FlatClassSet;
use Architecture\Expression\ForClasses\HaveNameMatchingRegEx;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;

return static function (Config $config): void {
    $moduleRootClassset = FlatClassSet::fromDir(__DIR__.'/src/ForecastAutomation')
        ->excludePath('Kernel');

    $moduleRootRule = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('ForecastAutomation'))
        ->should(new HaveNameMatchingRegEx('/.*(DependencyProvider|Facade|Factory|Config)$/'))
        ->because('we want that application modules only depend on given patterns to ensure correct intermodality.');

    $config
        ->add($moduleRootClassset, ...[$moduleRootRule]);
};

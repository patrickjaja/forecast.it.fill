<?php

namespace ForecastAutomation\Kernel;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle;
use Symfony\Bundle\DebugBundle\DebugBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\MonologBundle\MonologBundle;
use Symfony\Bundle\SecurityBundle\SecurityBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Bundle\WebProfilerBundle\WebProfilerBundle;
use Symfony\Component\HttpKernel\Kernel as SymfonyKernel;
use Twig\Extra\TwigExtraBundle\TwigExtraBundle;

class Kernel extends SymfonyKernel
{
    use MicroKernelTrait;

    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new SensioFrameworkExtraBundle(),
            new TwigBundle(),
            new WebProfilerBundle(),
            new MonologBundle(),
            new DoctrineBundle(),
            new DoctrineMigrationsBundle(),
            new DebugBundle(),
            new SecurityBundle(),
            new TwigExtraBundle(),
        ];
    }
}

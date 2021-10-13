<?php

use ForecastAutomation\Activity\Shared\Plugin\ActivityPluginCollection;
use ForecastAutomation\ForecastClient\Shared\Plugin\ForecastClientQueuePluginPlugin;
use ForecastAutomation\GitlabClient\Shared\Plugin\GitlabActivityPlugin;
use ForecastAutomation\JiraClient\Shared\Plugin\JiraActivityPlugin;
use ForecastAutomation\MattermostClient\MattermostClientFacade;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\HasMessageChannelFilter;
use ForecastAutomation\MattermostClient\Shared\Plugin\Filter\IsDirectChannelFilter;
use ForecastAutomation\MattermostClient\Shared\Plugin\MattermostActivityPlugin;
use ForecastAutomation\QueueClient\Shared\Plugin\QueuePluginCollection;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return function(ContainerConfigurator $configurator) {
    $namespace = $_ENV['APPLICATION_NAMESPACE'];

    // default configuration for services in *this* file
    $services = $configurator->services()
        ->defaults()
        ->public()
        ->autowire()      // Automatically injects dependencies in your services.
        ->autoconfigure() // Automatically registers your services as commands, event subscribers, etc.
    ;

    // makes classes in src/ available to be used as services
    // this creates a service per class whose id is the fully-qualified class name
    $services->load($namespace.'\\', '../src/ForecastAutomation')
        ->exclude('../src/{DependencyInjection,Entity,Tests,Kernel.php}')
        ->exclude(
            [
                '../src/'.$namespace.'/**/Business',
                '../src/'.$namespace.'/**/Shared/Dto/*',
                '../src/'.$namespace.'/**/Kernel',
            ]
        );

    $services->set(Symfony\Component\Console\Application::class);

    // QueueBundle Config
    $services->set(QueuePluginCollection::class)
        ->arg('$plugins', [service(ForecastClientQueuePluginPlugin::class)]);

    // ActivityBundle Config
    $services->set(MattermostActivityPlugin::class)
        ->arg(
            '$channelFilterCollection',
            [service(HasMessageChannelFilter::class), service(IsDirectChannelFilter::class)]
        )
        ->arg('$mattermostClientFacade', service(MattermostClientFacade::class));

    $services->set(ActivityPluginCollection::class)
        ->arg('$plugins',
            [
                service(JiraActivityPlugin::class),
                service(MattermostActivityPlugin::class),
                service(GitlabActivityPlugin::class),
            ]
        );

    // configure doctrine
    $configurator->extension(
        'doctrine',
        [
            'dbal' => ['url' => '%env(resolve:DATABASE_URL)%'],
            'orm' => [
                'auto_generate_proxy_classes' => true,
                'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                'auto_mapping' => true,
                'mappings' => [
                    $namespace => [
                        'dir' => '%kernel.project_dir%/src/'.$namespace,
                        'prefix' => $namespace,
                    ],
                ],
            ],
        ]
    );
};

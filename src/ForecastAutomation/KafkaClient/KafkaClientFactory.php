<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\KafkaClient;

use ForecastAutomation\KafkaClient\Business\Consumer;
use ForecastAutomation\KafkaClient\Business\Producer;
use ForecastAutomation\Kernel\AbstractFactory;
use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\Serializer\SerializerFacade;
use RdKafka\Conf;

class KafkaClientFactory extends AbstractFactory
{
    public function createConsumer(): Consumer
    {
        return new Consumer($this->createConfig(), $this->getSerializerFacade(), $this->getLogFacade());
    }

    public function createProducer(): Producer
    {
        return new Producer($this->createConfig(), $this->getSerializerFacade(), $this->getLogFacade());
    }

    public function createConfig(): Conf
    {
        $conf = new Conf();
        $conf->set('metadata.broker.list', $_ENV['KAFKA_BROKER_LIST']);

        return $conf;
    }

    public function getSerializerFacade(): SerializerFacade
    {
        return $this->getProvidedDependency(KafkaClientDependencyProvider::SERIALIZER_FACADE);
    }

    public function getLogFacade(): LogFacade
    {
        return $this->getProvidedDependency(KafkaClientDependencyProvider::LOG_FACADE);
    }
}

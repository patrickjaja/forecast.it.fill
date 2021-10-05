<?php

declare(strict_types=1);

/*
 * This file is part of forecast.it.fill project.
 * (c) Patrick Jaja <patrickjajaa@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace ForecastAutomation\KafkaClient\Business;

use ForecastAutomation\Log\LogFacade;
use ForecastAutomation\QueueClient\Shared\Dto\MessageCollectionDto;
use ForecastAutomation\QueueClient\Shared\Dto\MessageDto;
use ForecastAutomation\Serializer\SerializerFacade;
use RdKafka\Conf;
use RdKafka\TopicConf;

class Consumer
{
    public function __construct(private Conf $conf, private SerializerFacade $serializerFacade, private LogFacade $logFacade)
    {
    }

    public function consume(string $queueName): MessageCollectionDto
    {
        $this->conf->set('group.id', 'myConsumerGroup');

        $rk = new \RdKafka\Consumer($this->conf);
//        $rk->setLogLevel(LOG_DEBUG);
        $rk->addBrokers('127.0.0.1:9092');

        $topicConf = new \RdKafka\TopicConf();
        $topicConf->set('offset.store.method', 'broker');
        $topicConf->set('auto.commit.interval.ms', '100');
        $topicConf->set('auto.offset.reset', 'earliest');

        $topic = $rk->newTopic($queueName, $topicConf);

        $partition = 0;
        $topic->consumeStart($partition, RD_KAFKA_OFFSET_STORED);

        $messages = [];

        $count = 0;
        while (true) {
            $message = $topic->consume($partition, 1000);
            if (null === $message && ! isset($message->err)) {
                break;
            }
            if ($message) {
                $messageDto = (new MessageDto(...$this->serializerFacade->deserialize($message->payload)));
                $messageDto->setAdapterMetaResponse(['err' => $message->err, 'topic_name' => $message->topic_name, 'timestamp' => $message->timestamp, 'partition' => $message->partition, 'len' => $message->len, 'key' => $message->key, 'offset' => $message->offset, 'headers' => $message->headers]);
                $messages[] = $messageDto;
//                call_user_func($handler, $messageDto);
                ++$count;
            }
        }

        $topic->consumeStop($partition);

        echo 'Finished. Consumed '.$count;

//        $this->conf = new Conf();
//
//        // Set the group id. This is required when storing offsets on the broker
//        $this->conf->set('group.id', 'myConsumerGroup');
//
//        $rk = new \RdKafka\Consumer($this->conf);
//        $rk->addBrokers("127.0.0.1:9092");
//
//        $topicConf = new TopicConf();
//        $topicConf->set('auto.commit.interval.ms', 100);
//
//        // Set where to start consuming messages when there is no initial offset in
//        // offset store or the desired offset is out of range.
//        // 'smallest': start from the beginning
//        $topicConf->set('auto.offset.reset', 'smallest');
//
//        $topic = $rk->newTopic($queueName, $topicConf);
//
//        // Start consuming partition 0
//        $topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
//
//        $messages = [];
//
//        $totalPassedSeconds = 0;
//        $maxThreshold = 10;
//        while($totalPassedSeconds < $maxThreshold) {
//            $message = $topic->consume(0, 120*1000);
//            switch ($message->err) {
//                case RD_KAFKA_RESP_ERR_NO_ERROR:
//                    $messageDto = new MessageDto(...(array)$this->serializerFacade->deserialize($message->payload));
//                    $messages[]=$messageDto;
        ////                    call_user_func($handler, $messageDto);
//                    break;
//                case RD_KAFKA_RESP_ERR__PARTITION_EOF:
//                    echo "No more messages; will wait for more\n";
//                    break;
//                case RD_KAFKA_RESP_ERR__TIMED_OUT:
//                    echo "Timed out\n";
//                    break;
//                default:
//                    throw new \Exception($message->errstr(), $message->err);
//                    break;
//            }
//            $totalPassedSeconds++;
//        }
        return new MessageCollectionDto(...$messages);
    }
}

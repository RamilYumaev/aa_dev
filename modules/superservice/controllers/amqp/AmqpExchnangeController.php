<?php
namespace modules\superservice\controllers\amqp;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\console\Controller;

class AmqpExchnangeController extends Controller
{
    /** @var resource|null */
    private $lockFile;
    private $connection = null;
    private $channel = null;

    /**
     * @throws \ErrorException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     * @throws Exception
     */
    public function actionRun(): void
    {

        $this->connection = new AMQPStreamConnection(
            \Yii::$app->params['rabbitmqHost'],
            \Yii::$app->params['rabbitmqPort'],
            \Yii::$app->params['rabbitmqUser'],
            \Yii::$app->params['rabbitmqPassword']
        );
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare(
            'logs',
            'fanout', # type
            false,    # passive
            false,    # durable
            false     # auto_delete
        );

        $data = "Event created!";
        $msg = new \PhpAmqpLib\Message\AMQPMessage($data);
        $this->channel->basic_publish($msg, 'logs');
        echo "Published: $data" . PHP_EOL;

    }

    public function actionConsume(): void
    {
        $this->connection = new AMQPStreamConnection(
            \Yii::$app->params['rabbitmqHost'],
            \Yii::$app->params['rabbitmqPort'],
            \Yii::$app->params['rabbitmqUser'],
            \Yii::$app->params['rabbitmqPassword']
        );
        $this->channel = $this->connection->channel();
        $this->channel->exchange_declare(
            'logs',
            'fanout', # type
            false,    # passive
            false,    # durable
            false     # auto_delete
        );

        list($queue_name, ,) = $this->channel->queue_declare(
            "",    # queue
            false, # passive
            false, # durable
            true,  # exclusive
            false  # auto delete
        );

        $this->channel->queue_bind($queue_name, 'logs');
        print 'Waiting for logs. To exit press CTRL+C' . PHP_EOL;

        $callback = function($msg){
            print "Read: " . $msg->body . PHP_EOL;
        };

        $this->channel->basic_consume(
            $queue_name,
            '',
            false,
            true,
            false,
            false,
            $callback
        );

        while (count($this->channel->callbacks))
        {
            $this->channel->wait();
        }
    }

    public function __destruct()
    {
        null === $this->channel or $this->channel->close();
        null === $this->connection or $this->connection->close();

        if ($this->lockFile) {
            flock($this->lockFile, LOCK_UN);
            fclose($this->lockFile);
        }
    }
}
<?php
namespace modules\superservice\controllers\amqp;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\console\Controller;

class AmqpController extends Controller
{
    const LOCK_FILE = '.amqp_consumer_lock';

    public $interactive = false;

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
        $this->lockFile = fopen(self::LOCK_FILE, 'wb');
        if (!$this->lockFile) {
            throw new Exception('Cannot create lock file.');
        }
        if (!flock($this->lockFile, LOCK_EX | LOCK_NB)) {
            return;
        }

        $this->connection = new AMQPStreamConnection(
            \Yii::$app->params['rabbitmqHost'],
            \Yii::$app->params['rabbitmqPort'],
            \Yii::$app->params['rabbitmqUser'],
            \Yii::$app->params['rabbitmqPassword']
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('hello', false, false, false, false);

        $array = ['data'=> ['home'=> '4', 'users' => ['Mike', 'Mark']]];
        $msg = new AMQPMessage(json_encode($array));
        $this->channel->basic_publish($msg, '', 'hello');
        echo " [x] Sent 'Hello World!'\n";

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
        $this->channel->queue_declare('hello', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        $this->channel = $this->connection->channel();
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };

        $this->channel->basic_consume('hello', '', false, true, false, false, $callback);

        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
        $this->channel->close();
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
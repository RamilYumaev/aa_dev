<?php
namespace modules\superservice\controllers\amqp;

use modules\superservice\handlers\ResponseHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\base\Exception;
use yii\console\Controller;

class ConsumeController extends Controller
{
    const LOCK_FILE = '.amqp_consumer_lock';

    public $interactive = false;

    /** @var resource|null */
    private $lockFile;
    private $connection = null;
    private $channel = null;
    private $responseHandler;

    public function __construct($id, $module, ResponseHandler $responseHandler, $config = [])
    {
        $this->responseHandler = $responseHandler;
        parent::__construct($id, $module, $config);
    }

    /**
     * @throws Exception
     * @throws \ErrorException
     */
    public function actionIndex(): void
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
        $channel = $this->channel;
        $channel->exchange_declare('regular_exchange', '', false, false, false);

        list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

        $severities = array_slice($argv, 1);
        if (empty($severities)) {
            file_put_contents('php://stderr', "Usage: $argv[0] [info] [warning] [error]\n");
            exit(1);
        }

        foreach ($severities as $severity) {
            $channel->queue_bind($queue_name, 'regular_exchange', $severity);
        }

        echo " [*] Waiting for logs. To exit press CTRL+C\n";

        $callback = function ($msg) {
            echo ' [x] ', $msg->delivery_info['routing_key'], ':', $msg->body, "\n";
        };

        $channel->basic_consume($queue_name, '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait();
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
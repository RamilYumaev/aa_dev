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
//        $this->lockFile = fopen(self::LOCK_FILE, 'wb');
//        if (!$this->lockFile) {
//            throw new Exception('Cannot create lock file.');
//        }
//        if (!flock($this->lockFile, LOCK_EX | LOCK_NB)) {
//            return;
//        }

        $this->connection = new AMQPStreamConnection(
            \Yii::$app->params['rabbitmqHost'],
            \Yii::$app->params['rabbitmqPort'],
            \Yii::$app->params['rabbitmqUser'],
            \Yii::$app->params['rabbitmqPassword']
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('to_superservice_request', false, false, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

        $this->channel = $this->connection->channel();

        $this->channel->basic_consume(
            'to_superservice_request',
            '',
            false,
            false,
            false,
            false,
            function (AMQPMessage $message) {
                try {
                    echo $message->body;
                    $this->responseHandler->handle($message->body);
                    $message->ack();
                } catch (\Exception $exception) {
                    echo $exception;
                    \Yii::error($exception);
                }
            }
        );
        $this->channel->consume();
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
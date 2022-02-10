<?php
/**
 * Created by PhpStorm.
 * User: Fernando Sena
 * Date: 17/01/2022
 * Time: 23:10
 */

namespace Source\Support;

use Monolog\Handler\StreamHandler;
use Monolog\Handler\TelegramBotHandler;
use Monolog\Logger;

/**
 * Class Log
 * @package Source\Support
 */
class Log extends Logger
{
    private $channel;
    /**
     * Log constructor.
     * @param string $channel
     */
    public function __construct(string $channel = "web")
    {
        $this->channel = $channel;
        parent::__construct($channel);
        $this->pushProcessor(function ($recove){
            $recove["extra"]["USER"] = (user() ? user()->data() : null);
            $recove["extra"]["SERVER"] = $_SERVER;
            return $recove;
        });
    }

    /**
     * @return Logger
     */
    public function archive(): Logger
    {
        $this->pushHandler(new StreamHandler(__DIR__."/../../storage/log/{$this->channel}-".date("d-m-Y").".log", Logger::ERROR));
        return $this;
    }

    /**
     * @return Logger
     */
    public function telegram(): Logger
    {
        $this->pushHandler(new TelegramBotHandler(
        CONF_TELEGRAM_KEY,
        CONF_TELEGRAM_CHANNEL,
        Logger::EMERGENCY
        ));

        return $this;
    }
}
<?php

namespace Source\Core;

use Source\Support\Log;
use Source\Support\Message;
use Source\Support\Seo;

/**
 * @package Source\Core
 */
class Controller
{
    /** @var View */
    protected $view;

    /** @var Seo */
    protected $seo;

    /** @var Message */
    protected $message;

    /** @var Log */
    protected $log;

    /**
     * Controller constructor.
     * @param string|null $pathToViews
     * @param string|null channel
     */
    public function __construct(?string $pathToViews = null, string $channel = "web")
    {
        $this->view = new View($pathToViews);
        $this->seo = new Seo();
        $this->message = new Message();
        $this->log = new Log($channel);
    }
}
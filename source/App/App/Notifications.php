<?php

namespace Source\App\App;

use Source\Models\Notification;

/**
 * Class Notifications
 * @package Source\App\Admin
 */
class Notifications extends App
{
    /**
     * Notifications constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Conta a quantidade de mensagens não lidas no chat
     */
    public function chatCount()
    {
        $json["count"] = (new Notification())->find("user_id = :user_id AND view < 1",
            "user_id={$this->user->id}")->count();
        echo json_encode($json);
    }
}
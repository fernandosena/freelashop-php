<?php

namespace Source\Models;

use Source\Core\Model;

/**
 * Class Notification
 * @package Source\Models
 */
class Notification extends Model
{
    /**
     * Notification constructor.
     */
    public function __construct()
    {
        parent::__construct("notifications", ["id"], ["user_id", "title", "link"]);
    }

    public function newNotification(int $userId, string $title, string $link)
    {
        $this->user_id = $userId;
        $this->title = $title;
        $this->link = $link;

        if(!$this->save()){
            return false;
        }
        return true;
    }
}
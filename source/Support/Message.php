<?php

namespace Source\Support;

use Source\Core\Session;

/**
 * @package Source\Core
 */
class Message
{
    /** @var string */
    private $text;

    /** @var string */
    private $type;

    /** @var string */
    private $icon;

    /** @var string */
    private $button = false;

    /** @var string */
    private $before;

    /** @var string */
    private $after;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->before . $this->text . $this->after;
    }

    /**
     * @return string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @return string
     */
    public function getButton(): string
    {
        return $this->button;
    }

    /**
     * @param string $text
     * @return Message
     */
    public function before(string $text): Message
    {
        $this->before = $text;
        return $this;
    }

    /**
     * @param string $text
     * @return Message
     */
    public function after(string $text): Message
    {
        $this->after = $text;
        return $this;
    }


    public function info(string $message): Message
    {
        $this->icon = "fa-info";
        $this->type = "alert-info";
        $this->text = $this->filter($message);
        (new Log("info"))->archive()->warning($this->text);
        return $this;
    }


    public function success(string $message): Message
    {
        $this->icon = "fa-check";
        $this->type = "alert-success ";
        $this->text = $this->filter($message);
        (new Log("success"))->archive()->warning($this->text);
        return $this;
    }


    public function warning(string $message): Message
    {
        $this->icon = "fa-exclamation-triangle";
        $this->type = "alert-warning";
        $this->text = $this->filter($message);
        (new Log("warning"))->archive()->warning($this->text);
        return $this;
    }


    public function error(string $message): Message
    {
        $this->icon = "fa-ban";
        $this->type = "alert-danger";
        $this->text = $this->filter($message);
        (new Log("error"))->archive()->error($this->text);
        return $this;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return "<div class='alert alert-dismissible {$this->getType()}'><i class='icon fas {$this->getIcon()}'></i> 
        {$this->getText()}</div>";
    }

    /**
     * Set flash Session Key
     */
    public function flash(): void
    {
        $this->type.= " message-fade";
        (new Session())->set("flash", $this);
    }

    public function fadeOut(): Message
    {
        $this->type.= " message-fade";
        return $this;
    }

    /**
     * @param string $message
     * @return string
     */
    private function filter(string $message): string
    {
        return $message;
    }
}
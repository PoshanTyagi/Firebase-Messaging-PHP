<?php


namespace FirebaseMessagingPhp;

class Notification
{
    private $title = '';
    private $body = '';
    private $priority = 'normal';
    private $tokens = [];

    /**
     * @param string $title
     */
    public function setTitle(string $title): Notification
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): Notification
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @param string $priority
     */
    public function setPriority(string $priority) : Notification
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param string $token
     */
    public function addToken(string $token): Notification
    {
        $this->tokens[] = $token;
        return $this;
    }

    /**
     * @param array $tokens
     */
    public function addTokens(array $tokens): Notification
    {
        $this->tokens = array_merge($this->tokens, $tokens);
        return $this;
    }

    public function getData() {
        $data = array(
            'registration_ids' => $this->tokens,
            'priority' => $this->priority,
            'notification' => array(
                "title" => $this->title,
                "body" => $this->body
            )
        );

        return json_encode($data);
    }
}

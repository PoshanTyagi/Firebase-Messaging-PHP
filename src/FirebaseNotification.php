<?php


namespace FirebaseMessagingPhp;

class FirebaseNotification
{
    private $title = '';
    private $body = '';
    private $priority = 'normal';
    private $tokens = [];

    /**
     * This method is use for setting Title of Notification
     * @param string $title
     * @return FirebaseNotification 
     */
    public function setTitle(string $title): FirebaseNotification
    {
        $this->title = $title;
        return $this;
    }

    /**
     * This method is use for setting Body of Notification
     * @param string $body
     * @return FirebaseNotification 
     */
    public function setBody(string $body): FirebaseNotification
    {
        $this->body = $body;
        return $this;
    }

    /**
     * This method is use for setting Priority of Notification
     * @param string $priority
     * @return FirebaseNotification 
     */
    public function setPriority(string $priority): FirebaseNotification
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * This method is use to add Token
     * @param string $token
     * @return FirebaseNotification 
     */
    public function addToken(string $token): FirebaseNotification
    {
        $this->tokens[] = $token;
        return $this;
    }

    /**
     * This method is use to add mutiple Tokens
     * @param array $tokens
     * @return FirebaseNotification 
     */
    public function addTokens(array $tokens): FirebaseNotification
    {
        $this->tokens = array_merge($this->tokens, $tokens);
        return $this;
    }

    /**
     * This method is use to get json string of Notification
     * @return string
     */
    public function getData(): string
    {
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

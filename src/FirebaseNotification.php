<?php


namespace FirebaseMessagingPhp;

class FirebaseNotification
{
    private $title = '';
    private $body = '';
    private $priority = '';
    private $data = [];
    private $timeToLive = null;
    
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
     * This method is use for setting Priority of Notification
     * @param array $data
     * @return FirebaseNotification 
     */
    public function setData(array $data): FirebaseNotification
    {
        $this->data = $data;
        return $this;
    }

    /**
     * This method is use for setting Priority of Notification
     * @param int $timeToLive
     * @return FirebaseNotification 
     */
    public function setTimeToLive(int $timeToLive): FirebaseNotification
    {
        $this->timeToLive = $timeToLive;
        return $this;
    }

    /**
     * This method is use to get json string of Notification
     * @return array
     */
    public function getData(): array
    {
        $body = array(
            'notification' => array(
                "title" => $this->title,
                "body" => $this->body
            )
        );

        if($this->priority !== '')
            $body['priority'] = $this->priority;
        if($this->data !== [])
            $body['data'] = $this->data;
        if($this->timeToLive !== null)
            $body['time_to_live'] = $this->timeToLive;

        return $body;
    }
}

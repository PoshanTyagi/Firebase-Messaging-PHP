<?php

namespace FirebaseMessagingPhp;

class FirebaseClient
{
    const API_URL = 'https://fcm.googleapis.com/fcm/send';

    private $serverId;

    public function __construct($serverId) {
        $this->serverId = $serverId;
        return $this;
    }

    public function setServerId($serverId) : FirebaseClient {
        $this->serverId = $serverId;
        return $this;
    }

    public function send(Notification $notification) {
        $headers = array(
            'Authorization: key=    ' . $this->serverId,
            'Content-Type: application/json'
        );

        $body = $notification->getData();

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, API_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        } catch (\Exception $e) {

        }

        return false;
    }
}

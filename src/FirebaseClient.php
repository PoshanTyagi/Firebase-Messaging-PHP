<?php

namespace FirebaseMessagingPhp;

class FirebaseClient
{
    const API_URL = 'https://fcm.googleapis.com/fcm/send';

    private $serverId;

    /**
     * @param string $serverId
     * @return FirebaseClient 
     */
    public function __construct(string $serverId)
    {
        $this->serverId = $serverId;
        return $this;
    }

    /**
     * This method use for setting Server ID
     * @param string $serverId
     * @return FirebaseClient 
     */
    public function setServerId(string $serverId): FirebaseClient
    {
        $this->serverId = $serverId;
        return $this;
    }

    /**
     * This method use to send Notification
     * @param FirebaseNotification $firebaseNotification
     * @return void 
     */
    public function send(FirebaseNotification $firebaseNotification)
    {
        $headers = array(
            'Authorization: key=    ' . $this->serverId,
            'Content-Type: application/json'
        );

        $body = $firebaseNotification->getData();

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FirebaseClient::API_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $result = curl_exec($ch);
            curl_close($ch);

            return $result;
        } catch (\Exception $e) {
            return false;
        }

        return false;
    }

    /**
     * This method use to Check Users Token
     * @param array $userTokens
     * @return array|bool
     */
    public function verifyTokens(array $userTokens)
    {
        $tokens = array_values($userTokens);
        $users = array_keys($userTokens);

        $data = array(
            'registration_ids' => $tokens,
            'dry_run' => true
        );

        $body = json_encode($data);

        $headers = array(
            'Authorization: key=    ' . $this->serverId,
            'Content-Type: application/json'
        );

        $check['valid'] = [];
        $check['invalid'] = [];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FirebaseClient::API_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $response = curl_exec($ch);
            curl_close($ch);
        } catch (\Exception $e) {
            return false;
        }

        $response = json_decode($response)->results;
        $n = count($response);

        for ($i = 0; $i < $n; $i++) {
            if (isset($response[$i]->error)) {
                $check['invalid'][] = $users[$i];
            } else {
                $check['valid'][] = $users[$i];
            }
        }

        return $check;
    }
}

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
     * @param array $clientTokens
     * @return array
     */
    public function send(FirebaseNotification $firebaseNotification, array $clientTokens)
    {
        if (empty($clientTokens))
            return array('success' => false, 'error' => 'clientTokens array cannot be empty');

        $tokens = array_values($clientTokens);
        $users = array_keys($clientTokens);

        $body = $firebaseNotification->getData();

        $body['registration_ids'] = $tokens;

        $body = json_encode($body);

        $headers = array(
            'Authorization: key=    ' . $this->serverId,
            'Content-Type: application/json'
        );

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FirebaseClient::API_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $result = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
        } catch (\Exception $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }
        if($statusCode !== 200)
            return array('success' => false, 'error' => $result);

        $response = json_decode($result, true)['results'];
        $n = count($response);

        $check['valid'] = [];
        $check['invalid'] = [];

        for ($i = 0; $i < $n; $i++) {
            if (isset($response[$i]['error'])) {
                $check['invalid'][] = $users[$i];
            } else {
                $check['valid'][] = $users[$i];
            }
        }

        return array('success' => true, 'data' => json_decode($result, true), 'result' => $check);
    }

    /**
     * This method use to Check Users Token
     * @param array $clientTokens
     * @return array
     */
    public function verifyTokens(array $clientTokens)
    {
        if (empty($clientTokens))
            return array('success' => false, 'error' => 'clientTokens array cannot be empty');

        $tokens = array_values($clientTokens);
        $users = array_keys($clientTokens);

        $data = array(
            'registration_ids' => $tokens,
            'dry_run' => true
        );

        $body = json_encode($data);

        $headers = array(
            'Authorization: key=    ' . $this->serverId,
            'Content-Type: application/json'
        );

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, FirebaseClient::API_URL);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

            $response = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
        } catch (\Exception $e) {
            return array('success' => false, 'error' => $e->getMessage());
        }

        if($statusCode !== 200)
            return array('success' => false, 'error' => $response);

        $response = json_decode($response, true)['results'];
        $n = count($response);

        $check['valid'] = [];
        $check['invalid'] = [];

        for ($i = 0; $i < $n; $i++) {
            if (isset($response[$i]['error'])) {
                $check['invalid'][] = $users[$i];
            } else {
                $check['valid'][] = $users[$i];
            }
        }

        return array('success' => true, 'result' => $check);
    }
}

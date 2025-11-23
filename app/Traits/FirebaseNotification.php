<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait FirebaseNotification
{
    use RetrievesDeviceTokens, StoresNotifications,RetrievesUserBaseOnTaken;

    protected function fcmUrl(): string
    {
        return "https://fcm.googleapis.com/v1/projects/mawhebtak-36751/messages:send";
    }

    public function sendFcm(array $data, array $userIds = [])
    {
        $accessToken = $this->getAccessToken();
        $deviceTokens = $this->getDeviceTokens($userIds);
        $this->storeNotifications($data, $userIds);

        $responses = [];

        foreach ($deviceTokens as $token) {
          $user =$this->getUserByToken($token);
            $payload = $this->preparePayload($data, $token, $user->language);
            $responses[] = $this->sendNotification($this->fcmUrl(), $accessToken, $payload);
        }

        return response()->json(['responses' => $responses]);
    }

    protected function getAccessToken(): string
    {
        $credentialsPath = storage_path('app/firebase/mawhebtak.json');

        if (!file_exists($credentialsPath)) {
            throw new \Exception('Firebase credentials file not found');
        }

        $credentials = json_decode(file_get_contents($credentialsPath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Invalid JSON in Firebase credentials');
        }

        $jwtHeader = $this->base64UrlEncode(json_encode(['alg' => 'RS256', 'typ' => 'JWT']));
        $now = time();
        $jwtPayload = $this->base64UrlEncode(json_encode([
            'iss' => $credentials['client_email'],
            'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
            'aud' => 'https://oauth2.googleapis.com/token',
            'exp' => $now + 3600,
            'iat' => $now,
        ]));

        $signature = '';
        openssl_sign("$jwtHeader.$jwtPayload", $signature, $credentials['private_key'], 'sha256');
        $jwt = "$jwtHeader.$jwtPayload." . $this->base64UrlEncode($signature);

        $client = new Client();
        $response = $client->post('https://oauth2.googleapis.com/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ],
        ]);

        $tokenData = json_decode($response->getBody(), true);
        return $tokenData['access_token'];
    }

    protected function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }


    protected function preparePayload($data, $token, $language = 'en')
    {
        $message = [
            'notification' => [
                'title' => trans_key($data['title'], $language?? 'en'),
                'body' => trans_key($data['body'], $language?? 'en'),

            ],
            'data' => [
                'reference_id' => isset($data['reference_id']) ? (string)$data['reference_id'] : '',
                'reference_table' => isset($data['reference_table']) ? (string)$data['reference_table'] : '',
            ],
            'token' => $token,
        ];

        return json_encode(['message' => $message]);
    }

    protected function sendNotification(string $url, string $accessToken, string $payload): array
    {
        $client = new Client();

        try {
            $response = $client->post($url, [
                'headers' => [
                    "Authorization" => "Bearer $accessToken",
                    'Content-Type' => 'application/json',
                ],
                'body' => $payload,
            ]);
            return json_decode($response->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            \Log::error('FCM Error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
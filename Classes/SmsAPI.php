<?php
class SmsAPI
{
    private $apiUrl;
    private $apiKey;
    // Constructor to initialize the API URL and API key
    public function __construct()
    {
        $this->apiUrl = 'https://api.textit.biz';
        $this->apiKey = '204bgkd16108edcfadtdc7fadh8267';
    }
    public function sendSms($to, $text)
    {
        $curl = curl_init();
        $payload = json_encode([
            "to" => $to,
            "text" => $text
        ]);
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl, CURLOPT_RETURNTRANSFER => true, CURLOPT_ENCODING => '', CURLOPT_MAXREDIRS => 10, CURLOPT_TIMEOUT => 0, CURLOPT_FOLLOWLOCATION => true, CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, CURLOPT_CUSTOMREQUEST => 'POST', CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Accept: */*',
                'X-API-VERSION: v1',
                'Authorization: Basic ' . $this->apiKey,),
        ));
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            curl_close($curl);
            return [
                'status' => 'error',
                'message' => 'cURL Error: ' . $error_msg
            ];
        }
        curl_close($curl);
        return json_decode($response, true);
    }
}

// Example usage:

/*$smsApi = new SmsApi();

$to = '94772823050'; // Recipient phone number
$text = 'Your OTP is 123456'; // Message to be sent

$response = $smsApi->sendSms($to, $text);

// Output the response
if ($response['status'] == 'success') {
    echo "SMS sent successfully.";
} else {
    echo "Error sending SMS: " . $response['message'];
}*/

?>

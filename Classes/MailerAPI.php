<?php
class MailerAPI {
    private $apiUrl;

    // Constructor to initialize the API URL
    public function __construct() {
        $this->apiUrl = 'https://businessprintersolutions.com/TheesanMailer/mail.php';
    }

    // Method to send the mail using cURL
    public function sendMail($to, $subject, $message) {
        // Data to send via POST
        $data = [
            'to' => $to,
            'from' => 'info@amnzcitytaxi.esanwin.com',
            'sender' => 'AMNZCityTaxi',
            'subject' => $subject,
            'message' => $message
        ];

        // Initialize cURL session
        $ch = curl_init($this->apiUrl);

        // Set cURL options
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        // Execute the request and get the response
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            return 'Request Error: ' . curl_error($ch);
        } else {
            return $this->handleResponse($response);
        }

        // Close cURL session
        curl_close($ch);
    }

    // Method to handle the API response
    private function handleResponse($response) {
        // Output the raw response for debugging (can be removed in production)
        //echo 'Raw response: ' . htmlspecialchars($response) . '<br>';

        // Check if the response is empty
        if (empty($response)) {
            return 'Error: The API response is empty.';
        } else {
            // Decode the JSON response
            $data = json_decode($response, true);

            // Check if JSON decoding was successful
            if (json_last_error() !== JSON_ERROR_NONE) {
                return 'Error: JSON decoding failed - ' . json_last_error_msg();
            } else {
                // Check if 'status' and 'message' are set in the decoded response
                if (isset($data['status']) && $data['status'] == 'success') {
                    return 'Success: ' . $data['message'];
                } elseif (isset($data['message'])) {
                    return 'Error: ' . $data['message'];
                } else {
                    return 'Error: Invalid response format';
                }
            }
        }
    }
}

// Usage Example:

// Initialize the class with the API URL
/*$mailer = new MailerAPI();

// Send an email using the sendMail method
$result = $mailer->sendMail(
    'tkmtheesan1996@gmail.com', 
    'info@amnzcitytaxi.esanwin.com', 
    'AMNZCityTaxi', 
    'OTP Verification', 
    'This is a test message Three.'
);*/

// Output the result
//echo $result;

?>

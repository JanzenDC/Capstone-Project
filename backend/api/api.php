<?php
    // alows sharing resource sharing
  // Tells the browser to allow code from any origin to access
  header('Access-Control-Allow-Origin: *');
  // Tells browsers whether to expose the response to the frontend JavaScript code when the request's credentials mode (Request.credentials) is include
  header("Access-Control-Allow-Credentials: true");
  // Specifies one or more methods allowed when accessing a resource in response to a preflight request
  header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
  // Used in response to a preflight request which includes the Access-Control-Request-Headers to indicate which HTTP headers can be used during the actual request
  header("Access-Control-Allow-Headers: Content-Type");
  header('Content-Type: application/json');
  require_once('../MysqliDb.php');
  require_once(__DIR__ . '/SendInBlue/vendor/autoload.php');


  class API{
    public function __construct()
    {

        $this->db = new MysqliDB('localhost:3306', 'weavemanila', '^d27P64xx', 'weavemanila_main');
    }
    public function httpGet($payload)
    {
 
    }
    
    public function httpPost($payload)
    {
        $requiredFields = ['email', 'code']; // Update field names here
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
        }
        $user = $this->db->where("email", $payload['email'])->getOne('personel_tbl');

        if ($user === null) {
            $response = [
                'status' => 'fail',
                'message' => 'No user with the provided email was found in the system.'
            ];
            echo json_encode($response);
            exit;
        }        
        
        date_default_timezone_set('Asia/Singapore');

        $newOtpCode = $payload['code'];
        $expirationTime = date('Y-m-d H:i:s', strtotime('+2 minutes'));
        
        $existingRecord = $this->db->where("uid", $user['personelID'])->getOne('w_otp');
        
        if ($existingRecord) {
            $updateData = ['otpcode' => $newOtpCode, 'expiration_time' => $expirationTime];
            $addotp = $this->db->where('uid', $user['personelID'])->update('w_otp', $updateData);
        } else {
            $insertData = ['uid' => $user['personelID'], 'otpcode' => $newOtpCode, 'expiration_time' => $expirationTime];
            $addotp = $this->db->insert('w_otp', $insertData);
        }
        
        if ($addotp) {
            $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
            $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
                new GuzzleHttp\Client(),
                $credentials
            );
            $recipient = $payload['email'];
            $validEmail = $payload['email'];
            $code =  $payload['code'];
            $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
                 'subject' => 'Verification Code',
                 'sender' => ['name' => 'WeaveManila Company', 'email' => 'janzendelacruz28@gmail.com'],
                 'replyTo' => ['name' => 'Sendinblue', 'email' => 'no-reply@gmail.com'],
                 'to' => [[ 'name' => $recipient, 'email' => $validEmail]],
                 'htmlContent' => '
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                      <meta charset="UTF-8">
                      <meta name="viewport" content="width=device-width, initial-scale=1.0">
                      <title>Document</title>
                      <style>
                        .container {
                          display: flex;
                          justify-content: center; /* Horizontally center */
                          align-items: center; /* Vertically center */
                          height: 100vh; /* Adjust height as needed */
                        }
                        .text {
                          font-family: Brush Script MT, Brush Script Std, cursive;
                        }
                        .card {
                          text-align: center; 
                          width: 480px;
                          font-family: Arial, sans-serif;
                          font-size:  20px;
                        }
                        .card-2 {
                          gap: 15px;
                          display: flex;
                          place-items: center;
                          text-align: center;
                        }
                        .card-3 {
                          text-align: left;
                          margin-top: 25px;
                          font-size:  15px;

                        }
                        .text-code {
                          text-align: center;
                          margin-top: 25px;
                          font-size: 45px;
                          font-family: Impact, fantasy;
                        }
                        #image {
                          margin-top: 30px;
                          margin-right: 30px;
                          width: 50px;
                          height: 50px
                        }
                      </style>
                    </head>
                    <body>
                      <div class="container">
                        <div class="card">
                          <div class="card-2">
                            <img src="https://i.imgur.com/Hq6U0SG.png" alt="weavemanila.png" id="image">
                            <h1 class="text">Weavemanila Co.</h1>
                          </div>
                            <!-- CHANGE PASSWORD -->
                          <div class="card-3">
                              Hi,<br><br>

                              We received a request to change the password for the WeaveManila Co. account associated with ' . $validEmail . '. If this was initiated by you, please use the confirmation code provided below to complete the password change process:
                              <br>
                          </div>
                          <div class="text-code">' . $code . '</div>
                          <div style="text-align: center; font-size: 12px; margin-top: 20px;">
                            from<br><br>
                            Weavemanila Company<br><br>
                            This message was sent to ' . $validEmail . '.
                          </div>
                        </div>
                      </div>
                    </body>
                    </html>
                    ',
    
                 'params' => ['bodyMessage' => "test"]
            ]);
    
            $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
            $response = [
                'status' => 'success',
                'message' => 'OTP record updated for the user.',
                'info' => [
                    'email' => $user['email'],
                    'code' => $code,
                    'isChangingPass' => 1,
                    
                ]
            ];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => 'fail', 'message' => 'Failed to update OTP record.'];
            echo json_encode($response);
            exit;
        }

    }
    
    
    public function httpPut($ids, $payload)
    {

    }

    public function httpDelete($payload)
    {

    }
    

         
  }
 
  $received_data = json_decode(file_get_contents('php://input'), true);

  $api = new API;
//////////////////////////////////////
if (isset($_SERVER['REQUEST_METHOD'])) {
    $request_method = $_SERVER['REQUEST_METHOD'];
    // Rest of your code using $request_method
    if ($request_method === 'GET') {
        $received_data = $_GET;
    } else {
    //check if method is PUT or DELETE, and get the ids on URL
    if ($request_method === 'PUT' || $request_method === 'DELETE') {
        $request_uri = $_SERVER['REQUEST_URI'];
    
    
        $ids = null;
        $exploded_request_uri = array_values(explode("/", $request_uri));
    
    
        $last_index = count($exploded_request_uri) - 1;
    
    
        $ids = $exploded_request_uri[$last_index];
    
    
        }
    }
    //Checking if what type of request and designating to specific functions
    switch ($request_method) {
        case 'GET':
            $api->httpGet($received_data);
            break;
        case 'POST':
            $api->httpPost($received_data);
            break;
        case 'PUT':
            $api->httpPut($ids, $received_data);
            break;
        case 'DELETE':
            $api->httpDelete($ids,$received_data);
            break;
    }
  
}

?>

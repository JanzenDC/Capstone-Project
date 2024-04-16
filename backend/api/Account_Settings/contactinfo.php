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
  require_once('../../MysqliDb.php');
  require_once('../SendInBlue/vendor/autoload.php');


  class API{
    public function __construct()
    {

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila_main');
    }
    public function httpGet($payload)
    {
 
    }
    
    public function httpPost($payload)
    {
        if($payload['type'] === 1){
            $requiredFields = ['Email','code'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            $userInput = $payload['Email'];
            $user = $this->db->where("email", $userInput)->getOne('personel_tbl');
    
            if ($user === null) {
                $response = ['status' => 'fail', 'message' => 'Invalid Email.'];
                echo json_encode($response);
                exit;
            }
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
                $recipient = $payload['Email'];
                $validEmail = $payload['Email'];
                $code =  $payload['code'];
                $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
                        'subject' => 'Verification Code',
                        'sender' => ['name' => 'WeaveManila Company', 'email' => 'janzendelacruz28@gmail.com'],
                        'replyTo' => ['name' => 'Sendinblue', 'email' => 'no-reply@gmail.com'],
                        'to' => [[ 'name' => $recipient, 'email' => $validEmail]],
                        'htmlContent' => '<!DOCTYPE html>
                        <html lang="en">
                        <head>
                          <meta charset="UTF-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1.0">
                          <title>Document</title>
                          <style>
                            .container {
                              display: flex;
                              justify-content: center;
                              align-items: center;
                              height: 100vh;
                              margin: 0;
                        
                            }
                        
                            .card {
                              text-align: center; /* Optional: to center the image within the card */
                              width: 480px;
                              font-family: Arial, sans-serif; /* Change the font family here */
                              font-size:  20px;
                            }
                            .text {
                              font-family: Brush Script MT, Brush Script Std, cursive;
                            }
                            .card-2 {
                              gap: 15px;
                              display: flex;
                              place-items: center;
                              text-align: center; /* Optional: to center the text horizontally */
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
                          </style>
                        </head>
                        <body>
                          <div class="container">
                            <div class="card">
                              <div class="card-2">
                                <img src="https://i.imgur.com/Hq6U0SG.png" alt="weavemanila.png" style="width: 50px; height: 50px; margin-top: 30px;">
                                <h2 class="text">Weavemanila Co.</h2>
                              </div>
                               <div class="card-3">
                                    Hi,<br><br>
                                
                                    You have attempted to change the email address associated with your WeaveManila Co. account to ' . $validEmail . '. If this action was initiated by you, please use the confirmation code provided below to verify and complete the email address change process:
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
                    'information' => [
                        'email' => $user['email'],
                        'otp_code' => (int)$payload['code'],
                    ]
                ];
                echo json_encode($response);
            } else {
                $response = ['status' => 'fail', 'message' => 'Failed to update OTP record.'];
                echo json_encode($response);
                exit;
            }
            return;
        }
        if($payload['type'] === 2){
            $requiredFields = ['otpVal','userEmail'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }

            }
            if (!is_numeric($payload['otpVal'])) {
                $response = ['status' => 'fail', 'message' => "You've input an invalid code format."];
                echo json_encode($response);
                exit;
            }
            //User OTP in database
            $user = $this->db->where("otpcode", $payload['otpVal'])->getOne('w_otp');
        
            if ($user === null) {
                $response = ['status' => 'fail', 'message' => 'Invalid OTP code.'];
                echo json_encode($response);
                exit;
            } else {
                $expirationTime = strtotime($user['expiration_time']);
                $currentTime = time();
        
                if ($expirationTime < $currentTime) {
                    $response = ['status' => 'fail', 'message' => 'OTP code has been expired.'];
                    echo json_encode($response);
                    exit;
                } else {
                    $userEmailAuth = $this->db->where("email", $payload['userEmail'])->getOne('personel_tbl');
                    $response = [
                        'status' => 'success',
                        'message' => 'OTP record updated for the user.',
                        'information' => [
                            'email' => $userEmailAuth['email'],
                            'otp_code' => $payload['otpVal'],
                        ]
                    ];
                    echo json_encode($response);
                    exit;
                }
            }
        }
        if($payload['type'] === 3){
            $requiredFields = ['newEmail','oldEmail'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }

            }

            //User OTP in database
            $existingRecord = $this->db->where("email", $payload['oldEmail'])->getOne('personel_tbl');
        
            if ($existingRecord === null) {
                $response = ['status' => 'fail', 'message' => 'Email not found in the database.'];
                echo json_encode($response);
                exit;
            } else {
                $updateData = ['email' => $payload['newEmail']];
                $addotp = $this->db->where('email', $existingRecord['email'])->update('personel_tbl', $updateData);                
                $response = [
                    'status' => 'success',
                    'message' => 'Email change completed successfully',
                    'information' => [
                        'email' => $payload['newEmail'],             
                    ]
                ];
                echo json_encode($response);            
            }


        }         
        else {
            // Return a response for other cases or provide a default response if needed
            $response = ['status' => 'fail', 'message' => 'Invalid request.'];
            echo json_encode($response);
            exit;
        }        
    }
    
    
    public function httpPut($ids, $payload)
    {   
        $requiredFields = ['CPnumber'];
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
        }

        $user = $this->db->where("personelID", $ids)->getOne('personel_tbl');

        if ($user === null) {
            $response = ['status' => 'fail', 'message' => 'Invalid target id.'];
            echo json_encode($response);
            exit;
        }
        // Update Data in SQL
        $updateDatas = [
            'mobile_number' => $payload['CPnumber'],
        ];
        $addData = $this->db->where('personelID', $ids)->update('personel_tbl', $updateDatas);
        if($addData){
            $response = [
                'status' => 'success',
                'message' => 'Update Successfully.',
                'information' => [
                    'mobilenumber' => $payload['CPnumber'],
                ]
            ];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => 'fail', 'message' => 'Failed to update user record.'];
            echo json_encode($response);
            exit;
        }
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

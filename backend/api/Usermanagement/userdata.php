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
  require_once(__DIR__ . '/SendInBlue/vendor/autoload.php');



  class API{
    public function __construct()
    {

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila');
    }

    public function httpGet($payload)
    {
        if (empty($payload['select'])) {
            $response = ['status' => 'fail', 'message' => 'Select field is empty.'];
            echo json_encode($response);
            exit;
        }
        if ($payload['select'] === 'all') {
            $sqlQuery = "
                        SELECT 
                        w_users.id, 
                        w_users.firstname, 
                        w_users.lastname, 
                        w_users.position, 
                        w_users.email, 
                        w_users.profile_pic, 
                        w_users.account_created, 
                        w_users.status, 
                        w_users.password,          
                        w_users.gender,            
                        w_users.middlename,        
                        w_users.mobile_number,      
                        w_users.birthdate,          
                        w_users.age,                
                        w_users.address,            
                        w_users.civil_status,      
                        audit_logs.action
                        FROM 
                            w_users
                        JOIN (
                            SELECT 
                                uid, 
                                action
                            FROM 
                                audit_logs
                            WHERE 
                                id IN (SELECT MAX(id) FROM audit_logs GROUP BY uid)
                        ) AS audit_logs ON w_users.id = audit_logs.uid;
                    ";
        
            
            $users = $this->db->rawQuery($sqlQuery);
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];

            echo json_encode($response);
            exit;

        }else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid type specified.',
            ];
            echo json_encode($response);
            exit;
        }

    }
    
    
    public function httpPost($payload)
    {
        if($payload['type'] == '1'){
            $requiredFields = ['userId','status'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            $existingRecord = $this->db->where("id", $payload['userId'])->getOne('w_users');
            if($existingRecord)
            {
                $updateData = ['status' => $payload['status']];
                $updateStatus = $this->db->where('id', $existingRecord['id'])->update('w_users', $updateData);
                $response = [
                    'status' => 'success',
                    'message' => 'The status for the user has been successfully set.',
                ];
                echo json_encode($response);
                exit;        
            }else{
                $response = ['status' => 'fail', 'message' => 'Fail submitting data'];
                echo json_encode($response);            
            }
        }
        if($payload['type'] == '2'){
            $requiredFields = ['fname', 'lname', 'bdate', 'gInput', 'cInput', 'avalue', 'evalue', 'cvalue', 'pvalue', 'cpvalue'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            $email = $payload['evalue'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response = ['status' => 'fail', 'message' => 'Invalid email address'];
                echo json_encode($response);
                exit;
            }
            $contactNumber = $payload['cvalue'];
            if (!preg_match('/^09\d{9}$/', $contactNumber)) {
                $response = ['status' => 'fail', 'message' => 'Invalid Philippine contact number'];
                echo json_encode($response);
                exit;
            }
            $existingEmail = $this->db->where('email', $email)->getOne('w_users');
            if($existingEmail){
                $response = ['status' => 'fail', 'message' => 'Email already exist in the database.'];
                echo json_encode($response);
                exit;
            }else{
                $hashedPassword = password_hash($payload['pvalue'], PASSWORD_DEFAULT);
                $data = [
                    'firstname' => $payload['fname'],
                    'lastname' => $payload['lname'],
                    'email' => $payload['evalue'],
                    'birthdate' => $payload['bdate'],
                    'gender' => $payload['gInput'],
                    'civil_status' => $payload['cInput'],
                    'address' => $payload['avalue'],
                    'mobile_number' => $payload['cvalue'],
                    'password' => $hashedPassword,
                    'profile_pic' => 'default_pfp.png',
                    'status' => 0,
                ];
                $id = $this->db->insert('w_users', $data);
                
                // Check if the insertion was successful
                if ($id) {
                    // Send email using SendinBlue
                    $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
                    $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
                        new GuzzleHttp\Client(),
                        $credentials
                    );
                    $recipient = $payload['evalue'];
                    $validEmail = $payload['evalue'];
                    
                    $htmlContent = '<!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                            <style>
                                body {
                                    font-family: Arial, sans-serif;
                                    margin: 0;
                                    padding: 0;
                                    background-color: #f4f4f4;
                                }
                                .container {
                                    max-width: 600px;
                                    margin: 0 auto;
                                    background-color: #ffffff;
                                    padding: 20px;
                                    border-radius: 5px;
                                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                }
                                .title {
                                    font-size: 24px;
                                    font-weight: bold;
                                    margin-bottom: 20px;
                                }
                                .info {
                                    font-size: 16px;
                                    margin-bottom: 10px;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="container">
                                <div class="title">User Account</div>
                                <div class="info">First Name: ' . $payload['fname'] . '</div>
                                <div class="info">Last Name: ' . $payload['lname'] . '</div>
                                <div class="info">Birthday: ' . $payload['bdate'] . '</div>
                                <div class="info">Gender: ' . $payload['gInput'] . '</div>
                                <div class="info">Civil Status: ' . $payload['cInput'] . '</div>
                                <div class="info">Address: ' . $payload['avalue'] . '</div>
                                <div class="info">Email: ' . $payload['evalue'] . '</div>
                                <div class="info">Contact Number: ' . $payload['cvalue'] . '</div>
                                <div class="info">Password: ' . $payload['pvalue'] . '</div>
                            </div>
                        </body>
                        </html>';
                
                    $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
                        'subject' => 'User Account',
                        'sender' => ['name' => 'WeaveManila Company', 'email' => 'janzendelacruz28@gmail.com'],
                        'replyTo' => ['name' => 'Sendinblue', 'email' => 'no-reply@gmail.com'],
                        'to' => [['name' => $recipient, 'email' => $validEmail]],
                        'htmlContent' => $htmlContent,
                        'params' => ['bodyMessage' => 'test'],
                    ]);
                
                    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);

                    $response = ['status' => 'success', 'message' => 'Successfully Add in the database'];
                    echo json_encode($response);
                    exit;
                } else {
                    $response = ['status' => 'fail', 'message' => 'Failed to insert data into the database'];
                    echo json_encode($response);
                    exit;
                }
            }
        }
    }
    
    
    public function httpPut($ids, $payload)
    {
        if (empty($ids)) {
            $response = ['status' => 'fail', 'message' => 'Target ID is required'];
            echo json_encode($response);
            exit;
        }
        if ($payload['type'] == '3') {
            $requiredFields = ['fname', 'lname', 'bdate', 'gInput', 'cInput', 'avalue', 'evalue', 'cvalue'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            $email = $payload['evalue'];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $response = ['status' => 'fail', 'message' => 'Invalid email address'];
                echo json_encode($response);
                exit;
            }
            $contactNumber = $payload['cvalue'];
            if (!preg_match('/^09\d{9}$/', $contactNumber)) {
                $response = ['status' => 'fail', 'message' => 'Invalid Philippine contact number'];
                echo json_encode($response);
                exit;
            }
            $existingEmail = $this->db->where('id', $ids)->getOne('w_users');
            if($existingEmail){
                $mobileNumber = isset($payload['cvalue']) ? intval($payload['cvalue']) : null;
                $updateData = [
                    'firstname' => $payload['fname'],
                    'lastname' => $payload['lname'],
                    'email' => $payload['evalue'],
                    'birthdate' => $payload['bdate'],
                    'gender' => $payload['gInput'],
                    'civil_status' => $payload['cInput'],
                    'address' => $payload['avalue'],
                    'mobile_number' => $mobileNumber
                ];
                $addData = $this->db->where('id', $ids)->update('w_users', $updateData);
                if($addData){
                    $response = [
                        'status' => 'success',
                        'message' => 'User Information has been updated successfully.',
                        'informations' => $updateData,    
                    ];
                    echo json_encode($response);
                    exit;
                }else{
                    $response = ['status' => 'fail', 'message' => 'Fail to update.'];
                    echo json_encode($response);
                    exit;
                }
            }else{
                $response = ['status' => 'fail', 'message' => 'Did not find user account.'];
                echo json_encode($response);
                exit;
            } 
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

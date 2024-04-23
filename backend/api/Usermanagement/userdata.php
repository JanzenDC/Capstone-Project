<?php
// allows sharing resource sharing
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

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila_main');
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
                    personel_tbl.personelID, 
                    personel_tbl.firstname, 
                    personel_tbl.lastname, 
                    personel_tbl.position, 
                    personel_tbl.email, 
                    personel_tbl.profile_pic, 
                    personel_tbl.account_created, 
                    personel_tbl.status, 
                    personel_tbl.password,          
                    personel_tbl.gender,            
                    personel_tbl.middlename,        
                    personel_tbl.mobile_number,      
                    personel_tbl.birthdate,          
                    personel_tbl.age,                
                    personel_tbl.address,            
                    personel_tbl.civil_status,      
                    COALESCE(audit_logs.action, 'none') AS action
                FROM 
                    personel_tbl
                LEFT JOIN (
                    SELECT 
                        uid, 
                        action
                    FROM 
                        audit_logs
                    WHERE 
                        id IN (SELECT MAX(id) FROM audit_logs GROUP BY uid)
                ) AS audit_logs ON personel_tbl.personelID = audit_logs.uid
                ORDER BY personel_tbl.status DESC;
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
        if($payload['type'] == '2'){
            $requiredFields = ['fname', 'lname', 'bdate', 'gInput', 'cInput', 'avalue', 'evalue', 'cvalue', 'pvalue', 'posvalue'];
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
            $existingEmail = $this->db->where('email', $email)->getOne('personel_tbl');
            if($existingEmail){
                $response = ['status' => 'fail', 'message' => 'Email already exist in the database.'];
                echo json_encode($response);
                exit;
            }else{
                $hashedPassword = password_hash($payload['pvalue'], PASSWORD_DEFAULT);
                $birth_date = $payload['bdate'];

                $birthdate = new DateTime($birth_date);
                $today = new DateTime();
                $age = $today->diff($birthdate)->y;
                
                $data = [
                    'firstname' => $payload['fname'],
                    'lastname' => $payload['lname'],
                    'email' => $payload['evalue'],
                    'birthdate' => $payload['bdate'],
                    'gender' => $payload['gInput'],
                    'civil_status' => $payload['cInput'],
                    'address' => $payload['avalue'],
                    'mobile_number' => $payload['cvalue'],
                    'position' => $payload['posvalue'],
                    'password' => $hashedPassword,
                    'age' => $age, // Calculated age
                    'profile_pic' => 'default_pfp.png',
                    'account_created' => date('Y-m-d H:i:s'), // current date and time
                    'status' => 0,
                ];
              
                $id = $this->db->insert('personel_tbl', $data);
                
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
                      <title>Document</title>
                      <style type="text/css">
                        .container {
                          width: 100%;
                          display: flex;
                          justify-content: center;
                        }
                        .card{
                          border: 2px solid #000;
                          width: 400px;
                          font-weight: bold;
                          border-radius: 5px;
                        }
                        .card-2{
                          padding: 30px;
                        }
                        footer {
                          background: #000;
                          padding: 5px;
                          color: white;
                          text-align: center;
                        }
                      </style>
                    </head>
                    <body>
                      <div class="container">
                        <div class="card">
                          <div class="card-2">
                            Please remember not to share any personal or sensitive user information to ensure privacy and security.
                            <div>
                              <h1>User Information:</h1>
                              <div>
                                <p>Name: ' . $payload['fname'] .' '. $payload['lname'] . ' </p>
                                <p>Birthdate: ' . $payload['bdate'] . '</p>
                                <p>Gender: ' . $payload['   gInput'] . '</p>
                                <p>Civil Status: ' . $payload['cInput'] . '</p>
                                <p>Address: ' . $payload['avalue'] . '</p>
                                <p>Email: ' . $payload['evalue'] . '</p>
                                <p>Position: ' . $payload['posvalue'] . '</p>
                                <p>Password: ' . $payload['pvalue'] . '</p>
                                <p>Contact Number: ' . $payload['cvalue'] . '</p>
                              </div>
                              <div>
                                Kindly visit this link <a href="#">weavemanila.com</a> if you wish to log in.
                              </div>
                            </div>
                          </div>

                          <footer>
                            <p>&copy; 2024 Weavemanila Co. All rights reserved.</p>
                          </footer>
                        </div>
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
        if($payload['type'] == '3'){
            $requiredFields = ['userId','status'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            $existingRecord = $this->db->where("personelID", $payload['userId'])->getOne('personel_tbl');
            if($existingRecord)
            {
                $updateData = ['status' => $payload['status']];
                $updateStatus = $this->db->where('personelID', $existingRecord['personelID'])->update('personel_tbl', $updateData);
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
    }
    
    
    public function httpPut($ids, $payload)
    {
        if (empty($ids)) {
            $response = ['status' => 'fail', 'message' => 'Target ID is required'];
            echo json_encode($response);
            exit;
        }
        if ($payload['type'] == '3') {
            $requiredFields = ['fname', 'lname', 'bdate', 'gInput', 'cInput', 'avalue', 'evalue', 'cvalue', 'posvalue'];
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
            $existingEmail = $this->db->where('personelID', $ids)->getOne('personel_tbl');
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
                    'mobile_number' => $mobileNumber,
                    'position' => $payload['posvalue'],
                ];
                $addData = $this->db->where('personelID', $ids)->update('personel_tbl', $updateData);
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

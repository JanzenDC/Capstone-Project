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



  class API{
    public function __construct()
    {

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila_main');
    }

    public function httpGet($payload)
    {
        if (empty($payload['email'])) {
            $response = ['status' => 'fail', 'message' => 'Email field is empty.'];
            echo json_encode($response);
            exit;
        }
        $existingRecord = $this->db->where('email', $payload['email'])->getOne('personel_tbl');
        if ($existingRecord){
            $response = [
                'status' => 'success',
                'message' => 'Successfully logged in.',
                'information' => [
                    'id' =>    $existingRecord['personelID'],
                    'email' =>    $existingRecord['email'],
                    'password' => $existingRecord['password'],
                    'username' => $existingRecord['username'],
                    'pfp' =>      $existingRecord['profile_pic'],
                    'firstname' => $existingRecord['firstname'],
                    'middlename' => $existingRecord['middlename'],
                    'lastname' => $existingRecord['lastname'],
                    'gender' =>   $existingRecord['gender'],
                    'position' => $existingRecord['position'],
                    'mobilenumber' => $existingRecord['mobile_number'],
                    'birthdate' => $existingRecord['birthdate'],
                    'address' => $existingRecord['address'],
                    'age' => $existingRecord['age'],
                    'otp_code' => 0,
                    'isOnline' => 1,
                    'status' => $existingRecord['status'],
                    'isAdmin' => $existingRecord['isAdmin'],
                    'suffix' => $existingRecord['suffix'],
                    'civil_status' => $existingRecord['civil_status'],
                ]
            ];
            echo json_encode($response);
        }else{
            $response = ['status' => 'fail', 'message' => 'No Existing Records.'];
            echo json_encode($response);
            exit;
        }

    }
    
    
    public function httpPost($payload)
    {

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

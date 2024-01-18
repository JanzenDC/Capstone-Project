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

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila');
    }
    public function httpGet($payload)
    {
 
    }
    
    public function httpPost($payload)
    {
        $requiredFields = ['otpCode'];
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
            if (!is_numeric($payload[$field])) {
                $response = ['status' => 'fail', 'message' => "You've input an invalid code format."];
                echo json_encode($response);
                exit;
            }
        }
        //User OTP in database
        $user = $this->db->where("otpcode", $payload['otpCode'])->getOne('w_otp');
    
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
                $userEmailAuth = $this->db->where("email", $payload['userEmail'])->getOne('w_users');
                $response = [
                    'status' => 'success',
                    'message' => 'OTP is valid.'
                ];
                echo json_encode($response);
                exit;
            }
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

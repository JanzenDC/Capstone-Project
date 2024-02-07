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

    }
    
    
    public function httpPut($ids, $payload)
    {     
        $requiredFields = ['Firstname', 'Lastname','Day','Month','Year', 'Gender']; // Update field names here
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
        }

        // Map gender strings to their respective codes
        $genders = [
            'Male' => 'Male',
            'Female' => 'Female',
            'Rather Not to Say' => 'Rather Not to Say',
        ];
        // Convert of Month names to desired values
        $months = [
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12,
        ];
        $monthNumber = $months[$payload['Month']] ?? null;
        $genderCode = $genders[$payload['Gender']] ?? null;

        $user = $this->db->where("email", $ids)->getOne('personel_tbl');

        if ($user === null) {
            $response = ['status' => 'fail', 'message' => 'Invalid Email.'];
            echo json_encode($response);
            exit;
        }
        // Update Data in SQL
        $updateData = [
            'firstname' => $payload['Firstname'],
            'lastname' => $payload['Lastname'],
            'birthdate' => sprintf('%04d-%02d-%02d', $payload['Year'], $monthNumber, $payload['Day']),
            'gender' => $genderCode,
        ];
        $addData = $this->db->where('email', $ids)->update('personel_tbl', $updateData);
        if($addData){
            $response = [
                'status' => 'success',
                'message' => 'Update Successfully.',
                'information' => [
                    'firstname' => $payload['Firstname'],
                    'lastname' => $payload['Lastname'],
                    'birthdate' => sprintf('%04d-%02d-%02d', $payload['Year'], $monthNumber, $payload['Day']),
                    'gender' => $genderCode,
                ]
            ];
            echo json_encode($response);
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

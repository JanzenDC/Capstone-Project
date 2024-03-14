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
  require_once('../../../MysqliDb.php');



  class API{
    public function __construct()
    {

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila_main');
    }

    public function httpGet($payload)
    {
        if($payload['get'] === 'weaver'){
            $getData = $this->db->get('weaverlist_tbl');
            if($getData){
                $response = [
                    'status' => 'success',
                    'message' => 'Successfully fetch data.',
                    'weaverData' => $getData,
                ];
                echo json_encode($response);
                exit;
            }else{
                $response = [
                    'status' => 'fail',
                    'message' => 'There is no Data.',
                ];
                echo json_encode($response);
                exit;
            }

        }else{
            $response = [
                'status' => 'fail',
                'message' => 'Invalid Payload.',
            ];
            echo json_encode($response);
            exit;
        }
    }
    
    
    
    public function httpPost($payload)
    {
        if($payload['type'] == '1'){
            $requiredFields = ['weaverAddress','v_fname', 'v_lname', 'v_contactnumber', 'v_emailaddress'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            $getExistingEmail = $this->db->where('weaverEmail', $payload['v_emailaddress'])->getOne('weaverlist_tbl');
            if($getExistingEmail){
                $response = [
                    'status' => 'fail',
                    'message' => 'Fail to insert data there is existing same email in the database.',
                ];
                echo json_encode($response);
                exit;
            }else{
                $data = [
                    'weaverFname' => $payload['v_fname'],
                    'weaverLname' => $payload['v_lname'],
                    'weaverContact' => $payload['v_contactnumber'],
                    'weaverEmail' => $payload['v_emailaddress'],
                    'weaverAddress' => $payload['weaverAddress'],
                ];
                $insertData = $this->db->insert('weaverlist_tbl', $data);
                if($insertData){
                    $response = [
                        'status' => 'success',
                        'message' => 'Weaver added successfully.',
                    ];
                    echo json_encode($response);
                    exit;            
                }else{
                    $response = [
                        'status' => 'fail',
                        'message' => 'Fail to insert data.',
                    ];
                    echo json_encode($response);
                    exit;
                }
            }
        }else if($payload['type'] == '2'){
            $requiredFields = ['weaverAddress','v_fname', 'v_lname', 'v_contactnumber', 'v_emailaddress', 'v_selectedID'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            // First query kunin yung id if exist or not
            $getData = $this->db->where('weaverID', $payload['v_selectedID'])->getOne('weaverlist_tbl');
            if($getData){
                $data = [
                    'weaverFname' => $payload['v_fname'],
                    'weaverLname' => $payload['v_lname'],
                    'weaverContact' => $payload['v_contactnumber'],
                    'weaverEmail' => $payload['v_emailaddress'],
                    'weaverAddress' => $payload['weaverAddress'],
                ];
                $updteData = $this->db->where('weaverID', $payload['v_selectedID'])->update('weaverlist_tbl', $data);
                if($updteData){
                    $response = ['status' => 'success', 'message' => 'Weaver data updated successfully.'];
                    echo json_encode($response);
                    exit;
                }else{
                    $response = ['status' => 'fail', 'message' => 'Failed to update weaver data.'];
                    echo json_encode($response);
                    exit;
                }
            }else{
                $response = ['status' => 'fail', 'message' => 'Invalid data or Selected weaver not exist.'];
                echo json_encode($response);
                exit;
            }
        }else{
            $response = ['status' => 'fail', 'message' => 'Invalid Type for payload'];
            echo json_encode($response);
            exit;
        }
    }
    
    
    
    public function httpPut($ids, $payload)
    {

    }
    

    public function httpDelete($ids, $payload)
    {
        if (empty($ids)) {
            $response = ['status' => 'fail', 'message' => 'Invalid or empty IDs array.'];
            echo json_encode($response);
            exit;
        }
        $deleteData = $this->db->where('weaverID', $ids)->delete('weaverlist_tbl');
        if($deleteData){
            $response = [
                'status' => 'success',
                'message' => 'Weaver deleted successfully.',
            ];
            echo json_encode($response);
            exit;
        }else{
            $response = [
                'status' => 'fail',
                'message' => 'Failed to delete weaver. Invalid IDs provided.',
            ];
            echo json_encode($response);
            exit;
        }
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
            $api->httpDelete($ids, $received_data);
            break;
    }
  
}

?>

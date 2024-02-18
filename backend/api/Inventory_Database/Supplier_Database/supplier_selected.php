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
        if ($payload['get'] === 'alldata') {
            $categoryData = $this->db->get('w_supplierlist');
            if ($categoryData) {
                $response = [
                    'status' => 'success',
                    'message' => 'Fetch Successfully.',
                    'information' => [
                        'values' => $categoryData,
                    ],
                ];
            } else {
                $response = [
                    'status' => 'fail',
                    'message' => 'Failed to fetch data.',
                ];
            }
    
            echo json_encode($response);
            exit;
        }
    }
    
    
    
    public function httpPost($payload)
    {
        $requiredFields = ['supplier_Name', 'supplier_Address', 'supplier_ContactName', 'supplier_Cp', 'supplier_Email'];
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }   
        }
        if (!filter_var($payload['supplier_Email'], FILTER_VALIDATE_EMAIL)) {
            $response = ['status' => 'fail', 'message' => 'Invalid email format'];
            echo json_encode($response);
            exit;
        }

        if (!is_numeric($payload['supplier_Cp'])) {
            $response = ['status' => 'fail', 'message' => 'Supplier_Cp must be a numeric value'];
            echo json_encode($response);
            exit;
        }

        $data = [
            'supplier_name' => $payload['supplier_Name'],
            'contact_person' => $payload['supplier_ContactName'],
            'address' => $payload['supplier_Address'],
            'contact' => $payload['supplier_Cp'],
            'email' => $payload['supplier_Email'],
        ];
        $id = $this->db->insert('w_supplierlist', $data);
        if ($id) {
            $response = ['status' => 'success', 'message' => 'Successfully Add in the database'];
            echo json_encode($response);
            exit;
        }else{
            $response = ['status' => 'fail', 'message' => 'Failed to insert data into the database'];
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
        $existingIDs = $this->db->where('supplierID', $ids)->getOne('w_supplierlist');
        if (!$existingIDs) {
            $response = ['status' => 'fail', 'message' => 'IDs not found in the database.'];
            echo json_encode($response);
            exit;
        }
        // First Execute
        $data = [
            'supplierID' => $ids,
            'supplier_name' => $existingIDs['supplier_name'],
            'contact_person' => $existingIDs['contact_person'],
            'address' => $existingIDs['address'],
            'contact' => $existingIDs['contact'],
            'email' => $existingIDs['email'],
        ];
        $insertData = $this->db->insert('supplier_restorepoint', $data);
        if($insertData){
            $deleteData = $this->db->where('supplierID', $ids)->delete('w_supplierlist');
            $response = [
                'status' => 'success',
                'message' => 'Records deleted successfully.',
            ];
            echo json_encode($response);
            exit; 
        }else{
            $response = ['status' => 'fail', 'message' => 'Failed to add in restore point.'];
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
            $api->httpDelete($ids,$received_data);
            break;
    }
  
}

?>


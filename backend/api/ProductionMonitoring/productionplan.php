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
        // Query to retrieve the maximum pjoID
        $query = "SELECT MAX(pjoID) AS max_pjoID FROM pjo_tbl";
    
        // Execute the query
        $result = $this->db->rawQuery($query);
    
        // Check if the query was successful
        if ($result) {
            $max_pjoID = $result[0]['max_pjoID'];
            $next_pjoID = $max_pjoID + 1;

            $query = "SELECT companyDate FROM mpo_starting_date ORDER BY companyDate DESC LIMIT 1";
 
            $latestMPOresult = $this->db->rawQuery($query);
            $latestMPOdata = ($latestMPOresult) ? $latestMPOresult[0] : null;

            $response = [
                'status' => 'success',
                'pjoID' => $next_pjoID,
                'mpo' => $latestMPOdata,
                ];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => 'fail', 'message' => 'Error: Failed to retrieve the next pjoID'];
            echo json_encode($response);
            exit;
        }
    }
    
    
    

    public function httpPost($payload)
    {
        $requiredFields = ['v_clientname','v_pattern','v_quantity', 'v_orderdate', 'v_commitment', 'v_shipment', 'v_length', 'v_width', 'v_size'];
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
        }

        $insertData = [
          'client_name' => $payload['v_clientname'], 
          'design_pattern' => $payload['v_pattern'],
          'quantity' => $payload['v_quantity'],
          'order_date' => $payload['v_orderdate'],
          'commitment_date' => $payload['v_commitment'],
          'shipped_date' => $payload['v_shipment'],
          'length' => $payload['v_length'],
          'width' =>  $payload['v_width'],
          'size_selected' => $payload['v_size'],
        ];
        $query = $this->db->insert('pjo_tbl', $insertData);
        if($query){
          $response = [
            'status' => 'success',
            'message' => 'Data inserted successfully.'
          ];
          echo json_encode($response);
          exit;
        }else{
          $response = ['status' => 'fail', 'message' => 'Error: Failed to insert data.'];
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

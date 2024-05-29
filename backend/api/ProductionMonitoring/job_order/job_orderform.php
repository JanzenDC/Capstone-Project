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

        $this->db = new MysqliDB('localhost:3306', 'weavemanila', '^d27P64xx', 'weavemanila_main');
    }
    public function httpGet($payload)
    {
        if (!isset($payload['get'])) {
            $response = [
                'status' => 'fail',
                'message' => 'Payload is missing required fields.',
            ];
            echo json_encode($response);
            exit; 
        }
        $getData = $this->db->where('job_order_no', $payload['get'])->getOne('pjo_tbl');
        
        // Check if data retrieval was successful
        if ($getData !== false) {

            $sql = "SELECT * FROM material_specs_tbl 
            WHERE pjoID = ? 
            ORDER BY 
                CASE 
                    WHEN type = 'Warp' THEN 1
                    WHEN type = 'Insert' THEN 2
                    WHEN type = 'Weft' THEN 3
                END";

            $material_specs = $this->db->rawQuery($sql, [$getData['pjoID']]);

            $item_actual_weight = $this->db->where('pjoID', $getData['pjoID'])->get('item_actual_weight');
            $total_material_used = $this->db->where('pjoID', $getData['pjoID'])->get('total_material_used');
            $design_specs_tbl = $this->db->where('pjoID', $getData['pjoID'])->get('design_specs_tbl');
            $post_data_specs_tbl = $this->db->where('pjoID', $getData['pjoID'])->get('post_data_specs_tbl');
            $material_issuance_tbl = $this->db->where('pjoID', $getData['pjoID'])->get('material_issuance_tbl');

            $response = [
                'status' => 'success',
                'message' => 'Successfully fetched data',
                'PJOdata' => $getData,
                'PJOlink' => [
                    'mats_specs' => $material_specs,
                    'item_actual_weight' => $item_actual_weight,
                    'total_material_used' => $total_material_used,
                    'design_specs_tbl' => $design_specs_tbl,
                    'post_data_specs_tbl' => $post_data_specs_tbl,
                    'material_issuance_tbl' => $material_issuance_tbl,
                ]
            ];
            echo json_encode($response);
            exit;
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Failed to load Job Order.',
            ];
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

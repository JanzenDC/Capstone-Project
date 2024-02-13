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
        if($payload['get'] == 'alldata'){
            $sqlQuery = 'SELECT mpo_tbl.mpoID,
            mpo_tbl.personelID,
            mpo_tbl.supplierID,
            mpo_tbl.categoryID,
            mpo_tbl.mpo_ref_no,
            mpo_tbl.date_purchased,
            mpo_tbl.client_ref_no,
            mpo_tbl.w_o_ref_no,
            mpo_tbl.delivery_date,
            mpo_tbl.delivery_address,
            mpo_tbl.supplier_address,
            mpo_tbl.item,
            mpo_tbl.product_description,
            mpo_tbl.quantity,
            mpo_tbl.unit,
            mpo_tbl.unit_price,
            mpo_tbl.total,
            mpo_tbl.delivery_charge,
            mpo_tbl.discount,
            mpo_tbl.other_costs,
            mpo_tbl.total_amount,
            mpo_tbl.notes_instructions,
            mpo_tbl.prepared_by,
            mpo_tbl.approved_by,
            mpo_tbl.status,
            w_supplierlist.supplierID,
            w_supplierlist.supplier_name 
            FROM mpo_tbl 
            LEFT JOIN w_supplierlist ON mpo_tbl.supplierID = w_supplierlist.supplierID';
            $queryResult = $this->db->rawQuery($sqlQuery);
            if($queryResult){
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been fetch succesfully',
                    'categoryData' => $queryResult,
                ];
                echo json_encode($response);
                exit;
            }else{
                $response = [
                    'status' => 'fail',
                    'message' => 'There is no data in here.',
                ];
                echo json_encode($response);
                exit;                    
            }
        } 
        else if($payload['get'] == 'category'){
            $categoryData = $this->db->get('w_category');
            if($categoryData){
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been fetch succesfully',
                    'categoryData' => $categoryData,
                ];
                echo json_encode($response);
                exit;
            }else{
                $response = [
                    'status' => 'fail',
                    'message' => 'There is no data in here.',
                ];
                echo json_encode($response);
                exit;                    
            }
        }
        else if($payload['get'] == 'supplier'){
            $categoryData = $this->db->get('w_supplierlist');
            if($categoryData){
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been fetch succesfully',
                    'categoryData' => $categoryData,
                ];
                echo json_encode($response);
                exit;
            }else{
                $response = [
                    'status' => 'fail',
                    'message' => 'There is no data in here.',
                ];
                echo json_encode($response);
                exit;                    
            }
        }else {
            $response = [
                'status' => 'fail',
                'message' => 'Failed to fetch data.',
            ];
        }
    }
    
    
    
    public function httpPost($payload)
    {

    }
    
    
    
    public function httpPut($ids, $payload)
    {

    }
    

    public function httpDelete($ids, $payload)
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


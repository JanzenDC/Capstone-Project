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

    }
    
    
    
    public function httpPost($payload)
    {
        if($payload['type'] == '1')
        {
            $requiredFields = ['targetdata'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }   
            }
            // First Query select yung data galing sa restore point supplier_restorepoint
            $getdata = $this->db->where("supplierID",$payload['targetdata'])->getOne('supplier_restorepoint');
            if($getdata){
                // Second Query 
                $data = [
                    'supplierID' => $getdata['supplierID'],
                    'supplier_name' => $getdata['supplier_name'],
                    'contact_person' => $getdata['contact_person'],
                    'address' => $getdata['address'],
                    'contact' => $getdata['contact'],
                    'email' => $getdata['email'],
                ];
                $insertdata = $this->db->insert('w_supplierlist', $data);
                $deleteData = $this->db->where('supplierID', $payload['targetdata'])->delete('supplier_restorepoint');
                $response = ['status' => 'success', 'message' => 'Successfully Restore supplier.'];           
                echo json_encode($response);
                exit;     
            }else{
                $response = ['status' => 'fail', 'message' => 'Invalid supplier ID.'];
                echo json_encode($response);
                exit;                
            }
        }
        else if($payload['type'] == '2')
        {
            $restore = $this->db->get('supplier_restorepoint');
            if($restore){
                foreach ($restore as $record) {
                    $data = [
                        'supplierID' => $record['supplierID'],
                        'supplier_name' => $record['supplier_name'],
                        'contact_person' => $record['contact_person'],
                        'address' => $record['address'],
                        'contact' => $record['contact'],
                        'email' => $record['email'],
                    ];
                    $insert = $this->db->insert('w_supplierlist', $data);
                    if(!$insert){
                        $response = ['status' => 'fail', 'message' => 'Failed to restore data.'];
                        echo json_encode($response);
                        exit;                    
                    }
                }
                $delete = $this->db->delete('supplier_restorepoint');
                
                if($delete){
                    $response = ['status' => 'success', 'message' => 'Data restored successfully.'];
                    echo json_encode($response);
                    exit;
                } else {
                    $response = ['status' => 'fail', 'message' => 'Failed to delete restore points.'];
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = ['status' => 'fail', 'message' => 'Failed to get data.'];
                echo json_encode($response);
                exit;
            }
        }else{

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
        $existingIDs = $this->db->where('supplierID', $ids)->getOne('supplier_restorepoint');
        if (!$existingIDs) {
            $response = ['status' => 'fail', 'message' => 'IDs not found in the database.'];
            echo json_encode($response);
            exit;
        }

        $deleteData = $this->db->where('supplierID', $ids)->delete('supplier_restorepoint');        
        if($deleteData){
            $response = [
                'status' => 'success',
                'message' => 'Record(s) deleted successfully.',
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


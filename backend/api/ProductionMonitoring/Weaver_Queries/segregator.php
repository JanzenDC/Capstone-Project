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
        if($payload['get'] === 'segregator'){
            $getData = $this->db->get('segregatorlist_tbl');
            if($getData){
                $response = [
                    'status' => 'success',
                    'message' => 'Successfully fetch data.',
                    'segregatorData' => $getData,
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

        }else if($payload['get'] == 'onesegregator'){

            $currentValues = $this->db->rawQuery("
                SELECT
                    mpoID,
                    segregatorName,
                    MAX(qty_issued) AS max_qty_issued,
                    MAX(qty_received) AS max_qty_received,
                    MAX(waste_gumon) AS max_waste_gumon,
                    GREATEST(0, (MAX(qty_received) + MAX(waste_gumon) - MAX(qty_issued))) AS balance
                FROM
                    mpo_segregator_projects
                WHERE
                    mpoID = ? AND segregatorName = ?
                GROUP BY
                    mpoID,
                    segregatorName
            ", Array($payload['mpoID'], $payload['selectSegregator']));
        
                $response = ['status' => '', 'message' => $currentValues];
                echo json_encode($response);
                exit;
            // if(!$currentValues){
            //     $insertData = [
            //         'baseID' => $payload['selectedBaseID'],
            //         'segregatorName' => $payload['selectSegregator'],
            //         'date_issuance' => $payload['vData'],
            //         'qty_issued' => 0, // Assuming qty_issued is 0 for the new record
            //         'qty_received' => $new_qty_received,
            //         'waste_gumon' => $new_waste_gumon,
            //         'process' => $payload['selectProcess'],
            //         'mpoID' => $payload['mpoID'] // Don't forget to add mpoID to the insert data
            //     ];
            //     $insertQuery = $this->db->insert('mpo_segregator_projects', $insertData);
            //     if($insertQuery){
            //         $response = ['status' => 'success', 'message' => 'Data inserted successfully'];
            //         echo json_encode($response);
            //         exit;
            //     } else {
            //         $response = ['status' => 'fail', 'message' => 'There is a problem to insert data'];
            //         echo json_encode($response);
            //         exit;
            //     }
            // } else {
            //     $response = ['status' => 'fail', 'message' => 'Balance would be negative, cannot insert data'];
            //     echo json_encode($response);
            //     exit;
            // }
    
        }else if($payload['get'] == 'onesegregators'){
            $currentValues = $this->db->rawQuery("
                SELECT *
                FROM mpo_segregator_projects
                WHERE mpoID = ? AND segregatorName = ?
                GROUP BY mpoID, segregatorName
            ", Array($payload['mpoID'], $payload['segregatorName']));
        
        
                $response = ['status' => '', 'mpoSeg' => $currentValues];
                echo json_encode($response);
                exit;
        }
            
        else{
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
            $requiredFields = ['segregatorAddress','v_fname', 'v_lname', 'v_contactnumber', 'v_emailaddress'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            $getExistingEmail = $this->db->where('segregatorEmail', $payload['v_emailaddress'])->getOne('segregatorlist_tbl');
            if($getExistingEmail){
                $response = [
                    'status' => 'fail',
                    'message' => 'Fail to insert data there is existing same email in the database.',
                ];
                echo json_encode($response);
                exit;
            }else{
                $data = [
                    'segregatorFname' => $payload['v_fname'],
                    'segregatorLname' => $payload['v_lname'],
                    'segregatorContact' => $payload['v_contactnumber'],
                    'segregatorEmail' => $payload['v_emailaddress'],
                    'segregatorAddress' => $payload['segregatorAddress'],
                ];
                $insertData = $this->db->insert('segregatorlist_tbl', $data);
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
        } if($payload['type'] == '2'){
            $requiredFields = ['segregatorAddress','v_fname', 'v_lname', 'v_contactnumber', 'v_emailaddress', 'v_selectedID'];
            foreach ($requiredFields as $field) {
                if (!isset($payload[$field])) {
                    $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                    echo json_encode($response);
                    exit;
                }
            }
            // First query kunin yung id if exist or not
            $getData = $this->db->where('segregatorID', $payload['v_selectedID'])->getOne('segregatorlist_tbl');
            if($getData){
                $data = [
                    'segregatorFname' => $payload['v_fname'],
                    'segregatorLname' => $payload['v_lname'],
                    'segregatorContact' => $payload['v_contactnumber'],
                    'segregatorEmail' => $payload['v_emailaddress'],
                    'segregatorAddress' => $payload['segregatorAddress'],
                ];
                $updteData = $this->db->where('segregatorID', $payload['v_selectedID'])->update('segregatorlist_tbl', $data);
                if($updteData){
                    $response = ['status' => 'success', 'message' => 'Weaver data updated successfully.'];
                    echo json_encode($response);
                    exit;
                }else{
                    $response = ['status' => 'fail', 'message' => 'Failed to update segregator data.'];
                    echo json_encode($response);
                    exit;
                }
            }else{
                $response = ['status' => 'fail', 'message' => 'Invalid data or Selected segregator not exist.'];
                echo json_encode($response);
                exit;
            }
        
        }else if($payload['type'] == '3'){
            $getMpoID = $this->db->where('baseID', $payload['selectedBaseID'])->getOne('mpo_base');

            $insertData = [
                'baseID' => $payload['selectedBaseID'],
                'segregatorName' => $payload['selectSegregator'],
                'date_issuance' => $payload['vData'],
                'qty_issued' => $payload['qty_raw_issuance'],
                'qty_received' => $payload['qty_received'],
                'waste_gumon' => $payload['vWaste'],
                'process' => $payload['selectProcess'],
            ];
            $insertQuery = $this->db->insert('mpo_segregator_projects', $insertData);
            if($insertQuery){
              $updateData = ['quantity_balance' => $payload['quantitybal']];
              $updateMPO = $this->db->where('baseID', $payload['selectedBaseID'])->update('mpo_base', $updateData);
              $response = ['status' => 'success', 'message' => 'Data inserted successfully'];
              echo json_encode($response);
              exit;
            }else{
              $response = ['status' => 'fail', 'message' => 'There is a problem to insert data'];
              echo json_encode($response);
              exit;
            }
        } else if($payload['type'] == '4'){
            $mpoID = $payload['mpoID'];
        
            // Check if there is existing data for the specified mpoID and segregatorName
            $firstQuery = $this->db->rawQueryOne("
                SELECT
                    COUNT(*) AS count
                FROM
                    mpo_segregator_projects
                WHERE
                    mpoID = ? AND segregatorName = ?
            ", [$mpoID, $payload['selectSegregator']]);
        
            if ($firstQuery['count'] > 0) {
                // Retrieve the current max values and balance
                $currentValues = $this->db->rawQueryOne("
                    SELECT
                        mpoID,
                        segregatorName,
                        MAX(qty_issued) AS max_qty_issued,
                        MAX(qty_received) AS max_qty_received,
                        MAX(waste_gumon) AS max_waste_gumon,
                        GREATEST(0, (MAX(qty_received) + MAX(waste_gumon) - MAX(qty_issued))) AS balance
                    FROM
                        mpo_segregator_projects
                    WHERE
                        mpoID = ? AND segregatorName = ?
                    GROUP BY
                        mpoID,
                        segregatorName
                ", [$mpoID, $payload['selectSegregator']]);
        
                if ($currentValues['balance'] >= 0) {
                    $insertData = [
                        'baseID' => $payload['selectedBaseID'],
                        'segregatorName' => $payload['selectSegregator'],
                        'date_issuance' => $payload['vData'],
                        'qty_issued' => 0, // Assuming qty_issued is 0 for the new record
                        'qty_received' => $payload['qty_receiveds'],
                        'waste_gumon' =>  $payload['vWastes'],
                        'process' => $payload['selectProcess'],
                        'mpoID' => $mpoID // Don't forget to add mpoID to the insert data
                    ];
                    $insertQuery = $this->db->insert('mpo_segregator_projects', $insertData);
                    if ($insertQuery) {
                        $response = ['status' => 'success', 'message' => 'Data inserted successfully'];
                        echo json_encode($response);
                        exit;
                    } else {
                        $response = ['status' => 'fail', 'message' => 'There is a problem to insert data'];
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = ['status' => 'fail', 'message' => 'Balance would be negative, cannot insert data'];
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response = ['status' => 'fail', 'message' => 'No existing data for the specified mpoID and segregatorName'];
                echo json_encode($response);
                exit;
            }
        }
        
        
        else{
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
        $deleteData = $this->db->where('segregatorID', $ids)->delete('segregatorlist_tbl');
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
                'message' => 'Failed to delete segregator. Invalid IDs provided.',
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

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
        if ($payload['type']) {
            if($payload['type'] == '1'){
                $sqlQuery = "
                SELECT w_category.categoryID,
                w_category.title, 
                w_category.description, 
                w_category.procedure, 
                COUNT(mpo_tbl.mpoID) AS itemCount
                FROM w_category
                LEFT JOIN mpo_tbl ON w_category.categoryID = mpo_tbl.categoryID
                GROUP BY w_category.categoryID;
                
                ";
                $categoryData = $this->db->rawQuery($sqlQuery);
                $countData = [];
                foreach ($categoryData as $row) {
                    $countData[$row['categoryID']] = $row['itemCount'];
                }
                if ($categoryData) {
                    $response = [
                        'status' => 'success',
                        'message' => 'Fetch Successfully.',
                        'information' => [
                            'rows' => $categoryData, // fetching all data
                            'itemCountData' => $countData, //query here the count data
                        ],
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to fetch data.',
                    ];
                }
                echo json_encode($response);
                exit;
            }else if($payload['type'] == '2'){
                if (empty($payload['id'])) {
                    $response = ['status' => 'fail', 'message' => 'Invalid or empty IDs array.'];
                    echo json_encode($response);
                    exit;
                }
                $categoryID = $payload['id'];
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
                mpo_tbl.total,
                mpo_tbl.delivery_charge,
                mpo_tbl.discount,
                mpo_tbl.other_costs,
                mpo_tbl.total_amount,
                mpo_tbl.notes_instructions,
                mpo_tbl.prepared_by,
                mpo_tbl.approved_by,
                w_supplierlist.supplierID,
                w_supplierlist.supplier_name,
                w_supplierlist.address,
                mpo_base.baseID,
                mpo_base.item_name,
                mpo_base.description,
                mpo_base.quantity,
                mpo_base.unit,
                mpo_base.quantity_received,
                mpo_base.unit_price,
                mpo_base.status,
                mpo_base.discounts,
                mpo_base.subtotal
                FROM mpo_tbl
                LEFT JOIN w_supplierlist ON mpo_tbl.supplierID = w_supplierlist.supplierID
                LEFT JOIN mpo_base ON mpo_tbl.mpoID = mpo_base.mpoID
                WHERE mpo_tbl.categoryID = ?';    
                $results = $this->db->rawQuery($sqlQuery, array($categoryID));
                if($results){
                    $response = [
                        'status' => 'success',
                        'message' => 'Data has been fetch succesfully',
                        'categoryData' => $results,
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
            }else if($payload['type'] == '3'){
                $sqlQuery = 'SELECT 
                            mpo.mpoID,
                            mpo.personelID,
                            mpo.supplierID,
                            mpo.categoryID,
                            mpo.mpo_ref_no,
                            mpo.date_purchased,
                            mpo.client_ref_no,
                            mpo.w_o_ref_no,
                            mpo.delivery_date,
                            mpo.delivery_address,
                            mpo.supplier_address,
                            mpo.total,
                            mpo.delivery_charge,
                            mpo.discount,
                            mpo.other_costs,
                            mpo.total_amount,
                            mpo.notes_instructions,
                            mpo.prepared_by,
                            mpo.approved_by,
                            supplier.supplier_name,
                            supplier.address AS supplier_address,
                            base.baseID,
                            base.item_name,
                            base.quantity,
                            base.unit,
                            base.quantity_received,
                            base.unit_price,
                            base.status,
                            base.discounts,
                            base.subtotal,
                            base.quantity_balance,
                            COALESCE(received_logs.datareceivedID, "") AS datareceivedID,
                            received_logs.baseID,
                            COALESCE(received_logs.date_received, "No data.") AS date_received
                        FROM 
                            mpo_tbl AS mpo
                        LEFT JOIN 
                            w_supplierlist AS supplier ON mpo.supplierID = supplier.supplierID
                        LEFT JOIN 
                            mpo_base AS base ON mpo.mpoID = base.mpoID
                        LEFT JOIN 
                        (
                            SELECT 
                                baseID, 
                                MAX(timestamp) AS max_date_received
                            FROM 
                                mpo_datereceived_logs
                            GROUP BY 
                                baseID
                        ) AS latest_dates ON base.baseID = latest_dates.baseID
                        LEFT JOIN 
                mpo_datereceived_logs AS received_logs ON base.baseID = received_logs.baseID AND latest_dates.max_date_received = received_logs.timestamp';
                        
                $queryResult = $this->db->rawQuery($sqlQuery);
                if($queryResult){
                    $response = [
                        'status' => 'success',
                        'message' => 'Data has been fetch successfully',
                        'categoryData' => $queryResult
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
            }else if($payload['type'] == '4'){
                $target = $payload['id'];
                $sqlQuery = 'SELECT 
                            mpo.mpoID,
                            mpo.personelID,
                            mpo.supplierID,
                            mpo.categoryID,
                            mpo.mpo_ref_no,
                            mpo.date_purchased,
                            mpo.client_ref_no,
                            mpo.w_o_ref_no,
                            mpo.delivery_date,
                            mpo.delivery_address,
                            mpo.supplier_address,
                            mpo.total,
                            mpo.delivery_charge,
                            mpo.discount,
                            mpo.other_costs,
                            mpo.total_amount,
                            mpo.notes_instructions,
                            mpo.prepared_by,
                            mpo.approved_by,
                            supplier.supplier_name,
                            supplier.address AS supplier_address,
                            base.baseID,
                            base.item_name,
                            base.quantity,
                            base.unit,
                            base.quantity_received,
                            base.unit_price,
                            base.status,
                            base.discounts,
                            base.subtotal,
                            COALESCE(received_logs.datareceivedID, "") AS datareceivedID,
                            received_logs.baseID,
                            COALESCE(received_logs.date_received, "No data.") AS date_received
                        FROM 
                            mpo_tbl AS mpo
                        LEFT JOIN 
                            w_supplierlist AS supplier ON mpo.supplierID = supplier.supplierID
                        LEFT JOIN 
                            mpo_base AS base ON mpo.mpoID = base.mpoID
                        LEFT JOIN 
                        (
                            SELECT 
                                baseID, 
                                MAX(timestamp) AS max_date_received
                            FROM 
                                mpo_datereceived_logs
                            GROUP BY 
                                baseID
                        ) AS latest_dates ON base.baseID = latest_dates.baseID
                        LEFT JOIN 
                mpo_datereceived_logs AS received_logs ON base.baseID = received_logs.baseID AND latest_dates.max_date_received = received_logs.timestamp
                WHERE
                base.status = ?';
            
            
            
                $queryResult = $this->db->rawQuery($sqlQuery, Array($target));
                if($queryResult){
                    $response = [
                        'status' => 'success',
                        'message' => 'Data has been fetch successfully',
                        'categoryData' => $queryResult
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
        }
        else if ($payload['id'])
        {
            if (empty($payload['id'])) {
                $response = ['status' => 'fail', 'message' => 'Invalid or empty IDs array.'];
                echo json_encode($response);
                exit;
            }
            $getData = $this->db->where('categoryID', $payload['id'])->get('mpo_tbl');

            if($getData){
                // $categoryData = []; // Initialize an empty array to hold the fetched data

                // foreach ($getData as $record) {
                //     $categoryData[] = [
                //         'mpoID' => $record['mpoID'],
                //         'personelID' => $record['personelID'],
                //         'supplierID' => $record['supplierID'],
                //         'categoryID' => $record['categoryID'],
                //         'mpo_date' => $record['mpo_date'],
                //         'mpo_no' => $record['mpo_no'],
                //         'client_reference_no' => $record['client_reference_no'],
                //         'jo_reference_no' => $record['jo_reference_no'],
                //         'delivery_date' => $record['delivery_date'],
                //         'delivery_address' => $record['delivery_address'],
                //         'item' => $record['item'],
                //         'product_name' => $record['product_name'],
                //         'description' => $record['description'],
                //         'quantity' => $record['quantity'],
                //         'total' => $record['total'],
                //     ];
                // }
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been fetch succesfully',
                    'categoryData' => $getData,
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
        }else{
            $response = [
                'status' => 'error',
                'message' => 'Invalid payload.',
            ];
            echo json_encode($response);
            exit;
        }
    }
    
    
    
    public function httpPost($payload)
    {
        $requiredFields = ['title', 'description', 'procedure']; // Update field names here
    
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field]) || empty($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing or empty required field.'];
                echo json_encode($response);
                exit;
            }
        }
    
        $insertData = [
            "title" => $payload['title'],
            "description" => $payload['description'],
            "procedure" => $payload['procedure'],
        ];
        
        $addRecord = $this->db->insert("w_category", $insertData);
    
        if ($addRecord) {
            $response = [
                'status' => 'success',
                'message' => 'Add Category Successfully.',
                'information' => [
                    "title" => $payload['title'],
                    "procedure" => $payload['procedure']
                ]
            ];
        } else {
            $response = ['status' => 'fail', 'message' => 'Failed to add category. Please try again.'];
        }
    
        echo json_encode($response);
        exit;
    }
    
    
    
    public function httpPut($ids, $payload)
    {

    }
    

    public function httpDelete($ids, $payload)
    {
        // Check if $ids is a valid array of IDs
        if (empty($ids)) {
            $response = ['status' => 'fail', 'message' => 'Invalid or empty IDs array.'];
            echo json_encode($response);
            exit;
        }
    
        $existingIDs = $this->db->where('categoryID', $ids)->getOne('w_category');
    
        if (!$existingIDs) {
            $response = ['status' => 'fail', 'message' => 'IDs not found in the database.'];
            echo json_encode($response);
            exit;
        }
    
        // Proceed with deletion
        $selectedData = $this->db->where('categoryID', $ids)->delete('w_category');
        if ($selectedData) {
            $response = [
                'status' => 'success',
                'message' => 'Deleted Successfully.',
            ];
            echo json_encode($response);
            exit;
        } else {
            $response = ['status' => 'fail', 'message' => 'IDs not found in the database.'];
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

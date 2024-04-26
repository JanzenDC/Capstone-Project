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
        else if($payload['get'] == 'companylogo'){
            $getData = $this->db->where('isAdmin', 1)->getOne('personel_tbl');

            if($getData){
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been fetch succesfully',
                    'isAdmin' => $getData,
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
        else if ($payload['get'] == 'mpo') {
            $mpodata = $this->db->get('mpo_tbl');
            $maxMPOID = 0;
            foreach ($mpodata as $row) {
                $mpoID = $row['mpoID'];
                if ($mpoID > $maxMPOID) {
                    $maxMPOID = $mpoID;
                }
            }

            $nextMPOID = $maxMPOID + 1;
            $maxStartingNo = $this->db->rawQuery("SELECT MAX(startingNo) AS maxStartingNo FROM mpo_starting_date");
            $response = [
                'status' => 'success',
                'message' => 'Data has been fetched successfully',
                'nextMPOID' => $nextMPOID,
                'nextMPOStartingNo' => $maxStartingNo,
            ];
            echo json_encode($response);
            exit;
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
        }else if($payload['get'] == 'datelogs'){
            if (empty($payload['id'])) {
                $response = ['status' => 'fail', 'message' => 'Invalid payload.'];
                echo json_encode($response);
                exit;
            }
            // $dateLogs = $this->db->where('mpoID', $payload['id'])->get('mpo_datereceived_logs');
            $selectedID = $payload['id'];
            $query = 'SELECT mpo_datereceived_logs.*, mpo_base.item_name
            FROM mpo_datereceived_logs
            INNER JOIN mpo_base ON mpo_datereceived_logs.baseID = mpo_base.baseID
            WHERE mpo_datereceived_logs.mpoID = ?
            ORDER BY mpo_datereceived_logs.date_received DESC';
  

            $results = $this->db->rawQuery($query, [$selectedID]);
            if ($results) {
                $response = [
                    'status' => 'success', 
                    'message' => 'Fetch Data',
                    'dateLogs' => Array($results)
                ];
                echo json_encode($response);
                exit;
            }
        }
        else if($payload['get'] == 'targetCategory'){
            $targetCategory = $payload['id'];
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
                    MAX(date_received) AS max_date_received
                FROM 
                    mpo_datereceived_logs
                GROUP BY 
                    baseID
            ) AS latest_dates ON base.baseID = latest_dates.baseID
            LEFT JOIN 
            mpo_datereceived_logs AS received_logs ON base.baseID = received_logs.baseID AND latest_dates.max_date_received = received_logs.date_received
            WHERE 
                mpo.categoryID = ?';

            $queryResult = $this->db->rawQuery($sqlQuery, Array($targetCategory));
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
        }else {
            $response = [
                'status' => 'fail',
                'message' => 'Failed to fetch data.',
            ];
            echo json_encode($response);
            exit;
        }
    }



    public function httpPost($payload)
    {
        $mpodata = $this->db->get('mpo_tbl');
        $maxMPOID = 0;
        foreach ($mpodata as $row) {
            $mpoID = $row['mpoID'];
            if ($mpoID > $maxMPOID) {
                $maxMPOID = $mpoID;
            }
        }
        $nextMPOID = $maxMPOID + 1;
        
        //get supplier id
        $supplierID = $this->db->where('supplier_name', $_POST['supplierValue'])->getOne('w_supplierlist');
        $categoryID = $this->db->where('title', $_POST['categories'])->getOne('w_category');
        $personnel = $this->db->where('isAdmin', '1')->getOne('personel_tbl');
        
        if ($supplierID) {
            $insertData = [
                'mpoID' => $nextMPOID,
                'supplierID' => $supplierID['supplierID'],
                'categoryID' => $categoryID['categoryID'],
                'mpo_ref_no' => $_POST['mpo_ref'],
                'date_purchased' => $_POST['date_purchased'],
                'client_ref_no' => $_POST['client_ref'],
                'w_o_ref_no' => $_POST['wo_ref'],
                // 'delivery_date' => $_POST['delivery_date'],
                'delivery_address' => $personnel['address'],
                'supplier_address' => $_POST['supplierAddress'],
                'company_address' => $personnel['address'],
                'total' => $_POST['subtotal'],
                'delivery_charge' => $_POST['delivery_charge'],
                'discount' => $_POST['discount_value'],
                'other_costs' => $_POST['other_cost'],
                'vat' => $_POST['tax_vat'],
                'total_amount' => $_POST['total'],
                'notes_instructions' => $_POST['notes_instructions'],
                'services' => $_POST['services'],
            ];
            $test = $this->db->insert('mpo_tbl', $insertData);
            if($test){
              if (isset($_POST['products']) && is_array($_POST['products'])) {
                $insertedProducts = [];
                foreach ($_POST['products'] as $productJSON) {
                    $productData = json_decode($productJSON, true);
                    if ($productData !== null) { 
                        $requiredFields = ['product', 'description', 'quantity', 'unit', 'unit_price', 'total'];
                        $missingFields = array_diff($requiredFields, array_keys($productData));
                
                
                        $productDataToInsert = [
                            'mpoID' => $nextMPOID,
                            'item_name' => $productData['product'],
                            'description' => $productData['description'],
                            'quantity' => $productData['quantity'],
                            'unit' => $productData['unit'],
                            'unit_price' => $productData['unit_price'],
                            'subtotal' => $productData['total'],
                        ];
                        $test = $this->db->insert('mpo_base', $productDataToInsert);
                        $insertedProducts[] = $productDataToInsert;
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "products" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }                            
                $response = [
                  'status' => 'success',
                  'message' => 'Inserted succesfully',
                  'info' => $insertData,
                ];
                echo json_encode($response);
                exit;
              } else {
                  $response = [
                      'status' => 'fail',
                      'message' => 'Error: Missing or invalid "products" data.',
                  ];
                  echo json_encode($response);
                  exit;
              }
              $response = [
                'status' => 'success',
                'message' => 'Inserted succesfully'
              ];
              echo json_encode($response);
              exit;
            }
        }else{
          $response = [
            'status' => 'fail',
            'message' => 'No Data'
          ];
          echo json_encode($response);
          exit;
        }      
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


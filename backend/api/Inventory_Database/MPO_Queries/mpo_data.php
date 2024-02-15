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
            mpo_tbl.total,
            mpo_tbl.delivery_charge,
            mpo_tbl.discount,
            mpo_tbl.other_costs,
            mpo_tbl.total_amount,
            mpo_tbl.notes_instructions,
            mpo_tbl.prepared_by,
            mpo_tbl.approved_by,
            w_supplierlist.supplierID,
            w_supplierlist.supplier_name
            FROM mpo_tbl
            LEFT JOIN w_supplierlist ON mpo_tbl.supplierID = w_supplierlist.supplierID';
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
            if ($mpodata) {
                $maxMPOID = 0;
                foreach ($mpodata as $row) {
                    $mpoID = $row['mpoID'];
                    if ($mpoID > $maxMPOID) {
                        $maxMPOID = $mpoID;
                    }
                }

                $nextMPOID = $maxMPOID + 1;

                $response = [
                    'status' => 'success',
                    'message' => 'Data has been fetched successfully',
                    'nextMPOID' => $nextMPOID,
                ];
                echo json_encode($response);
                exit;
            } else {
                $response = [
                    'status' => 'fail',
                    'message' => 'There is no data here.',
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
        $getUser = $this->db->where('email', $payload['personnel_Email'])->getOne('personel_tbl');
        if($getUser){
            $selectedCategory = $payload['selectedCategory'];
            $category = $this->db->where('title',  $selectedCategory)->getOne('w_category');

            if($category){
                $supplierfetch = $this->db->where('supplier_name', $payload['selectedSupplier'])->getOne('w_supplierlist');
                if($supplierfetch){
                    $isertData = [
                        'mpoID' => $nextMPOID,
                        'categoryID' => $category['categoryID'],
                        'supplierID' => $supplierfetch['supplierID'],
                        'personelID' => $getUser['personelID'],
                        'company_address' => $payload['company_address'],
                        'mpo_ref_no' => $payload['mpo_ref'],
                        'date_purchased' => $payload['date_purchased'],     
                        'client_ref_no' => $payload['client_ref'],
                        'w_o_ref_no' => $payload['wo_purchased'],
                        'delivery_date' => $payload['delivery_date_val'],
                        'delivery_address' => $payload['delivery_add_val'],   
                        'supplier_address' => $payload['supplier_address'],
                        'delivery_charge' => $payload['deliver_charge'],
                        'discount' => $payload['discount'],
                        'vat' => $payload['vat'], //need data
                        'other_costs' => $payload['other_cost'],
                        'total_amount' => $payload['total_amount'],
                        'notes_instructions' => $payload['notes_instructions'],
                        'prepared_by' => $payload['prepareSig'],
                        'approved_by' => $payload['approveSig'],
                    ];
                    $dataHolder = $this->db->insert('mpo_tbl', $isertData);
    
                    if ($dataHolder) {
                        $insertedProducts = [];
                        foreach ($payload['products'] as $product) {
                            
                            $discount = isset($product['sdiscount']) ? floatval($product['sdiscount']) : 0;

                            // Prepare product data for insertion
                            $productData = [
                                'mpoID' => $nextMPOID,
                                'item_name' => $product['sproduct'],
                                'description' => $product['sdescription'],
                                'quantity' => $product['squantity'],
                                'unit' => $product['sunit'],
                                'unit_price' => $product['sunitprice'],
                                'discounts' => $discount,
                                'subtotal' => $product['stotal'],
                            ];
                            $test = $this->db->insert('mpo_base', $productData);
                            $insertedProducts[] = $productData;

                        }
                        $response = [
                            'status' => $productData,
                        ];
                        echo json_encode($response);
                        exit;
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Fail to insert data into MPO_TBL.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response = [
                        'status' => 'fail',
                        'message' => 'Fail there is no supplier data.',
                    ];
                    echo json_encode($response);
                    exit;
                }

                
            }else{
                $response = [
                    'status' => 'fail',
                    'message' => 'There is no category.',
                ];
                echo json_encode($response);
                exit;      
            }
        }else{
            $response = [
                'status' => 'fail',
                'message' => 'There is no email.',
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


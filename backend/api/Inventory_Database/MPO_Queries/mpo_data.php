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
                base.item_name,
                base.quantity,
                base.unit,
                base.quantity_balance,
                base.unit_price,
                base.status,
                base.discounts,
                base.subtotal
            FROM 
                mpo_tbl AS mpo
            LEFT JOIN 
                w_supplierlist AS supplier ON mpo.supplierID = supplier.supplierID
            LEFT JOIN 
                mpo_base AS base ON mpo.mpoID = base.mpoID;
            ';
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
        $getUser = $this->db->where('email', $_POST['personnel_Email'])->getOne('personel_tbl');
        if($getUser){
            $selectedCategory = $_POST['selectedCategory'];
            $category = $this->db->where('title',  $selectedCategory)->getOne('w_category');
            if($category){
                $supplierfetch = $this->db->where('supplier_name', $_POST['selectedSupplier'])->getOne('w_supplierlist');
                if($supplierfetch){
                    $uploadDir = 'C:/xampp/htdocs/Capstone-Project/WeaveManila-Project/public/Important_Images/';
                    if (!isset($_FILES['uploadPhoto'])) {
                        $file_one = 'default_logo.png'; // Set default logo image path
                        $file_value = 'default_logo.png';
                    } else {
                        $file_value = basename($file_one['name']);
                        $file_one = $_FILES['uploadPhoto'];
                        $uploadPath_one = $uploadDir . basename($file_one['name']);
                        if (move_uploaded_file($file_one['tmp_name'], $uploadPath_one)) {
                            $response = [
                                'status' => 'success',
                                'message' => 'Success moving the image to designated path.',
                            ];
                        } else {
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error uploading file one.',
                            ];
                            echo json_encode($response);
                        }
                    }
                    
                    $file_two = isset($_FILES['uploadPreparedName']) ? $_FILES['uploadPreparedName'] : '';
                    $file_three = isset($_FILES['uploadApproveName']) ? $_FILES['uploadApproveName'] : '';
                    $filetwo_value = basename($file_two['name']);
                    $filethree_value = basename($file_three['name']);
                    $isertData = [
                        'mpoID' => $nextMPOID,
                        'categoryID' => $category['categoryID'],
                        'supplierID' => $supplierfetch['supplierID'],
                        'personelID' => $getUser['personelID'],
                        'company_address' => $_POST['company_address'],
                        'mpo_ref_no' => $_POST['mpo_ref'],
                        'date_purchased' => $_POST['date_purchased'],     
                        'client_ref_no' => $_POST['client_ref'],
                        'w_o_ref_no' => $_POST['wo_purchased'],
                        'delivery_date' => $_POST['delivery_date_val'],
                        'delivery_address' => $_POST['delivery_add_val'],   
                        'supplier_address' => $_POST['supplier_address'],
                        'delivery_charge' => $_POST['deliver_charge'],
                        'discount' => $_POST['discount'],
                        'vat' => $_POST['vat'],
                        'other_costs' => $_POST['other_cost'],
                        'total_amount' => $_POST['total_amount'],
                        'notes_instructions' => $_POST['notes_instructions'],
                        'prepared_by' => $_POST['prepareSig'],
                        'approved_by' => $_POST['approveSig'],
                        'file_logo' => $file_value,
                        'file_esignaturep' => $filetwo_value,
                        'file_esignaturea' => $filethree_value,
                    ];
                    $dataHolder = $this->db->insert('mpo_tbl', $isertData);

// Query that will holds the picture don't galaw galaw this area
                    // Upload file_two
                    $uploadPath_two = $uploadDir . basename($file_two['name']);
                    if (move_uploaded_file($file_two['tmp_name'], $uploadPath_two)) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Success moving the image to designated path.',
                        ];
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error uploading file two.',
                        ];
                        echo json_encode($response);
                    }

                    // Upload file_three
                    $uploadPath_three = $uploadDir . basename($file_three['name']);
                    if (move_uploaded_file($file_three['tmp_name'], $uploadPath_three)) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Success moving the image to designated path.',
                        ];
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error uploading file three.',
                        ];
                        echo json_encode($response);
                    }


                    if ($dataHolder) {
                        if (isset($_POST['products']) && is_array($_POST['products'])) {
                            $insertedProducts = [];
                            foreach ($_POST['products'] as $productJSON) {
                                $productData = json_decode($productJSON, true);
                                if ($productData !== null) { 
                                    if (isset($productData['sproduct'], $productData['sdescription'], $productData['squantity'], $productData['sunit'], $productData['sunitprice'], $productData['stotal'])) {
                                        $discount = isset($productData['sdiscount']) ? floatval($productData['sdiscount']) : 0;
                            
                                        $productDataToInsert = [
                                            'mpoID' => $nextMPOID,
                                            'item_name' => $productData['sproduct'],
                                            'description' => $productData['sdescription'],
                                            'quantity' => $productData['squantity'],
                                            'unit' => $productData['sunit'],
                                            'unit_price' => $productData['sunitprice'],
                                            'discounts' => $discount,
                                            'subtotal' => $productData['stotal'],
                                        ];
                                        $test = $this->db->insert('mpo_base', $productDataToInsert);
                                        $insertedProducts[] = $productDataToInsert;
                                    } else {
                                        echo "Error: Missing required fields for product.";
                                        exit;
                                    }
                                } else {
                                    echo "Error: Failed to decode product JSON: $productJSON";
                                    exit;
                                }
                            }
                            $response = [
                                'status' => 'success',
                            ];
                            echo json_encode($response);
                            exit;
                        } else {
                            echo "Error: Missing or invalid 'products' data.";
                            exit;
                        }
                    }else {
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


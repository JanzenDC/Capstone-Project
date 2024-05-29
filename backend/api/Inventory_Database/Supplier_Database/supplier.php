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
        if ($payload['get'] === 'removedata') {
            $categoryData = $this->db->get('supplier_restorepoint');
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
        if ($payload['get'] === 'supplier') {
          if(empty($payload['id'])){
            $response = ['status' => 'fail', 'message' => 'Empty payload ID.'];
            echo json_encode($response);
            exit;
          }
          $getSupplier = $this->db->where('supplierID', $payload['id'])->getOne('w_supplierlist');
          if($getSupplier){
            $getSupplierItem = $this->db->where('supplierID', $payload['id'])->get('w_supplierlist_item');
            $response = [
              'status' => 'success',
              'message' => 'Fetch succesfully',
              'supplierData' => $getSupplier,
              'itemData' => $getSupplierItem,
            ];
            echo json_encode($response);
            exit;

          }else{
            $response = ['status' => 'fail', 'message' => 'Supplier not exist'];
            echo json_encode($response);
            exit;
          }
        }
        if ($payload['get'] === 'item') {
            if(empty($payload['id'])){
                $response = ['status' => 'fail', 'message' => 'Empty payload ID.'];
                echo json_encode($response);
                exit;
            }
            $getSupplier = $this->db->where('supplierID', $payload['id'])->getOne('w_supplierlist');
            if($getSupplier){
              $get = $this->db->where('supplierID', $payload['id'])->get('w_supplierlist_item');

                $response = [
                  'status' => 'success', 
                  'message' => 'Successfully fetch data.',
                  'itemData' => $get,
                  'supplierData'=> $getSupplier
                ];
                echo json_encode($response);
                exit;
            }else{
                $response = ['status' => 'fail', 'message' => 'Invalid Data.'];
                echo json_encode($response);
                exit;
            }
        }
        if ($payload['get'] === 'supplierGet') {
          if(empty($payload['supplierGet'])){
            $response = ['status' => 'fail', 'message' => 'Empty payload.'];
            echo json_encode($response);
            exit;
          }
          $getSupplier = $this->db->where('category', $payload['supplierGet'])->get('w_supplierlist');
          if($getSupplier){
            $response = [
              'status' => 'success',
              'message' => 'Fetch succesfully',
              'supplierData' => $getSupplier,
            ];
            echo json_encode($response);
            exit;

          }else{
            $response = ['status' => 'fail', 'message' => 'Supplier not exist'];
            echo json_encode($response);
            exit;
          }
        }
        if ($payload['get'] === 'address') {
          if(empty($payload['addressget'])){
            $response = ['status' => 'fail', 'message' => 'Empty payload.'];
            echo json_encode($response);
            exit;
          }
          $getSupplier = $this->db->where('supplier_name', $payload['addressget'])->getOne('w_supplierlist');
          if($getSupplier){
            $getSupplierItem = $this->db->where('supplierID', $getSupplier['supplierID'])->get('w_supplierlist_item');
            $response = [
              'status' => 'success',
              'message' => 'Fetch succesfully',
              'supplierData' => $getSupplier,
              'informations' => $getSupplierItem,
            ];
            echo json_encode($response);
            exit;

          }else{
            $response = ['status' => 'fail', 'message' => 'Supplier not exist'];
            echo json_encode($response);
            exit;
          }
        }
        if ($payload['get'] === 'itemData') {
            if(empty($payload['id'])){
                $response = ['status' => 'fail', 'message' => 'Empty payload.'];
                echo json_encode($response);
                exit;
            }
            $getItem = $this->db->where('itemID', $payload['id'])->getOne('w_supplierlist_item');
            if($getItem){
              $response = [
                'status' => 'success',
                'message' => 'Successfully fetch data.',
                'itemData' => [
                  'itemID' => $getItem['itemID'],
                  'supplierID' => $getItem['supplierID'],
                  'itemName' => $getItem['itemName'],
                  'description' => $getItem['description'],
                  'unit' => $getItem['unit'],
                  'unit_price' => $getItem['unit_price'],
                ],
              ];
              echo json_encode($response);
              exit;
            }else{
              $response = [
                'status' => 'fail',
                'message' => 'Failed fetch data.',
              ];
              echo json_encode($response);
              exit;
            }
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

        $getData = $this->db->where('supplier_name', $payload['supplier_Name'])->getOne('w_supplierlist');

        if (!$getData) {
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
        } else {
            $response = ['status' => 'fail', 'message' => 'Data already exists. Cannot add duplicate entry.'];
            echo json_encode($response);
            exit;
        }


    }



    public function httpPut($ids, $payload)
    {
        // Check if $ids is a valid array of IDs
        if (empty($ids)) {
            $response = ['status' => 'fail', 'message' => 'Invalid or empty IDs array.'];
            echo json_encode($response);
            exit;
        }

        $requiredFields = ['supplier_Name','supplier_Address','supplier_ContactName','supplier_Cp','supplier_Email',];
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
        }
        $supplierTarget = $this->db->where("supplierID", $ids)->getOne('w_supplierlist');

        if ($supplierTarget === null) {
            $response = ['status' => 'fail', 'message' => 'Invalid target id.'];
            echo json_encode($response);
            exit;
        }
        $updateDatas = [
            'supplier_name' => $payload['supplier_Name'],
            'contact_person' => $payload['supplier_ContactName'],
            'address' => $payload['supplier_Address'],
            'contact' => $payload['supplier_Cp'],
            'email' => $payload['supplier_Email'],
        ];
        $addData = $this->db->where('supplierID', $ids)->update('w_supplierlist', $updateDatas);
        if($addData){
            $response = ['status' => 'success', 'message' => 'Successfully update supplier information.'];
            echo json_encode($response);
            exit;
        }else{
            $response = ['status' => 'fail', 'message' => 'Invalid target id.'];
            echo json_encode($response);
            exit;
        }

    }


    public function httpDelete($ids, $payload)
    {
        if (!isset($payload['selectedIds']) || empty($payload['selectedIds'])) {
            $response = ['status' => 'fail', 'message' => 'Invalid or empty selected IDs array.'];
            echo json_encode($response);
            exit;
        }

        $requiredFields = ['selectedIds']; // Update field names here
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
        }

        $existingData = $this->db->where('personelID', $ids)->getOne('personel_tbl');
        if ($existingData) {
            if (strtolower($existingData['position']) === 'owner') {
                foreach ($payload['selectedIds'] as $id) {
                    $recordData = $this->db->where('supplierID', $id)->getOne('w_supplierlist');
                    $data = [
                        'supplierID' => $recordData['supplierID'],
                        'supplier_name' => $recordData['supplier_name'],
                        'contact_person' => $recordData['contact_person'],
                        'address' => $recordData['address'],
                        'contact' => $recordData['contact'],
                        'email' => $recordData['email'],
                    ];
                    $insertData = $this->db->insert('supplier_restorepoint', $data);

                    $deleteData = $this->db->where('supplierID', $id)->delete('w_supplierlist');
                    if (!$insertData || !$deleteData) {
                        $response = ['status' => 'fail', 'message' => 'Failed to delete records.'];
                        echo json_encode($response);
                        exit;
                    }
                }
                $response = [
                    'status' => 'success',
                    'message' => 'Records deleted successfully.',
                ];
                echo json_encode($response);
                exit;
            } else {
                $response = [
                    'status' => 'fail',
                    'message' => 'You do not have permission to remove supplier.',
                ];
                echo json_encode($response);
                exit;
            }
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'No data found in the database.',
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
            $api->httpDelete($ids,$received_data);
            break;
    }

}

?>


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

    }


    public function httpPost($payload)
    {
      if($_POST['type'] === '1'){
        $getDataOne = $this->db->where('supplier_name',$_POST['supplier_Name'])->getOne('w_supplierlist');
        if($getDataOne){
          $response = [
              'status' => 'fail',
              'message' => 'Error: Supplier already exist.',
          ];
          echo json_encode($response);
          exit;
        }else{
            if (!empty($_POST['suppUnit']) && !empty($_POST['suppZipcode']) && !empty($_POST['suppStreet'])) {
                $fulladdress = $_POST['supplierAddressValue'] . "," . $_POST['selectedProvince'] . "," . $_POST['selectedCity'] . "," . $_POST['selectedBarangay'] . "," . $_POST['suppUnit'] . "," . $_POST['suppStreet'] . "," . $_POST['suppZipcode'];
            } else {
                $fulladdress = $_POST['supplierAddressValue'] . "," . $_POST['selectedProvince'] . "," . $_POST['selectedCity'] . "," . $_POST['selectedBarangay'];
            }

          $dataInsert = [
            'supplier_name' => $_POST['supplier_Name'],
            'contact_person' => $_POST['supplier_ContactName'],
            'address' => $fulladdress,
            'email' => $_POST['supplier_Email'],
            'category' => $_POST['selectedCategory'],
          ];
          $insertedData = $this->db->insert('w_supplierlist', $dataInsert);
          if ($insertedData) {
            $getData = $this->db->where('supplier_name', $_POST['supplier_Name'])->getOne('w_supplierlist');
            if ($getData) {
                $insertErrors = [];
                if (isset($_POST['items_list']) && is_array($_POST['items_list'])) {
                    foreach ($_POST['items_list'] as $productJSON) {
                        $itemsData = json_decode($productJSON, true);
                        if ($itemsData !== null) {
                            $requiredFields = ['item', 'description', 'unit', 'unit_price'];
                            $missingFields = array_diff($requiredFields, array_keys($itemsData));
                            
                            if (empty($missingFields) && !empty($itemsData['item']) && !empty($itemsData['description']) && !empty($itemsData['unit']) && !empty($itemsData['unit_price'])) {
                                $items_add = [
                                    'supplierID' => $getData['supplierID'],
                                    'itemName' => $itemsData['item'],
                                    'description'  => $itemsData['description'],
                                    'unit'  => $itemsData['unit'],
                                    'unit_price'  => $itemsData['unit_price'],
                                ];
                                
                                $test = $this->db->insert('w_supplierlist_item', $items_add);
                                if (!$test) {
                                    $insertErrors[] = 'Error: Cannot insert data for item: ' . $itemsData['item'];
                                }
                            } else {
                                $insertErrors[] = 'Error: Missing or invalid fields in data for item: ' . $itemsData['item'];
                            }
                        } else {
                            $insertErrors[] = 'Error: Missing or invalid data for item.';
                        }
                    }
                } else {
                    $insertErrors[] = 'Error: No items list provided.';
                }
                $response = [
                    'status' => 'success',
                    'message' => 'Successfully added supplier.',
                ];
    
                // if (empty($insertErrors)) {
                //     $response = [
                //         'status' => 'success',
                //         'message' => 'All items inserted successfully.',
                //     ];
                // } else {
                //     $response = [
                //         'status' => 'fail',
                //         'message' => 'Errors occurred during insertion.',
                //         'errors' => $insertErrors,
                //     ];
                // }
                echo json_encode($response);
                exit;
            } else {
                $response = [
                    'status' => 'fail',
                    'message' => 'Error: Failed to retrieve data.',
                ];
                echo json_encode($response);
                exit;
            }
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'Error: Failed to insert data.',
            ];
            echo json_encode($response);
            exit;
        }
        
        }
      }
      if($_POST['type'] === '2'){
        $getData = $this->db->where('supplier_name', $_POST['supplier_Name'])->getOne("w_supplierlist");
        // Check if $_POST['suppUnit'], $_POST['suppZipcode'], $_POST['suppStreet'] exist
        if (isset($_POST['suppUnit']) && isset($_POST['suppZipcode']) && isset($_POST['suppStreet'])) {
            // If they exist, include them in the full address
            $fulladdress = $_POST['selectedRegion'] . "," . $_POST['selectedProvince'] . "," . $_POST['selectedCity'] . "," . $_POST['selectedBarangay'] . "," . $_POST['suppUnit'] . "," . $_POST['suppStreet'] . "," . $_POST['suppZipcode'];
        } else {
            // If they don't exist, exclude them from the full address
            $fulladdress = $_POST['selectedRegion'] . "," . $_POST['selectedProvince'] . "," . $_POST['selectedCity'] . "," . $_POST['selectedBarangay'];
        }

        $dataInsert = [
            'supplier_name' => $_POST['supplier_Name'],
            'contact_person' => $_POST['supplier_ContactName'],
            'address' => $fulladdress,
            'email' => $_POST['supplier_Email'],
            'category' => $_POST['selectedCategory'],
          ];
          $insertedData = $this->db->where('supplierID', $getData['supplierID'])->update('w_supplierlist',$dataInsert);
          if ($insertedData) {
            foreach ($_POST['items_list'] as $productJSON) {
                $itemsData = json_decode($productJSON, true);
                if ($itemsData !== null) {
                    $requiredFields = ['item', 'description', 'unit', 'unit_price'];
                    $missingFields = array_diff($requiredFields, array_keys($itemsData));
                    
                    if (empty($missingFields) && !empty($itemsData['item']) && !empty($itemsData['description']) && !empty($itemsData['unit']) && !empty($itemsData['unit_price'])) {
                        $getDataItems = $this->db->where('itemID',  $itemsData['supplierID'])->get('w_supplierlist_item');
                        if($getDataItems){
                          $items_add = [
                            'itemName' => $itemsData['item'],
                            'description'  => $itemsData['description'],
                            'unit'  => $itemsData['unit'],
                            'unit_price'  => $itemsData['unit_price'],
                          ];
                          
                          $test = $this->db->where('itemID', $itemsData['supplierID'])->update('w_supplierlist_item', $items_add);
                          if (!$test) {
                              $insertErrors[] = 'Error: Cannot insert data for item: ' . $itemsData['item'];
                          }
                        }else{
                          $items_add = [
                            'supplierID' => $getData['supplierID'],
                            'itemName' => $itemsData['item'],
                            'description'  => $itemsData['description'],
                            'unit'  => $itemsData['unit'],
                            'unit_price'  => $itemsData['unit_price'],
                          ];
                          
                          $test = $this->db->insert('w_supplierlist_item', $items_add);
                          if (!$test) {
                              $insertErrors[] = 'Error: Cannot insert data for item: ' . $itemsData['item'];
                          }
                        }
              
                    } else {
                        $insertErrors[] = 'Error: Missing or invalid fields in data for item: ' . $itemsData['item'];
                    }
                } else {
                    $insertErrors[] = 'Error: Missing or invalid data for item.';
                }
              }            
          } 
          else {
            $response = [
                'status' => 'fail',
                'message' => 'Error: Invalid supplier cannot update.',
            ];
            echo json_encode($response);
            exit;
          }
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


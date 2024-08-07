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
        if (isset($_POST['products']) && is_array($_POST['products'])) {
            $insertedProducts = [];
            foreach ($_POST['products'] as $productJSON) {
                $productData = json_decode($productJSON, true);
                if ($productData !== null) { 
                    $selectedData = $this->db->where('baseID', $productData['sqlid'])->getOne('mpo_base');
                    // add validation first if $productData['sreceived']  cannot be more than handler_received
                    // $productData['sreceived'] - handler_received = $calcualte
                    // the quantity_received and quantity_balance must have update their data +$productData['sreceived']
                    if ($productData['sreceived'] <= $selectedData['handler_received']) {
                        if($selectedData){
                            $calculate = $selectedData['handler_received'] - $productData['sreceived'];
                            $newQuantityReceived = $selectedData['quantity_received'] + $productData['sreceived'];
                            if ($newQuantityReceived == $selectedData['quantity']) {
                                $status = 2;
                            } elseif ($newQuantityReceived > 0) {
                                $status = 1;
                            } else {
                                $status = 0;
                            }
                            $data = [
                                'quantity_received' => $selectedData['quantity_received'] + $productData['sreceived'],
                                'quantity_balance' => $selectedData['quantity_balance'] + $productData['sreceived'],
                                'status' => $status,
                                'handler_received' => $calculate,
                            ];
                            $result = $this->db->where('baseID', $productData['sqlid'])->update('mpo_base', $data);
                            if ($productData['sstatus'] != $selectedData['status'] || $productData['sreceived'] != $selectedData['quantity_received']) {
                              $params = [$selectedData['baseID'], 2];
                              $users = $this->db->rawQuery("SELECT * FROM mpo_datereceived_logs WHERE baseID = ? AND status = ?", $params);
    
                              if (!$users) {
          
                                  $date_received = isset($_POST['date_received']) ? $_POST['date_received'] : null;
                                  $status = isset($productData['sstatus']) ? $productData['sstatus'] : null;
    
                                  $dataInsert = [
                                      'baseID' => $selectedData['baseID'],
                                      'mpoID' => $selectedData['mpoID'],
                                      'date_received' => $date_received,
                                      'status' => $status,
                                      'received' => $productData['sreceived']
                                  ];
    
                                  $result = $this->db->insert('mpo_datereceived_logs', $dataInsert);
                                  $insertedProducts[] = $dataInsert;
                                  if ($result) {
                                      $response = [
                                          'status' => 'success',
                                          'message' => 'Data inserted successfully.',
                                      ];
                                  } else {
                                      $response = [
                                          'status' => 'error',
                                          'message' => 'Failed to insert data.',
                                      ];
                                  }
                              } else {
                                  $response = [
                                      'status' => 'success',
                                      'message' => "Data already exists for the given baseID and status.",
                                  ];
                              }
                            }
                        }else{
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: Invalid target MPO product ID.',
                            ];
                            echo json_encode($response);
                            exit;
                        }
                    }
                    else{
                        $response = [
                            'status' => 'fail',
                            'message' => "Error: Invalid data you can input between 1-" . $selectedData['handler_received'],
                        ];
                        echo json_encode($response);
                        exit;
                    }
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


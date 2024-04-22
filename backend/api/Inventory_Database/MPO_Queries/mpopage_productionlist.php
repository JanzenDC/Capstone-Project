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
                    if($selectedData){
                        $data = [
                            'quantity_received' => $productData['sreceived'],
                            'quantity_balance' => $productData['sreceived'],
                            'status' => $productData['sstatus'],
                        ];
                        $result = $this->db->where('baseID', $productData['sqlid'])->update('mpo_base', $data);
                        if ($productData['sstatus'] != $selectedData['status'] || $productData['sreceived'] != $selectedData['quantity_received']) {
                          // Check if data already exists for the baseID and status '2'
                          $params = [$selectedData['baseID'], 2];
                          $users = $this->db->rawQuery("SELECT * FROM mpo_datereceived_logs WHERE baseID = ? AND status = ?", $params);

                          // If no existing data found, insert new data
                          if (!$users) {
      
                              $date_received = isset($_POST['date_received']) ? $_POST['date_received'] : null;
                              $status = isset($productData['sstatus']) ? $productData['sstatus'] : null;

                              // Prepare data for insertion
                              $dataInsert = [
                                  'baseID' => $selectedData['baseID'],
                                  'mpoID' => $selectedData['mpoID'],
                                  'date_received' => $date_received,
                                  'status' => $status,
                                  'received' => $productData['sreceived']
                              ];

                              // Insert new data
                              $result = $this->db->insert('mpo_datereceived_logs', $dataInsert);
                              $insertedProducts[] = $dataInsert;
                              if ($result) {
                                  // Data inserted successfully
                                  $response = [
                                      'status' => 'success',
                                      'message' => 'Data inserted successfully.',
                                  ];
                              } else {
                                  // Handle insertion failure
                                  $response = [
                                      'status' => 'error',
                                      'message' => 'Failed to insert data.',
                                  ];
                              }
                          } else {
                              // If there is existing data, return a message without inserting new data
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


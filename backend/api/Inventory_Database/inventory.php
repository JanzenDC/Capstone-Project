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
            }
        }
        else if ($payload['id'])
        {
            if (empty($payload['id'])) {
                $response = ['status' => 'fail', 'message' => 'Invalid or empty IDs array.'];
                echo json_encode($response);
                exit;
            }
            $getData = $this->db->where('mpoID')->getOne('mpo_tbl');
            if($getData){
                $response = [
                    'status' => 'success',
                    'message' => 'Data has been fetch succesfully',
                    'categoryData' => [
                        
                    ],
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'message' => 'Invalid data.',
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

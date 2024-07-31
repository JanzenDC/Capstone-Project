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
        if (empty($payload['type'])) {
            $response = ['status' => 'fail', 'message' => 'Type field is empty.'];
            echo json_encode($response);
            exit;
        }
        if ($payload['type'] === '1') {
            $today = date('Y-m-d');
            $users = $this->db->where('date', $today)->orderBy('date', 'DESC')->get('audit_logs');
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];
            echo json_encode($response);
            exit;
        } else if ($payload['type'] === '2') {
            $currentDate = date('Y-m-d');
            $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
            $users = $this->db->rawQuery("SELECT * FROM audit_logs WHERE DATE(date) BETWEEN ? AND ?", array($sevenDaysAgo, $currentDate));
        
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];
            echo json_encode($response);
            exit;
        } else if ($payload['type'] === '3') {
            $currentDate = date('Y-m-d');
            $thirtydays = date('Y-m-d', strtotime('-30 days'));
            $users = $this->db->rawQuery("SELECT * FROM audit_logs WHERE DATE(date) BETWEEN ? AND ?", array($thirtydays, $currentDate));
        
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];
            echo json_encode($response);
            exit;
        } else if ($payload['type'] === '4') {
            $currentYear = date('Y');
            $users = $this->db->rawQuery("SELECT * FROM audit_logs WHERE YEAR(date) = ?", array($currentYear));
        
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];
            echo json_encode($response);
            exit;
        
        } else if ($payload['type'] === '5') {
            $lastYear = date('Y', strtotime('-1 year'));
            $users = $this->db->rawQuery("SELECT * FROM audit_logs WHERE YEAR(date) = ?", array($lastYear));
        
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];
            echo json_encode($response);
            exit;
        
        } else if ($payload['type'] === '6') {
            $startDate = $payload['startDate'];
            $endDate = $payload['endDate'];
        
            // Validate date formats and handle any necessary conversions
            $startDate = date('Y-m-d', strtotime($startDate));
            $endDate = date('Y-m-d', strtotime($endDate));
        
            // Build and execute the query for the custom date range
            $users = $this->db->rawQuery("SELECT * FROM audit_logs WHERE date BETWEEN ? AND ?", array($startDate, $endDate));
        
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];
            echo json_encode($response);
            exit;
        
        } else if ($payload['type'] === '7') {
            $users = $this->db->orderBy('date', 'DESC')->get('audit_logs');
        
            $response = [
                'status' => 'success',
                'message' => 'Fetch successful.',
                'informations' => [
                    'rows' => $users,
                ],
            ];
            echo json_encode($response);
            exit;
        
        }else {
            $response = [
                'status' => 'error',
                'message' => 'Invalid type specified.',
            ];
            echo json_encode($response);
            exit;
        }

    }
    
    
    public function httpPost($payload)
    {

    }
    
    
    public function httpPut($ids, $payload)
    {

    }

    public function httpDelete($payload)
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

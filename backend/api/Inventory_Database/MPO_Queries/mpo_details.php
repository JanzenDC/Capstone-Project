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
        if($payload['targetdata'] ==='moredata'){
            $getData = $this->db->where('mpoID', $payload['targetdatas'])->getOne('mpo_base');
            $getData3 = $this->db->where('mpoID', $payload['targetdatas'])->get('mpo_base');
            $getData2 = $this->db->where('mpoID', $getData['mpoID'])->get('mpo_segregate_tbl');
            // $target = $payload['targetdata'];
            // $sqlQuery = 'SELECT * FROM mpo_base AS b JOIN mpo_segregate_tbl AS s ON b.baseID = s.baseID WHERE b.baseID = ?';
            // $query = $this->db->rawQuery($sqlQuery, Array($target));
            if($getData){
                $response = [
                    'status' => 'success',
                    'message' => 'Success getting Data',
                    'information' => Array($getData),
                    'information2' => $getData2,
                    'information3' => $getData3,
                ];
                echo json_encode($response);
                exit;
            }else{
                $response = [
                    'status' => 'fail',
                    'message' => 'Failed to fetch data.',
                ];
                echo json_encode($response);
                exit;
            }
        }
        else if($payload['targetdata'] ==='onedata'){
          $getData = $this->db->where('baseID', $payload['targetdatas'])->getOne('mpo_base');
          $getData2 = $this->db->where('baseID', $getData['baseID'])->get('mpo_segregate_tbl');
          $getData3 = $this->db->where('mpoID', $payload['targetdatas'])->get('mpo_base');
          if($getData){
              $response = [
                  'status' => 'success',
                  'message' => 'Success getting Data',
                  'information' => Array($getData),
                  'information2' => $getData2,
                  'information3' => $getData3,
              ];
              echo json_encode($response);
              exit;
          }else{
              $response = [
                  'status' => 'fail',
                  'message' => 'Failed to fetch data.',
              ];
              echo json_encode($response);
              exit;
          }
        }
        else{
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


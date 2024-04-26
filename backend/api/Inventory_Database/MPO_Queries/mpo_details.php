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
            $getData4 = $this->db->where('mpoID', $payload['targetdatas'])->get('mpo_base');

            $getData3 = $this->db->where('mpoID', $payload['targetdatas'])->get('mpo_base');
            $getData2 = $this->db->where('mpoID', $getData['mpoID'])->get('mpo_segregate_tbl');
            $getData5 = $this->db->where('baseID', $getData['baseID'])->get('mpo_segregate_balance');
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
                    'information4' => $getData4,
                    'information5' => $getData5
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
          $getData2 = $this->db->where('baseID', $getData['mpoID'])->get('mpo_segregate_tbl');
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
        else if($payload['targetdata'] ==='rawmats'){
           
              $targetID = $payload['targetdatas'];
              $sqlQuery = '
              SELECT 
                  mpo_base.baseID, 
                  mpo_base.mpoID, 
                  mpo_base.item_name, 
                  mpo_base.description, 
                  mpo_base.quantity, 
                  mpo_base.unit, 
                  mpo_base.quantity_received, 
                  mpo_base.unit_price, 
                  mpo_base.status, 
                  mpo_base.discounts, 
                  mpo_base.subtotal, 
                  mpo_base.quantity_balance, 
                  COALESCE(mpo_datereceived_logs.date_received, "No data.") AS date_received
              FROM 
                  mpo_base 
              LEFT JOIN 
                  (
                      SELECT 
                          baseID, 
                          MAX(timestamp) AS max_timestamp 
                      FROM 
                          mpo_datereceived_logs 
                      GROUP BY 
                          baseID
                  ) AS latest_timestamps 
              ON 
                  mpo_base.baseID = latest_timestamps.baseID 
              LEFT JOIN 
                  mpo_datereceived_logs 
              ON 
                  mpo_base.baseID = mpo_datereceived_logs.baseID 
                  AND latest_timestamps.max_timestamp = mpo_datereceived_logs.timestamp
              WHERE 
                  mpo_base.mpoID = ?;
              ';
              

              $query = $this->db->rawQuery($sqlQuery, Array($targetID));
              if($query){
                $response = [
                    'status' => 'success',
                    'message' => 'Success getting Data',
                    'information' => $query,
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


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
  use Ifsnop\Mysqldump as IMysqldump;
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
        // Check if the 'sql_file' key exists in the payload
        if (isset($_FILES['sql_file'])) {
            // Retrieve the file data
            $fileData = $_FILES['sql_file'];
    
            // Check if the file data is valid
            if ($fileData['error'] === UPLOAD_ERR_OK) {
                // Get the temporary file location
                $tmpFilePath = $fileData['tmp_name'];
    
                // Create a new mysqli object
                $mysqli = new mysqli('localhost', 'root', '', 'weavemanila_main');
    
                // Check if the connection was successful
                if ($mysqli->connect_error) {
                    return ['status' => 'fail', 'message' => 'Connection failed: ' . $mysqli->connect_error];
                }
    
                // Disable foreign key checks
                $mysqli->query("SET foreign_key_checks = 0");
    
                // Drop all tables
                $dropTablesQuery = "SHOW TABLES";
                $result = $mysqli->query($dropTablesQuery);
    
                if ($result) {
                    while ($row = $result->fetch_row()) {
                        $tableName = $row[0];
                        $dropTableQuery = "DROP TABLE IF EXISTS $tableName";
                        $mysqli->query($dropTableQuery);
                    }
                    $result->free();
                }
    
                // Enable foreign key checks
                $mysqli->query("SET foreign_key_checks = 1");
    
                // Read the contents of the uploaded file
                $sqlCommands = file_get_contents($tmpFilePath);
    
                // Execute the SQL commands using multi_query
                if ($mysqli->multi_query($sqlCommands)) {
                    // Provide a success response
                    $response = ['status' => 'success', 'message' => 'SQL data restored successfully.'];
                } else {
                    // Provide a failure response if execution failed
                    $response = ['status' => 'fail', 'message' => 'Error restoring SQL data: ' . $mysqli->error];
                }
    
                // Close the connection
                $mysqli->close();
            } else {
                // File upload error
                $response = ['status' => 'fail', 'message' => 'File upload error: ' . $fileData['error']];
            }
        } else {
            // 'sql_file' key not found in payload
            $response = ['status' => 'fail', 'message' => 'No file uploaded.'];
        }
    
        // Output the response as JSON and exit
        echo json_encode($response);
        exit;
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

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
  require_once('./Ifsnop/vendor/autoload.php');
  require_once(__DIR__ . '/SendInBlue/vendor/autoload.php');
  require_once(__DIR__ . '/php-zip-master/vendor/autoload.php');
  use PhpZip\ZipFile;
  use Ifsnop\Mysqldump as IMysqldump;
  class API{
    public function __construct()
    {

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila_main');
    }
    public function httpGet($payload)
    {
        if ($payload['type'] == 'backup') {
            $getBackup = $this->db->rawQuery("SELECT * FROM audit_logs WHERE action = 'Backup Data' ORDER BY timestamp DESC LIMIT 3");
            
            if ($getBackup) {
                $response = ['backupData' => $getBackup];
                echo json_encode($response);
                exit;                
            } else {
                $response = ['message' => 'There is no Data.'];
                echo json_encode($response);
                exit;
            }
        } else {
            $response = ['status' => 'fail', 'message' => 'Empty Payload.'];
            echo json_encode($response);
            exit;
        }
    }
    
    
    
    public function httpPost($payload)
    {
        $requiredFields = ['email']; // Update field names here
        foreach ($requiredFields as $field) {
            if (!isset($payload[$field])) {
                $response = ['status' => 'fail', 'message' => 'Missing required field: ' . $field];
                echo json_encode($response);
                exit;
            }
        }
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'weavemanila_main';
        $dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$database", $username, $password);
        $outputFile = 'backup_' . date("Y-m-d") . '.sql';
        $dump->start($outputFile);

        $zipFile = new ZipFile();
        $zipFileName = 'backup_' . date("Y-m-d") . '.zip'; 
        $zipFile->addFile($outputFile, basename($outputFile));
        $zipFile->saveAsFile($zipFileName);
        $zipFile->close();
        
        $content = file_get_contents($zipFileName);

        $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
            new GuzzleHttp\Client(),
            $credentials
        );
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
            'subject' => 'Backup SQL File',
            'sender' => ['name' => 'WeaveManila Company', 'email' => 'janzendelacruz28@gmail.com'],
            'to' => [['email' => $payload['email']]],
            'htmlContent' => '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Backup File Instructions</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        margin: 0;
                        padding: 0;
                        background-color: #f4f4f4;
                        color: #333;
                    }
                    .container {
                        width: 80%;
                        margin: auto;
                        padding: 20px;
                        background-color: #fff;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        border-radius: 5px;
                    }
                    h1 {
                        text-align: center;
                        margin-bottom: 20px;
                        color: #333;
                    }
                    ol {
                        padding-left: 20px;
                    }
                    li {
                        margin-bottom: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Backup File Instructions</h1>
                    <p>Please find the attached backup file. Follow these steps to add it to your Google Drive:</p>
                    <ol>
                        <li>Hover over the attachment and click on the "Add to Drive" button to save it to your Google Drive.</li>
                    </ol>
                </div>
            </body>
            </html>
            ',
            'attachment' => [['content' => base64_encode($content), 'name' => $zipFileName]],
            'params' => ['bodyMessage' => 'test'],
        ]);

        // Send email
        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
        unlink($outputFile);
        unlink($zipFileName);
        if($result){
            $userData = $this->db->where('email', $payload['email'])->getOne('personel_tbl');
            if(!$userData){
                $response = ['status' => 'fail', 'message' => 'There is no such account.'];
                echo json_encode($response);
                exit;
            }
            $fullname = $userData['firstname'] . " " . $userData['lastname'];
            $insertData = [
                'image' => $userData['profile_pic'],
                'uid' => $userData['personelID'],
                'fullname' => $fullname,
                'position' => $userData['position'],
                'action' => 'Backup Data',
                'timestamp' => date('Y-m-d H:i:s'), // Format: YYYY-MM-DD HH:MM:SS
                'date' => date('Y-m-d'),
            ];
            $addLogs = $this->db->insert('audit_logs', $insertData);

            if($addLogs){
                $response = ['status' => 'success', 'message' => 'Backup Data has been sent to your email address.'];
                echo json_encode($response);
                exit;
            }else{
                $response = ['status' => 'fail', 'message' => 'Failed to insert data.'];
                echo json_encode($response);
                exit;
            }
        }else{
            $response = ['status' => 'fail', 'message' => 'Failed to send email.'];
            echo json_encode($response);
            exit;
        }

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

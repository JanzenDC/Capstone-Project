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
  require_once(__DIR__ . '/SendInBlue/vendor/autoload.php');


  class API{
    public function __construct()
    {

        $this->db = new MysqliDB('localhost', 'root', '', 'weavemanila_main');
    }

    public function httpGet($payload)
    {
        if (empty($payload['mpoform'])) {
            $response = ['status' => 'fail', 'message' => 'Target MPO form is invalid.'];
            echo json_encode($response);
            exit;
        }
        $existingRecord = $this->db->where('mpoID', $payload['mpoform'])->getOne('mpo_tbl');
        $supplierTarget = $existingRecord['supplierID'];
        if($existingRecord){
            $getRecord = $this->db->where('mpoID', $payload['mpoform'])->get('mpo_base');
            $supplierRecord = $this->db->where('supplierID', $supplierTarget)->getOne('w_supplierlist');
            $response = [
                'status' => 'success',
                'message' => 'Data has been fetch succesfully',
                'MpoData' => $existingRecord,
                'MpoBase' => $getRecord,
                'SupplierData' => $supplierRecord
            ];
            echo json_encode($response);
            exit;
        }else{
            $response = ['status' => 'fail', 'message' => 'No Existing Records.'];
            echo json_encode($response);
            exit;
        }

    }



    public function httpPost($payload)
    {
        // Check if the PDF file is included in the payload
        if (isset($_FILES['pdfFile'])) {
            $pdfFile = $_FILES['pdfFile'];
            $getData = $this->db->where('supplier_name', $_POST['selectedSupplier'])->getOne('w_supplierlist');
            if(!$getData){
                $response = [
                 'status' => 'fail',
                 'message' => 'Fail to get supplier data.',
                ];
                echo json_encode($response);
                exit;
            }
            $supplierEmail = $getData['email'];
            if ($pdfFile['error'] === UPLOAD_ERR_OK) {
                $tempFilePath = $pdfFile['tmp_name'];
    
                // Read the content of the PDF file
                $pdfContent = file_get_contents($tempFilePath);
    
                // Create a new instance of TransactionalEmailsApi
                $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
                $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
                    new GuzzleHttp\Client(),
                    $credentials
                );
                // Prepare the email data
                $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
                    'subject' => 'Purchase Order Request',
                    'sender' => ['name' => 'WeaveManila Company', 'email' => 'janzendelacruz28@gmail.com'],
                    'replyTo' => ['name' => 'Sendinblue', 'email' => 'no-reply@gmail.com'],
                    'to' => [['name' => $supplierEmail, 'email' => $supplierEmail]],
                    'htmlContent' => 'Please find the PDF attached.',
                    'params' => ['bodyMessage' => 'test'],
                    'attachment' => [['content' => base64_encode($pdfContent), 'name' => 'Purchase Order Request.pdf']]
                ]);
    
                // Send the email
                try {
                    $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
                    $response = [
                    'status' => 'success',
                    'message' => 'Email sent successfully.',
                    ];
                    echo json_encode($response);
                    exit;
                } catch (Exception $e) {
                    echo 'Failed to send email: ', $e->getMessage();
                }
            } else {
                // Handle the error occurred during file upload
                echo 'Error occurred during file upload: ' . $pdfFile['error'];
            }
        } else {
            // Handle the case when PDF file is not included in the payload
            echo 'PDF file is missing in the payload.';
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


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
  use Ifsnop\Mysqldump as IMysqldump;
  
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'weavemanila_main';
        $dump = new IMysqldump\Mysqldump("mysql:host=$host;dbname=$database", $username, $password);
        $outputFile = 'backup_' . date("Y-m-d") . '.sql';
        $dump->start($outputFile);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $outputFile . '"');
        
        $zip = new ZipArchive();
        $zipFileName = 'backup_' . date("Y-m-d") . '.zip'; 
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($outputFile);
            $zip->close();
        } else {
            throw new Exception("Failed to create zip file");
        }

        $content = file_get_contents($zipFileName);

        $credentials = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', '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');
        $apiInstance = new SendinBlue\Client\Api\TransactionalEmailsApi(
            new GuzzleHttp\Client(),
            $credentials
        );
        $getData = $this->db->where('isAdmin', 1)->getOne('personel_tbl');
        $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
            'subject' => 'Backup SQL File',
            'sender' => ['name' => 'WeaveManila Company', 'email' => 'janzendelacruz28@gmail.com'],
            'to' => [['email' => $getData['email']]],
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
        $insertData = [
            'image' => 'dont_delete.png',
            'fullname' => 'WeaveManila Automatic Backup',
            'position' => 'Bot',
            'action' => 'Automatic Backup',
            'timestamp' => date('Y-m-d H:i:s'),
            'date' => date('Y-m-d'),
        ];
        $addLogs = $this->db->insert('audit_logs', $insertData);
        if($addLogs){
            $response = ['status' => 'success', 'message' => 'Backup Data has been sent to admin email address.'];
            echo json_encode($response);
            exit;
        }else{
            $response = ['status' => 'fail', 'message' => 'Failed to insert data.'];
            echo json_encode($response);
            exit;
        }

 ?>
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
            if($payload['type'] == 'get')
            {
                $getData = $this->db->where('position', 'warehouseman')->get('personel_tbl');
                if($getData){
                    $response = [
                        'status' => 'success',
                        'message' => 'Successfully fetched data',
                        'WarehouseManData' => $getData,
                    ];
                    echo json_encode($response);
                    exit;
                }else{
                    $response = [
                        'status' => 'fail',
                        'message' => 'Failed to load warehouseman.',
                    ];
                    echo json_encode($response);
                    exit;
                }
            }else if ($payload['type'] === 'pjo') {
                $pjoData = $this->db->where('pjoID', $payload['id'])->getOne('pjo_tbl');
                if($pjoData){
                  
                    $startingNumber ='SELECT * FROM mpo_starting_date  ORDER BY startingNo DESC LIMIT 1';
                    $query = $this->db->rawQuery($startingNumber);
                    if($query){

                        $material_specs = $this->db->where('pjoID', $payload['id'])->get('material_specs_tbl');
                        $item_actual_weight = $this->db->where('pjoID', $payload['id'])->get('item_actual_weight');
                        $total_material_used = $this->db->where('pjoID', $payload['id'])->get('total_material_used');
                        $design_specs_tbl = $this->db->where('pjoID', $payload['id'])->get('design_specs_tbl');
                        $post_data_specs_tbl = $this->db->where('pjoID', $payload['id'])->get('post_data_specs_tbl');
                        $material_issuance_tbl = $this->db->where('pjoID', $payload['id'])->get('material_issuance_tbl');
                        $production_monitoring_tbl = $this->db->where('pjoID', $payload['id'])->get('production_monitoring_tbl');
                           
                        $response = [
                            'status' => 'success',
                            'material_specs' => $material_specs,
                            'jobOrder' => Array($pjoData),
                            'startingNumber' => $query,
                            'item_actual_weight' => $item_actual_weight,
                            'total_material_used' => $total_material_used,
                            'design_specs_tbl' => $design_specs_tbl,
                            'post_data_specs_tbl' => $post_data_specs_tbl,
                            'material_issuance_tbl' => $material_issuance_tbl,
                            'production_monitoring_tbl' => $production_monitoring_tbl,
                            'message' => 'Successfully fetched data',
                        ];
                        echo json_encode($response);
                        exit;
    
                    }else{
                      $response = [
                          'status' => 'fail',
                          'message' => 'Failed to load weaver.',
                      ];
                      echo json_encode($response);
                      exit; 
                    }

                }else{
                    $response = [
                        'status' => 'fail',
                        'message' => 'Failed to load PJO.',
                    ];
                    echo json_encode($response);
                    exit; 
                }

            }else if ($payload['type'] === 'weaver') {
                $weaverData = $this->db->get('weaverlist_tbl');
                if($weaverData){
                    $response = [
                        'status' => 'success',
                        'message' => 'Successfully fetched data',
                        'weaver' => $weaverData,
                    ];
                    echo json_encode($response);
                    exit;
                }else{
                    $response = [
                        'status' => 'fail',
                        'message' => 'Failed to load weaver.',
                    ];
                    echo json_encode($response);
                    exit; 
                }
            }else if ($payload['type'] === 'production_staff') {
                $getData = $this->db->where('position', 'production staff')->get('personel_tbl');
                if($getData){
                    $response = [
                        'status' => 'success',
                        'message' => 'Successfully fetched data',
                        'production_staff' => $getData,
                    ];
                    echo json_encode($response);
                    exit;
                }else{
                    $response = [
                        'status' => 'fail',
                        'message' => 'Failed to load weaver.',
                    ];
                    echo json_encode($response);
                    exit; 
                }
            }else if ($payload['type'] === 'getPJOall'){
                // $sql = "SELECT pjo_tbl.*, SUM(production_monitoring_tbl.total_output) AS total_output_sum
                //             FROM pjo_tbl 
                //             LEFT JOIN production_monitoring_tbl ON pjo_tbl.pjoID = production_monitoring_tbl.pjoID
                //             GROUP BY pjo_tbl.pjoID";
                
                // $getData = $this->db->rawQuery($sql);
                $getData = $this->db->get('pjo_tbl');
                
                if($getData){
                  $query = "SELECT companyDate FROM mpo_starting_date ORDER BY companyDate DESC LIMIT 1";
 
                  $latestMPOresult = $this->db->rawQuery($query);
                  $latestMPOdata = ($latestMPOresult) ? $latestMPOresult[0] : null;

                    $response = [
                        'status' => 'success',
                        'message' => 'Successfully fetched data',
                        'PJOdata' => $getData,
                        'mpo' => $latestMPOdata,
                    ];
                    echo json_encode($response);
                    exit;
                }else{
                    $response = [
                        'status' => 'fail',
                        'message' => 'Failed to load PJO.',
                    ];
                    echo json_encode($response);
                    exit; 
                }
            }else{
                $response = [
                    'status' => 'fail',
                    'message' => 'Invalid payload.',
                ];
                echo json_encode($response);
                exit;
            }
    }
    
    

    public function httpPost($payload)
    {
        $endorsed =         $_POST['v_Endorsed'];
        $joRefNo =          $_POST['v_JOrefNo'];
        $date =             $_POST['v_date'];
        $reference =        $_POST['v_Reference'];
        $deliveryDate =     $_POST['v_deliverydate'];


        $selectedServices = $_POST['services'];

        $desc =             $_POST['v_desc'];
        $descPattern =      $_POST['v_descpattern'];
        $cons =             $_POST['v_cons'];

        $sizeselection =    $_POST['v_optionselected'];
        $sizewidth =        $_POST['v_length'];
        $sizelength =       $_POST['v_width'];

        $dateStarted =      $_POST['v_datestarted'];
        $dateFinished =     $_POST['v_datefinished'];
        $leadTime =         $_POST['v_leadtime'];
        $qouta =            $_POST['v_qouta'];
        $quantity =         $_POST['v_quantity'];
        $looms =            $_POST['v_looms'];
        $color =            $_POST['v_color'];
        $f_approvedby =      $_POST['approvedby_name'];
        $f_preparedby =        $_POST['prepared_name'];
        $b_approvedby =      $_POST['s_approvedby_name'];
        $b_preparedby =        $_POST['s_prepared_name'];
        $checked_by = $_POST['v_checkedby'];              
        $targetID = $_POST['targetID'];

        $dataPJO = [
            'endorse' => $endorsed,
            'job_order_no' => $joRefNo,
            'date' => $date,
            'reference' => $reference,
            'delivery_date' => $deliveryDate,


            'f_preparedby' => $f_preparedby,

            'f_approvedby' => $f_approvedby,

            'b_preparedby' => $b_preparedby,
            'b_approvedby' => $b_approvedby,
            
            'description' => $desc,
            'design_pattern' => $descPattern,
            'construction' => $cons,
            'quantity' => $quantity,

            'width' => $sizewidth,
            'length' => $sizelength,
            'size_selected' => $sizeselection,
            'services' => $selectedServices,
            'date_started' => $dateStarted,
            'date_finished' => $dateFinished,
            'lead_time' => $leadTime,
            'qouta' => $qouta,
            'loom' => $looms,
            'color' => $color,
            'checked_by' => $checked_by,
        ];
        $insertData = $this->db->where('pjoID', $targetID)->update('pjo_tbl', $dataPJO);
        if($insertData){
            $getPJOid = $this->db->where('job_order_no', $joRefNo)->getOne('pjo_tbl');

            // Insert item actuals
            if (isset($_POST['item_actuals']) && is_array($_POST['item_actuals'])) {
                foreach ($_POST['item_actuals'] as $productJSON) {
                    $materialData = json_decode($productJSON, true);
                    if ($materialData !== null) { 
                        $requiredFields = ['quantity', 'weight', 'unit'];
                        $missingFields = array_diff($requiredFields, array_keys($materialData));
                
                        if (!isset($materialData['id']) || is_null($materialData['id']) || $materialData['id'] === '' || empty($materialData['id'])) {
                            $designs_insert = [
                                'pjoID' => $getPJOid['pjoID'],
                                'quantity' => $materialData['quantity'],
                                'weight'  => $materialData['weight'],
                                'unit'  => $materialData['unit'],
                            ];
                            $test = $this->db->insert('item_actual_weight', $designs_insert);
                        } else {
                            $designs_insert = [
                                
                                'quantity' => $materialData['quantity'],
                                'weight'  => $materialData['weight'],
                                'unit'  => $materialData['unit'],
                            ];
                            $test = $this->db->where('actualweightID', $materialData['id'])->update('item_actual_weight', $designs_insert);
                        }
                        

                        if($test){
                            $response = [
                                'status' => 'success',
                                'message' => 'Successfully added.',
                            ];
                            echo json_encode($response);
                        }else{
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: cannot insert data.',
                            ];
                        }
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "item_actuals" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }                            
                echo json_encode($response);
            }

            if (isset($_POST['total_material_used']) && is_array($_POST['total_material_used'])) {
                foreach ($_POST['total_material_used'] as $productJSON) {
                    $materialData = json_decode($productJSON, true);
                    if ($materialData !== null) { 
                        $requiredFields = ['material_used'];
                        $missingFields = array_diff($requiredFields, array_keys($materialData));
                        
                        // Set default value for 'quantity' if not set or empty
                        $quantity = isset($materialData['quantity']) ? $materialData['quantity'] : 0;
            
                        // Set default value for 'unit' if not set or blank
                        $unit = !empty($materialData['unit']) ? $materialData['unit'] : 'kilogram';
                        if (!isset($materialData['id']) || is_null($materialData['id']) || $materialData['id'] === '' || empty($materialData['id'])) {
                            $designs_insert = [
                                'pjoID' => $getPJOid['pjoID'],
                                'material_used' => $materialData['material_used'],
                                'quantity'  => $quantity,
                                'unit'  => $unit,
                            ];
                            $test = $this->db->insert('total_material_used', $designs_insert);
                        }else{
                            $designs_insert = [
                                
                                'material_used' => $materialData['material_used'],
                                'quantity'  => $quantity,
                                'unit'  => $unit,
                            ];
                            $test = $this->db->where('materialusedID', $materialData['id'])->update('total_material_used', $designs_insert);
                        }

                        if ($test) {
                            $response = [
                                'status' => 'success',
                                'message' => 'Successfully added.',
                            ];
                        } else {
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: cannot insert data.',
                            ];
                        }
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "total_material_used" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }                            
                echo json_encode($response);
            }
            
            if (isset($_POST['postdata']) && is_array($_POST['postdata'])) {
                foreach ($_POST['postdata'] as $productJSON) {
                    $materialData = json_decode($productJSON, true);
                    if ($materialData !== null) { 
                        $requiredFields = ['setting', 'weaving', 'output', 'warp', 'weft', 'insert'];
                        $missingFields = array_diff($requiredFields, array_keys($materialData));
                
                        if (!isset($materialData['id']) || is_null($materialData['id']) || $materialData['id'] === '' || empty($materialData['id'])) {
                            $designs_insert = [
                                'pjoID' => $getPJOid['pjoID'],
                                'setting_w' => $materialData['setting'],
                                'weaving_w'  => $materialData['weaving'],
                                'output_width'  => $materialData['output'],
                                'warp_waste'  => $materialData['warp'],
                                'weft_waste'  => $materialData['weft'],
                                'insert_waste'  => $materialData['insert'],
                            ];
                            $test = $this->db->insert('post_data_specs_tbl', $designs_insert);
                        }else{
                            $designs_insert = [
                                'setting_w' => $materialData['setting'],
                                'weaving_w'  => $materialData['weaving'],
                                'output_width'  => $materialData['output'],
                                'warp_waste'  => $materialData['warp'],
                                'weft_waste'  => $materialData['weft'],
                                'insert_waste'  => $materialData['insert'],
                            ];
                            $test = $this->db->where('post_data_specsID', $materialData['id'])->update('post_data_specs_tbl', $designs_insert);
                        }

                        if($test){
                            $response = [
                                'status' => 'success',
                                'message' => 'Successfully added.',
                            ];
                            echo json_encode($response);
                        }else{
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: cannot insert data.',
                            ];
                        }
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "postdata" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }                            
                echo json_encode($response);
            }

            if (isset($_POST['materials']) && is_array($_POST['materials'])) {
                foreach ($_POST['materials'] as $productJSON) {
                    $materialData = json_decode($productJSON, true);
                    if ($materialData !== null) { 
                        $requiredFields = ['date', 'material_desc', 'quantity', 'returned', 'balance', 'issued_by'];
                        $missingFields = array_diff($requiredFields, array_keys($materialData));
                
                        if (!isset($materialData['id']) || is_null($materialData['id']) || $materialData['id'] === '' || empty($materialData['id'])) {
                            $designs_insert = [
                                'pjoID' => $getPJOid['pjoID'],
                                'date' => $materialData['date'],
                                'material_desc'  => $materialData['material_desc'],
                                'quantity'  => $materialData['quantity'],
                                'returned'  => $materialData['returned'],
                                'balance'  => $materialData['balance'],
                                'issued_by'  => $materialData['issued_by'],

                            ];
                            $test = $this->db->insert('material_issuance_tbl', $designs_insert);
                        }else{
                            $designs_insert = [
                                'date' => $materialData['date'],
                                'material_desc'  => $materialData['material_desc'],
                                'quantity'  => $materialData['quantity'],
                                'returned'  => $materialData['returned'],
                                'balance'  => $materialData['balance'],
                                'issued_by'  => $materialData['issued_by'],

                            ];
                            $test = $this->db->where('post_data_specsID', $materialData['id'])->update('material_issuance_tbl', $designs_insert);
                        }
                        if($test){
                            $response = [
                                'status' => 'success',
                                'message' => 'Successfully added.',
                            ];
                            echo json_encode($response);
                        }else{
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: cannot insert data.',
                            ];
                        }
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "materials" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }                            
                echo json_encode($response);
            }

            if (isset($_POST['production_monitoring']) && is_array($_POST['production_monitoring'])) {
                foreach ($_POST['production_monitoring'] as $productJSON) {
                    $materialData = json_decode($productJSON, true);
                    if ($materialData !== null) { 
                        $requiredFields = ['date', 'time_in', 'time_out', 'output_am', 'ot_time_in', 'ot_time_out', 'ot_output', 'total_output'];
                        $missingFields = array_diff($requiredFields, array_keys($materialData));
                
                        $total = $materialData['output_am'] + $materialData['ot_output'];

                        if (!isset($materialData['id']) || is_null($materialData['id']) || $materialData['id'] === '' || empty($materialData['id'])) {
                            $designs_insert = [
                                'pjoID' => $getPJOid['pjoID'],
                                'date' => $materialData['date'],
                                'time_in_am'  => $materialData['time_in'],
                                'time_out_pm'  => $materialData['time_out'],
                                'output_am_pm'  => $materialData['output_am'],
                                'ot_time_in'  => $materialData['ot_time_in'],
                                'ot_time_out'  => $materialData['ot_time_out'],
                                'ot_output'  => $materialData['ot_output'],
                                'total_output'  => $total,
                            ];
                            
                            $test = $this->db->insert('production_monitoring_tbl', $designs_insert);
                        }else{
                            $designs_insert = [
                                'date' => $materialData['date'],
                                'time_in_am'  => $materialData['time_in'],
                                'time_out_pm'  => $materialData['time_out'],
                                'output_am_pm'  => $materialData['output_am'],
                                'ot_time_in'  => $materialData['ot_time_in'],
                                'ot_time_out'  => $materialData['ot_time_out'],
                                'ot_output'  => $materialData['ot_output'],
                                'total_output'  => $total,
                            ];
                            
                            $test = $this->db->where('post_data_specsID', $materialData['id'])->update('production_monitoring_tbl', $designs_insert);
                        }

                        if($test){
                            $response = [
                                'status' => 'success',
                                'message' => 'Successfully added.',
                            ];
                            echo json_encode($response);
                        }else{
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: cannot insert data.',
                            ];
                        }
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "production_monitoring" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }                            
                echo json_encode($response);
            }
            
            if (isset($_POST['material_specs']) && is_array($_POST['material_specs'])) {
                foreach ($_POST['material_specs'] as $productJSON) {
                    $materialData = json_decode($productJSON, true);
                    if ($materialData !== null) { 
                        $requiredFields = ['type', 'consumption', 'material_used', 'waste_allow', 'total'];
                        $missingFields = array_diff($requiredFields, array_keys($materialData));
                
                        if (!isset($materialData['id']) || is_null($materialData['id']) || $materialData['id'] === '' || empty($materialData['id'])) {
                            $material_specs_insert = [
                                'pjoID' => $getPJOid['pjoID'],
                                'consumption_in_wt_kg' => $materialData['consumption'],
                                'type' => $materialData['type'],
                                'material_used'  => $materialData['material_used'],
                                'waste_allow'  => $materialData['waste_allow'],
                                'total_allow_issuance' => $materialData['total'],
                            ];
                            $test = $this->db->insert('material_specs_tbl', $material_specs_insert);
                        }else{
                            $material_specs_insert = [
                                'consumption_in_wt_kg' => $materialData['consumption'],
                                'type' => $materialData['type'],
                                'material_used'  => $materialData['material_used'],
                                'waste_allow'  => $materialData['waste_allow'],
                                'total_allow_issuance' => $materialData['total'],
                            ];
                            $test = $this->db->where('material_specsID', $materialData['id'])->update('material_specs_tbl', $designs_insert);
                        }

                        if($test){
                            $response = [
                                'status' => 'success',
                                'message' => 'Successfully added.',
                            ];
                            echo json_encode($response);
                        }else{
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: cannot insert data.',
                            ];
                            echo json_encode($response);
                            exit;
                        }
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "material_specs" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                }                            
            }

            if (isset($_POST['designs']) && is_array($_POST['designs'])) {
                foreach ($_POST['designs'] as $productJSON) {
                    $materialData = json_decode($productJSON, true);
                    if ($materialData !== null) { 
                        $requiredFields =['pattern_name', 'DPI', 'EPI', 'threading', 'harness_lift', 'Pedal'];
                        $missingFields = array_diff($requiredFields, array_keys($materialData));
                
                        if (!isset($materialData['id']) || is_null($materialData['id']) || $materialData['id'] === '' || empty($materialData['id'])) {
                            $designs_insert = [
                                'pjoID' => $getPJOid['pjoID'],
                                'pattern_name' => $materialData['pattern_name'],
                                'dpi'  => $materialData['DPI'],
                                'epi'  => $materialData['EPI'],
                                'threading' => $materialData['threading'],
                                'harness_lift' => $materialData['harness_lift'],
                                'pedal' => $materialData['Pedal'],
                            ];
                            $test = $this->db->insert('design_specs_tbl', $designs_insert);
                        }else{
                            $designs_insert = [
                                'pattern_name' => $materialData['pattern_name'],
                                'dpi'  => $materialData['DPI'],
                                'epi'  => $materialData['EPI'],
                                'threading' => $materialData['threading'],
                                'harness_lift' => $materialData['harness_lift'],
                                'pedal' => $materialData['Pedal'],
                            ];
                            $test = $this->db->where('design_specsID', $materialData['id'])->update('design_specs_tbl', $designs_insert);
                        }

                        if($test){
                            $response = [
                                'status' => 'success',
                                'message' => 'Successfully added.',
                            ];
                            
                        }else{
                            $response = [
                                'status' => 'fail',
                                'message' => 'Error: cannot insert data.',
                            ];
                            echo json_encode($response);
                            exit;
                        }
                    } else {
                        $response = [
                            'status' => 'fail',
                            'message' => 'Error: Missing or invalid "designs" data.',
                        ];
                        echo json_encode($response);
                        exit;
                    }
                    echo json_encode($response);
                }                            
                $response = [
                    'status' => 'success',
                ];
                echo json_encode($response);
                exit;
            }
            $response = [
              'status' =>'success',
              'message' => 'Successfully inserted data',
            ];
            echo json_encode($response);
            exit;
        }else{
            $response = [
                'status' =>'fail',
                'message' => 'Fail to inserted data',
              ];
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

<?php

if (!function_exists('url')) {

    function url($slug)
    {
        return base_url() . '/' . $slug;
    }
}

if (!function_exists('html_convert')) {

    function html_convert($text)
    {
        $text = str_replace("'", "", $text);
        $text = str_replace("\"", "", $text);

        return html_entity_decode($text);
    }
}

function sendsms($to, $msg, $accountusagetypeid = 10)
{
    $post_data = array(
        'listsms' =>
        array(
            array(
                'sms' => $msg,
                'mobiles' => '+91' . $to,
                'senderid' => 'INFOSM',
                'accountusagetypeid' => $accountusagetypeid,
            ),
        ),
        'password' => '422960c773XX',
        'user' => 'Klamp',
    );
    echo '<pre>';
    print_r($post_data);
    $data = json_encode($post_data);

    $curl = curl_init('http://mobicomm.dove-sms.com//REST/sendsms/');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  // Insert the data
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

    $response = json_decode(curl_exec($curl));
    $err = curl_error($curl);

    curl_close($curl);

    print_r($response);
    if (@$response->smslist->sms->status == 'success') {
        $msg = array('st' => 'success', 'msg' => "Message Send Successfully");
    } else {
        $msg = array('st' => 'failed', 'msg' => $response->smslist->sms->reason);
    }

    return $msg;
}
function sendsms_new($to, $msg, $accountusagetypeid = 10)
{
    $post_data = array(
        'listsms' =>
        array(
            array(
                'sms' => $msg,
                'mobiles' => '+91' . 7863088572,
                'senderid' => 'INFOSM',
                'clientsmsid' => '1947692308',
                'accountusagetypeid' => $accountusagetypeid
            ),
        ),
        'password' => '422960c773XX',
        'user' => 'Klamp',
    );
    echo '<pre>';
    print_r($post_data);
    $data = json_encode($post_data);

    $curl = curl_init('https://mobicomm.dove-sms.com//REST/sendsms/');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  // Insert the data
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

    $response = json_decode(curl_exec($curl));
    $err = curl_error($curl);

    curl_close($curl);

    print_r($response);
    if (@$response->smslist->sms->status == 'success') {
        $msg = array('st' => 'success', 'msg' => "Message Send Successfully");
    } else {
        $msg = array('st' => 'failed', 'msg' => $response->smslist->sms->reason);
    }

    return $msg;
}
function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}

function generate_traking_number()
{

    $db = \Config\Database::connect();
    $builder = $db->table('sales');
    $count = 0;
    $random_number = "";
    while ($count < 13) {
        $random_digit = rand(0, 9);
        $random_number .= $random_digit;
        $count++;
    }

    $builder->where(array('TrackId' => $random_number));
    $result = $builder->get();
    $getSales = $result->getRow();
    if (!empty($getSales)) {
        $randomString = generate_traking_number();
    }

    return $random_number;
}

function stock_increase($qty, $sales_ord_id)
{

    $db = \Config\Database::connect();

    $builder = $db->table('stock_log');
    $builder->select('id,stock_id,qty,damage_qty,used_qty,used_sales_id');
    $where = 'FIND_IN_SET("' . $sales_ord_id . '", `used_sales_id`)';
    $builder->where($where);
    $result = $builder->get();
    $getLog = $result->getRow();


    if (!empty($getLog)) {
        $builder = $db->table('stock');
        $builder->set('qty', 'qty +' . $qty, FALSE);
        $builder->where(array('id' => $getLog->stock_id));
        $result = $builder->update();

        $used_qty = $getLog->used_qty - $qty;
        $is_used = 0;
        if ($getLog->qty == ($used_qty + intval($getLog->damage_qty))) {
            $is_used = 1;
        }
        $used_sales_id = explode(',', $getLog->used_sales_id);
        if (($key = array_search($sales_ord_id, $used_sales_id)) !== false) {
            unset($used_sales_id[$key]);
        }

        $update_data = array(
            'used_qty' => $used_qty,
            'used_sales_id' => implode(',', $used_sales_id),
            'is_used' => $is_used
        );
        $builder = $db->table('stock_log');
        $builder->where(array('id' => $getLog->id));
        $result = $builder->update($update_data);

        //remove sales order id form purchase is_fba set yes to no
        // $where = 'FIND_IN_SET("' . $sales_ord_id . '", `SalesOrderId`)';
        // $sales_builder = $db->table('purchase')
        //     ->select('id,SalesOrderId')->where($where)->get()->getRow();


        // if (!empty($sales_builder)) {
        //     $sales_old_order_id = explode(',', $sales_builder->SalesOrderId);
        //     if (($key = array_search($sales_ord_id, $sales_old_order_id)) !== false) {
        //         unset($sales_old_order_id[$key]);
        //     }
        // }

        // $update_sales = $db->table('purchase')->where(array('id' => $sales_builder->id))
        //                 ->update(['SalesOrderId' => implode(',', $sales_old_order_id)]);
        //print_r($sales_old_order_id);exit;

        $data_result = array("st" => "success", "txt" => "Stock Update Successfully");
    } else {
        $data_result = array("st" => "failed", "txt" => "failed");
    }

    return $data_result;
}

function stock_decrease($id, $qty)
{

    $db = \Config\Database::connect();
    $builder = $db->table('stock');
    $builder->set('qty', 'qty -' . $qty, FALSE);
    $builder->where(array('id' => $id));
    $result = $builder->update();

    if ($result)
        $data_result = array("st" => "success", "txt" => "Stock Update Successfully");
    else
        $data_result = array("st" => "failed", "txt" => "failed");

    return $data_result;
}

function update_stock_log($id, $qty, $sales_ord_id)
{

    $db = \Config\Database::connect();
    $builder = $db->table('stock_log');
    $builder->select('id,used_sales_id,damage_qty,purchase_id,qty,used_qty');
    $builder->where(array('stock_id' => $id));
    $builder->where(array('is_used' => '0'));
    $builder->where(array('is_damaged' => '0'));
    $result = $builder->get();
    $getLog = $result->getRow();

    $used_sales_id = explode(',', @$getLog->used_sales_id);
    $used_sales_id[] = $sales_ord_id;

    $is_used = 0;
    if ($getLog->qty < $qty) {
        $used_qty = $getLog->used_qty + 1;
    } else {
        $used_qty = $getLog->used_qty + $qty;
    }
    if ($getLog->qty == ($used_qty + intval($getLog->damage_qty))) {
        $is_used = 1;
    }
    $update_data = array(
        'used_qty' => $used_qty,
        'used_sales_id' => implode(',', $used_sales_id),
        'is_used' => $is_used
    );
    $builder->where(array('id' => $getLog->id));
    $result = $builder->update($update_data);

    $builder = $db->table('purchase');
    $builder->select('id,SalesOrderId');
    $builder->where(array('OrderId' => $getLog->purchase_id));
    $result = $builder->get();
    $getPurchase = $result->getRow();

    if (!empty($getPurchase)) {
        $SalesOrderId = explode(',', $getPurchase->SalesOrderId);
        $SalesOrderId[] = $sales_ord_id;
        $data = array(
            'SalesOrderId' => implode(',', $SalesOrderId),
            'update_by' => session('uid'),
            'update_at' => date('Y-m-d H:i:s')
        );
        $builder->where(array('id' => $getPurchase->id));
        $result = $builder->update($data);
    } else {
        $result = true;
    }
    if ($getLog->qty < $qty) {
        $test = update_stock_log($id, ($qty - 1), $sales_ord_id);
    }
    if ($result)
        $data_result = array("st" => "success", "txt" => "Stock log Update Successfully");
    else
        $data_result = array("st" => "failed", "txt" => "failed");

    return $data_result;
}

function getuserMenus($role_id)
{

    $db = \Config\Database::connect();
    $builder = $db->table('roles_master');
    $builder->select('menus');
    $builder->where('id', $role_id);
    $result = $builder->get();
    $getRole = $result->getRow();

    $menus = json_decode($getRole->menus, true);
    $result_arr = array();
    foreach ($menus as $menu_id => $row) {

        $builder = $db->table('menu_master');
        $builder->select('*');
        $builder->where('id', $menu_id);
        $result = $builder->get();
        $result_array = $result->getRow();

        if (!empty($row) && $row != 0) {
            $sub_arr = array();
            foreach ($row as $key => $submenu_id) {

                $builder->select('*');
                $builder->where('id', $submenu_id);
                $result = $builder->get();
                $sub_arr[] = $result->getRow();
            }
            $result_array->submenu = $sub_arr;
        }

        $result_arr[] = $result_array;
    }

    return $result_arr;
}

function delete_file($path)
{
    return unlink($path);
}

function uploadMultiFiles($fieldName, $uploadfolder)
{

    $year = date('Y');
    $month = date('m');
    $day = date('d');

    if ($uploadfolder == 'GlanceView')
        $original_path = "/" . $uploadfolder . "/" . session('market') . '/';
    else
        $original_path = "/" . $uploadfolder . "/" . $year . "/" . $month . "/" . $day . "/";

    if (!file_exists(getcwd() . $original_path)) {
        mkdir(getcwd() . $original_path, 0777, true);
    }

    $files = $_FILES;
    $randno = uniqid();
    $name = $files[$fieldName]['name'];
    $allowed = array('csv', 'xlsx', 'xls');
    $ext = pathinfo($name, PATHINFO_EXTENSION);

    if (!in_array($ext, $allowed)) {
        $response['errors'] = 'only CSV file Allowed';
        $response['is_success'] = 0;
    } else {

        $pathinfo = pathinfo($name);
        $imageName = $pathinfo['filename'] . '_' . $randno . "." . $pathinfo['extension'];
        $_FILES[$fieldName]['name'] = $imageName;
        $_FILES[$fieldName]['type'] = $files[$fieldName]['type'];
        $_FILES[$fieldName]['tmp_name'] = $files[$fieldName]['tmp_name'];
        $_FILES[$fieldName]['error'] = $files[$fieldName]['error'];

        $targetFile = getcwd() . $original_path . $imageName;
        $tempFile = $_FILES[$fieldName]['tmp_name'];
        if (move_uploaded_file($tempFile, $targetFile)) {
            $response['fileName']  = $original_path . $imageName;
            $response['is_success'] = 1;
        } else {
            $response['errors'] = '';
            $response['is_success'] = 0;
        }
    }

    return $response;
}

function to_time_ago($time)
{

    $diff = time() - $time;
    if ($diff < 1) {
        return 'less than 1 second';
    }
    $time_rules = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60     => 'month',
        24 * 60 * 60         => 'day',
        60 * 60                 => 'hour',
        60                     => 'minute',
        1                     => 'second'
    );
    foreach ($time_rules as $secs => $str) {
        $div = $diff / $secs;
        if ($div >= 1) {
            $t = round($div);
            return $t . ' ' . $str . ($t > 1 ? 's' : '') . '';
        }
    }
}

function getManagedData($tablename, $dt_col, $dt_search, $where, $dt_order = array())
{
    ini_set('memory_limit', '-1'); //print_r($aColumns);exit;
    $db = \Config\Database::connect();
    $request = \Config\Services::request();
    $rResult = array();
    //$sQuery = "SELECT COUNT('*') AS row_count FROM " . $tablename;
    //$rResultTotal = $db->query($sQuery);
    // $aResultTotal = $rResultTotal->getRow();
    //$rResult[] = $aResultTotal->row_count;
    $post = $request->getPost();
    if (empty($post)) {
        $post = $request->getGet();
    }
    $draw = intval($post['draw']);
    $starts = $post['start'];
    $limit = $post['length'];

    $sLimit = "";
    $iDisplayStart = $post['start'];
    $iDisplayLength = $post['length'];
    if (isset($iDisplayStart) && $iDisplayLength != '-1') {
        $sLimit = "LIMIT " . intval($iDisplayStart) . ", " .
            intval($iDisplayLength);
    }

    $uri_string = urldecode($_SERVER['QUERY_STRING']);
    $uri_string = preg_replace("/%5B/", '[', $uri_string);
    $uri_string = preg_replace("/%5D/", ']', $uri_string);

    $get_param_array = explode("&", $uri_string);
    $arr = array();
    if (!empty($get_param_array)) {
        foreach ($get_param_array as $value) {
            $v = $value;
            $explode = explode("=", $v);
            $arr[$explode[0]] = $explode[1];
        }
    }

    $index_of_columns = $post["columns"];
    $index_of_start = $post["start"];


    /*
     * Ordering
     */
    $sOrder = "";
    for ($i = 0; $i < count($post['order']); $i++) {

        $sOrderIndex = $post['order'][$i]['column'];
        $sOrderDir = $post['order'][$i]['dir'];

        $bSortable_ = $post['columns'][$sOrderIndex]['orderable'];

        if ($bSortable_ == true) {
            if (empty($dt_order)) {
                $sOrder .= $dt_search[$sOrderIndex] . ($sOrderDir == 'asc' ? ' asc' : ' desc');
            } else {
                foreach ($dt_order as $dt_key => $dt_val) {
                    $sOrder .= $dt_key . ($dt_val == 'asc' ? ' asc' : ' desc');
                }
            }
        }
    }

    if ($sOrder != '')
        $sOrder = "ORDER BY " . $sOrder;

    if (!isset($post['order'][0]['column'])) {
        if (empty($dt_order))
            $sOrder .= $dt_search[0] . (' desc');
        else
            $sOrder .= $dt_order[0] . (' desc');
    }


    $sWhere = " WHERE 1 ";

    $sSearchVal = $post['search']['value'];
    if (isset($sSearchVal) && $sSearchVal != '') {


        $sWhere = $sWhere . "AND (";
        for ($i = 0; $i < count($dt_search); $i++) {
            $sWhere .= $dt_search[$i] . " LIKE '%" . str_replace('+', ' ', ($sSearchVal)) . "%' OR ";
        }
        $sWhere = substr_replace($sWhere, "", -3);
        $sWhere .= ')';
    }
    $sWhere .= $where;
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "SELECT SQL_CALC_FOUND_ROWS " . str_replace(" , ", " ", implode(", ", $dt_col)) . "
			FROM $tablename
			$sWhere
			$sOrder
			$sLimit
			";
    //echo $sQuery; exit;
    $rResult[] = $db->query($sQuery);
    //echo "<pre>"; print_r($rResult->result_array());exit;
    // echo $db->getLastQuery(); exit;
    /* Data set length after filtering */
    $sQuery = "SELECT FOUND_ROWS() AS length_count";
    $rResultFilterTotal = $db->query($sQuery);
    $aResultFilterTotal = $rResultFilterTotal->getRow();
    $rResult[] = $aResultFilterTotal->length_count;
    //  print_r($rResult[1]->result_array()); exit;
    $result_return = array(
        'table' => $rResult[0]->getResultArray(),
        'draw' => $draw,
        'total' => $rResult[1]
    );
    return $result_return;
    //$iFilteredTotal
}

function MakeThumb($source_path, $target_path, $width, $height, $defalusize = '600')
{
    if ($height == $defalusize && $width == $defalusize) {
        $height = $defalusize;
        $width = $defalusize;
    } else if ($height >= $width && $height > $defalusize) {
        $calc = $height / $defalusize;
        $height = $defalusize;
        $width = $width / $calc;
    } else if ($height <= $width && $width > $defalusize) {
        $calc = $width / $defalusize;
        $width = $defalusize;
        $height = $height / $calc;
    } else {
        $width = $width;
        $height = $height;
    }


    $image = \CodeIgniter\Config\Services::image()
        ->withFile($source_path)
        ->resize(600, 600, true, 'height')
        ->save($target_path);
}

function insert_mis_reports($awbno)
{

    $db = \Config\Database::connect();
    $builder = $db->table('bombino_shipment');
    $builder->select('*');
    $builder->where('AWBNO', $awbno);
    $builder->limit(1);
    $result = $builder->get();
    $result_array = $result->getRowArray();
    $data = json_decode($result_array['TrackData']);
    $gmodel = new App\Models\GeneralModel();
    foreach ($data as $row) {
        // echo '<pre>';
        // print_r($row);

        $bombino = $gmodel->get_data_table('bombino_boe', array('awbno' => $result_array['AWBNO'], 'catagory' => $row->title), '*');

        if (!empty($bombino)) {

            if ($row->trk != 'undefined') {

                $pur_builder = $db->table('purchase p');
                $pur_builder->select('p.id as pur_id,p.OrderId,p.PurchaseAmt,p.Profit,p.ProfitPercentage,p.comment,p.bob_freight,p.SalesOrderId,p.order_promotion,p.total_freight,p.freight,c.hsn');
                $pur_builder->join('product pr', 'pr.sku = p.sku');
                $pur_builder->join('category c', 'c.category_cd = pr.pro_category');
                $pur_builder->where(array('p.AmzTrakingId' => $row->trk, 'c.hsn' => $row->hsn));
                $result = $pur_builder->get();
                $purchase = $result->getRowArray();

                if (!empty($purchase)) {

                    try {

                        $order_id = explode(',', $purchase['SalesOrderId']);
                        $count = count($order_id);

                        foreach ($order_id as $id) {


                            $act_custom = $actual_price = $sale_price = $sale_dollar = $act_purchase_amt = $profit_dollar = $profit_percentage = 0;

                            $sales = $gmodel->get_data_table('sales', array('ord_id' => $id), 'id,ord_id,ord_dt,sku,buy_price,wgt_chg,custom_charge,earnings,tax');

                            $act_custom = $bombino['cd'] == '' ? 0 : round($bombino['cd'] / $bombino['ex_rate'], 2);

                            $freight = $purchase['freight'] != '' ? $purchase['freight'] : 0;
                            $order_promotion = $purchase['order_promotion'] != '' ? $purchase['order_promotion'] : 0;

                            $actual_price = @$purchase['PurchaseAmt'] + $freight - $order_promotion;
                            $sale_price = $sales['earnings'] - trim($sales['tax']);
                            $sale_dollar = $sale_price == 0 ? 0 : $sale_price / $bombino['ex_rate'];
                            $act_purchase_amt = ($actual_price + $act_custom + $purchase['bob_freight']) / $count;

                            if ($sale_dollar == 0) {
                                $profit_dollar = 0;
                                $profit_percentage = 0;
                            } else {
                                $profit_dollar = round($sale_dollar - $act_purchase_amt, 2);
                                $profit_percentage = round(($profit_dollar * 100) / $sale_dollar, 2);
                            }
                            // echo '<pre>';
                            // print_r($profit_percentage);
                            // echo '<pre>';
                            // print_r($purchase['ProfitPercentage']);


                            /**
                             * handeling profit percentage column
                             */
                            $ignore = ['NaN', '-Infinity', 'Infinity'];
                            $_profit  = 0;
                            if (!in_array($purchase['ProfitPercentage'], $ignore)) {
                                $_profit  =  $purchase['ProfitPercentage'];
                            }

                            $mdata = array(
                                "sales_id" => $sales['id'],
                                "purchase_id" => $purchase['pur_id'],
                                "awb" => $result_array['AWBNO'],
                                "orderid" => $purchase['OrderId'],
                                "purchaseamt" => $purchase['PurchaseAmt'],
                                "profit" => $purchase['Profit'],
                                "profitpercentage" => $purchase['ProfitPercentage'],
                                "freight" => $sales['wgt_chg'],
                                "custom" => $sales['custom_charge'],
                                "comment" => $purchase['comment'],
                                "act_freight" => $purchase['bob_freight'],
                                "act_custom" => $act_custom,
                                "act_profit" => $profit_dollar,
                                "act_profitpercentage" => $profit_percentage,
                                "pr_diff" => @$profit_percentage - $_profit,
                                "ex_rate" => $bombino['ex_rate'],
                                "ord_id" => $sales['ord_id'],
                                "ord_dt" => $sales['ord_dt'],
                                "sku" => $sales['sku'],
                                "buy_price" => $sales['buy_price'],
                                "trakingid" => $row->trk
                            );
                            $mis_builder = $db->table('mis_reports');
                            $mis_builder->where(array('sales_id' => $sales['id'], 'sku' => $sales['sku']));
                            $result = $mis_builder->get();
                            $mis_data = $result->getRowArray();

                            if (empty($mis_data)) {
                                $inserted =  $mis_builder->insert($mdata);
                            } else {
                                $mis_builder->where('sales_id', $sales['id']);
                                $inserted =  $mis_builder->update($mdata);
                            }
                        }
                    } catch (\Throwable $th) {

                        $mdata = array(
                            "awb" => $result_array['AWBNO'],
                            "trakingid" => $row->trk,
                            "is_err" => '1',
                        );
                        $mis_builder = $db->table('mis_reports');
                        $inserted =  $mis_builder->insert($mdata);
                    }
                } else {
                    $mdata = array(
                        "awb" => $result_array['AWBNO'],
                        "trakingid" => $row->trk,
                        "is_err" => '1',
                    );
                    $mis_builder = $db->table('mis_reports');
                    $inserted =  $mis_builder->insert($mdata);
                }
            }
        } else {
            $mdata = array(
                "awb" => $result_array['AWBNO'],
                "trakingid" => $row->trk,
                "is_err" => '1',
            );
            $mis_builder = $db->table('mis_reports');
            $inserted =  $mis_builder->insert($mdata);
        }
    }
    $builder->where(array('AWBNO' => $result_array['AWBNO']));
    $res = $builder->Update(array('is_run' => 1));
}

function UpdateLog($data)
{
    $data['log_time'] = date('Y-m-d H:i:s');
    $data['user_id'] = session('uid') ? session('uid') : 0;

    $db = \Config\Database::connect();
    $builder = $db->table('activity_log');
    $builder->insert($data);
}
function stock_historyLog($data)
{
    $data['log_date_time'] = date('Y-m-d H:i:s');
    $data['updated_by'] = session('uid') ? session('uid') : 0;

    $db = \Config\Database::connect();
    $builder = $db->table('stock_history');
    $builder->insert($data);
}

function db_date($date)
{

    if (!empty($date) && $date != '0000-00-00') {

        $dt = date_create($date);
        $year = $dt->format("Y");
        $ret_date = date_format($dt, 'Y-m-d');
    } else {
        $ret_date = '';
    }

    return $ret_date;
}


function currency_rate()
{
    $db = \Config\Database::connect();

    $get_data = $db->table('market')->select('currency_rate')->where(['market' => session('market')])->get(1)->getRow();
    if (!empty($get_data)) {
        return $get_data->currency_rate;
    }
}
function update_stock_qty($data)
{
    $session = session('market');

    if ($session == 'IN') {
        $seller_id = 'A2ON2B5XK3AL27';
        $account_name = "klampon_in";
        $marketplace = "IN";
    } else if ($session == 'AE') {
        $seller_id = 'A25QFIJMKEFYPE';
        $account_name = "klampon_ae";
        $marketplace = "AE";
    } else {
        echo "method not implement";
        exit;
    }


    //$data['sku'] = 'GKNMB0DDBPN7D1';

    if (!empty($data)) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://pybrahmastra.klampon.in/update_listing_item_quantity/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                "account_name" => $account_name,
                "marketplace" => $marketplace,
                "seller_id" => $seller_id,
                "sku" => $data['sku'],
                "quantity" => $data['total_qty']
            ]),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Token 3ebefbcc97e079ca1333a09c2a2d0411ef7b8548',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response, true);

        if (isset($res['status']) && $res['status'] == 'success') {
            return ['st' => 'success', 'msg' => 'Updated successfully', 'trace' => $res];
        } else {
            return ['st' => 'failed', 'msg' => 'Something went wrong please try again', 'trace' => $res];
        }
    } else {
        echo "Request not allowed";
    }
}
function formatDateWithSuffix($dateStr)
{
    $timestamp = strtotime($dateStr);
    $day = date('j', $timestamp);
    $month = date('M', $timestamp); // short month name e.g. Sep
    $year = date('Y', $timestamp);

    // Add ordinal suffix
    if (!in_array(($day % 100), [11, 12, 13])) {
        switch ($day % 10) {
            case 1:
                $suffix = 'st';
                break;
            case 2:
                $suffix = 'nd';
                break;
            case 3:
                $suffix = 'rd';
                break;
            default:
                $suffix = 'th';
        }
    } else {
        $suffix = 'th';
    }

    return "{$day}{$suffix} {$month} {$year}";
}
function generateRandomWeekdayDate($year, $month)
{

    // Get the number of days in the month 
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Array to store valid weekdays (Monday to Friday)
    $validWeekdays = [1, 2, 3, 4, 5]; // 1 = Monday, 2 = Tuesday, ..., 5 = Friday
    do {
        // Generate a random day within the month
        $day = mt_rand(1, $daysInMonth);
        // Get the day of the week for the generated date (0 = Sunday, 1 = Monday, ..., 6 = Saturday) 
        $dayOfWeek = date('w', strtotime("$year-$month-$day"));
    } while (!in_array($dayOfWeek, $validWeekdays));

    // Return the random date
    return "$year-$month-$day";
}
function inword($number)
{
    //$number = 190908100.25;

    $no = floor($number);
    $point = round($number - $no, 2) * 100;
    $hundred = null;
    $digits_1 = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        '0' => '',
        '1' => 'one',
        '2' => 'two',
        '3' => 'three',
        '4' => 'four',
        '5' => 'five',
        '6' => 'six',
        '7' => 'seven',
        '8' => 'eight',
        '9' => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' => 'nineteen',
        '20' => 'twenty',
        '30' => 'thirty',
        '40' => 'forty',
        '50' => 'fifty',
        '60' => 'sixty',
        '70' => 'seventy',
        '80' => 'eighty',
        '90' => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_1) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;

        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
        } else {
            $str[] = null;
        }
    }
    $str = array_reverse($str);
    $result = implode('', $str);
    $points = ($point) ?
        "." . $words[$point / 10] . " " .
        $words[$point = $point % 10] : '';

    if ($result == '') {
        $result = "Zero ";
    }
    if ($points == '') {
        $points = "Zero ";
    }
    $data = $result . "Rupees  " . $points . " Paise";
    return $data;
}

<?php

namespace App\Models;

use App\Models\AccountbookModel;
use CodeIgniter\Model;
use Dompdf\Dompdf;
use Dompdf\Options;

use ZipArchive;



class CronModel extends Model
{
    function run_cron_added($type, $company_session)
    {
        $m = [];
        if ($type == "Added") {
            if ($add_task = $this->get_task('Queued', $company_session)) {
                // $getAdded = $this->get_task('Running');
                $p = 0;
                if (empty($getAdded)) {
                    foreach ($add_task as $taskcreate) {
                        $st = $this->set_process_start($taskcreate['RowID']);
                        $data_set = array(
                            "TaskStatus" => "Running",
                            "ResultStatus" => "",
                        );
                        $this->set_process_end($taskcreate['RowID'], $data_set);
                        $p++;
                    }
                }

                $m[] = sprintf(" %s Task Queued Proceessed", $p);
            }
        }
        $p = 0;
        if ($type == "Running") {
            if ($add_task = $this->get_task('Running', $company_session, 0)) {

                foreach ($add_task as $taskcreate) {


                    $st = $this->set_process_start($taskcreate['RowID']);
                    if ($st > 0) {
                        $result = $this->Export_Task_Run($taskcreate);


                        if ($result['st'] == "success") {
                            $total = $result['total'];
                            $TaskResult = $total . " Row Created Successfully";
                            $data_set = array(
                                "TaskStatus" => $result['TaskStatus'],
                                "TotalData" => $total,
                                "CompleteData" => $result['CompleteData'],
                                "LastRowIndex" => $result['LastRowIndex'],
                                "highestRow" => $result['highestRow'],
                                "ResultStatus" => "success",
                                "TaskResult" => $TaskResult,
                                "process_count" => $result['process_count'],
                                "TaskActualCompleteTime" => (!empty($result['TaskActualCompleteTime'])) ? $result['TaskActualCompleteTime'] : '',
                            );
                            if (!empty($result['TaskActualStartTime'])) {
                                $data_set["TaskActualStartTime"] = $result['TaskActualStartTime'];
                            }
                            $this->set_process_end($taskcreate['RowID'], $data_set);
                        } else {
                            $TaskResult = array($result['txt']);
                            if ($taskcreate['TaskResult'] != '')
                                $TaskResult[] = json_decode($taskcreate['TaskResult'], true);
                            $data_set = array(
                                "TaskStatus" => "Failed",
                                "TotalData" => 0,
                                "CompleteData" => 0,
                                "IsError" => 1,
                                "ResultStatus" => "failed"
                            );
                            $this->set_process_end($taskcreate['RowID'], $data_set);
                        }
                        $p++;
                    }
                }

                $m[] = sprintf(" %s Task Running Proceessed", $p);
            }
        }

        $r = !empty($m) ? $m : false;
        return $r;
    }
    function get_task($status, $company_session, $pending = 1)
    {
        $db = $this->db;
        $builder = $db->table('task_export');
        $builder->select('*');
        $builder->where(array('TaskStatus' => $status, "IsActive" => 1, "IsDelete" => 0, "IsError" => 0, 'CompanySession' => $company_session));
        if ($pending) {
            $where = "TaskStartTime < '" . date('Y-m-d H:i:s') . "' ";
            $builder->where($where);
        }
        $where = ' ( IsProcessing = 0 or IsProcessing = 1 ) ';
        $builder->where($where);
        $builder->orderBy('Created asc');
        $builder->limit(1);
        $query = $builder->get();

        $query_data = $query->getResultArray();

        if (!empty($query_data)) {
            return $query_data;
        } else
            return false;
    }
    function set_process_start($RowId)
    {
        $db = $this->db;
        $db->setDatabase('manifest_erp');
        $builder = $db->table('task_export');
        $data = array(
            "IsProcessing" => 1,
            "LastStatusUpdateTime" => date('Y-m-d H:i:s'),
            "ResultStatus" => "Running"
        );
        $builder->where(array("RowID" => $RowId));

        $builder->update($data);
        $affected_rows = $db->affectedRows();
        return $affected_rows;
    }
    function set_process_end($RowId, $data)
    {
        $data["IsProcessing"] = 0;
        $data["LastStatusUpdateTime"] = date('Y-m-d H:i:s');
        $db = $this->db;
        $db->setDatabase('manifest_erp');
        $builder = $db->table('task_export');
        $builder->where(array("RowID" => $RowId));
        $builder->update($data);
        $affected_rows = $db->affectedRows();
        return $affected_rows;
    }
    function Export_Task_Run($data)
    {
        $amodel = new AccountbookModel();
        if ($data['TaskType'] == 'purchase_register') {
            $data_r = $amodel->get_purchase_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'sales_register') {
            $data_r = $amodel->get_sales_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'creditnote_register') {
            $data_r = $amodel->get_creditnote_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'debitnote_register') {
            $data_r = $amodel->get_debitnote_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'payment_register') {
            $data_r = $amodel->get_payment_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'receipt_register') {
            $data_r = $amodel->get_receipt_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'contra_register') {
            $data_r = $amodel->get_contra_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'jv_register') {
            $data_r = $amodel->get_jv_register_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'salesgst_register') {
            $data_r = $amodel->get_salesgst_reg_data_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'purchasegst_register') {
            $data_r = $amodel->get_purchasegst_reg_data_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'creditnotegst_register') {
            $data_r = $amodel->get_creditnotegst_reg_data_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'debitnotegst_register') {
            $data_r = $amodel->get_debitnotegst_reg_data_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'hsn_core_data') {
            $data_r = $amodel->get_hsncoredata_excel($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'cash_voucher') {
            $data_r = $this->generate_cashvoucher_pdf($data);
            $result = $data_r;
        }
        if ($data['TaskType'] == 'cash_voucher_no') {
            $data_r = $this->generate_cashvoucher_no($data);
            $result = $data_r;
        }
        if ($result) {
            return $result;
        } else {
            return array('st' => 'failed');
        }
    }
    public function generate_cashvoucher_pdf($task_data)
    {

        $voucher_id_array = json_decode($task_data['VoucherId']);
        $total_data = $task_data['TotalData'];
        $CompleteData = $task_data['CompleteData'];
        $process_data = $CompleteData + 10;
        $process_count = $task_data['process_count'];
        $company_session = $task_data['CompanySession'];
        $total_processing = $CompleteData;

        $db = $this->db;
        $db->setDatabase('manifest_erp');
        $builder = $db->table('company')
            ->where(array('code' => $company_session));
        $query = $builder->get();
        $company_data = $query->getRowArray();
        if (count($voucher_id_array) < 10) {
            $voucher_array = $voucher_id_array;
        } else {
            for ($i = $CompleteData; $i < $process_data; $i++) {

                if ($i < $total_data) {
                    $voucher_array[] = @$voucher_id_array[$i];
                }
            }
        }

        $array_count = count($voucher_array);

        $length = $array_count / 2;
        $db = db_connect();
        $db->setDatabase($company_session);


        for ($i = 0; $i < $length; $i++) {
            $new_data = array();
            $CompleteData += 2;
            $voucherindex = $i * 2;

            if (!empty($voucher_array[$voucherindex])) {
                $index_name = isset($voucher_array[$voucherindex]) ? ('_' . $voucher_array[$voucherindex]) : '';
                $data = $db->table('bank_tras')->where(array('id' => $voucher_array[$voucherindex]))->get(1)->getRowArray();

                $particular = $db->table('account')->where(array('id' => $data['particular']))->get(1)->getRowArray();

                $account = $db->table('account')->where(array('is_delete' => 0, 'id' => $data['account']))->get(1)->getRowArray();
                if ($company_session == 'KLA2022ZFDH') {
                    $data['particular_name'] = @$particular['alias'];
                    $data['account_name'] = @$account['alias'];
                } else {
                    $data['particular_name'] = @$particular['name'];
                    $data['account_name'] = @$account['name'];
                }

                $narration = explode("-", $data['narration']);
                $pay_to = @$narration[0];
                $being = @$narration[1];
                //echo '<pre>';Print_r($data);
                
                $data['particular_name'] = "<lable class=''>" . $particular['name'] . "</lable>";
                $data['amount_in_word'] = "<lable class='' style='text-transform: capitalize;'>" . inword(@$data['amount']) . "</lable>";
                $data['pay_to'] = "<lable class=''>" . $pay_to . "</lable>";
                $data['being'] = "<lable class=''>" . $being . "</lable>";
                $data['above_sum_of'] = "<lable class=''>" . $data['amount'] . "</lable>";
                $data['account_name'] = "<lable class=''>" . $account['name'] . "</lable>";
                $data['company_name'] = "<lable class=''>" . $company_data['name'] . "</lable>";
                $data['company_address'] = "<lable class=''>" . $company_data['address'] . "</lable>";
                $new_data['voucher'][] = $data;
                $builder = $db->table('bank_tras');
                $builder->where(array("id" => $voucher_array[$voucherindex]));
                $result = $builder->Update(array('is_pdf_generate' => 1));
                $total_processing += 1;
            }
            if (!empty($voucher_array[$voucherindex + 1])) {
                $index_name1 = isset($voucher_array[$voucherindex + 1]) ? ('_' . $voucher_array[$voucherindex + 1]) : '';

                $data = $db->table('bank_tras')->where(array('is_delete' => 0, 'id' => $voucher_array[$voucherindex + 1]))->get(1)->getRowArray();
                $particular = $db->table('account')->where(array('id' => $data['particular']))->get(1)->getRowArray();
                $account = $db->table('account')->where(array('id' => $data['account']))->get(1)->getRowArray();
                if ($company_session == 'KLA2022ZFDH') {
                    $data['particular_name'] = @$particular['alias'];
                    $data['account_name'] = @$account['alias'];
                } else {
                    $data['particular_name'] = @$particular['name'];
                    $data['account_name'] = @$account['name'];
                }

               
                
                $narration = explode("-", $data['narration']);
                $pay_to = @$narration[0];
                $being = @$narration[1];
               // echo '<pre>';Print_r($data);exit;
                

                $data['particular_name'] = "<lable class=''>" . $particular['name'] . "</lable>";
                $data['amount_in_word'] = "<lable class='' style='text-transform: capitalize;'>" . inword(@$data['amount']) . "</lable>";
                $data['pay_to'] = "<lable class=''>" . $pay_to . "</lable>";
                $data['being'] = "<lable class=''>" . $being . "</lable>";
                $data['above_sum_of'] = "<lable class=''>" . $data['amount'] . "</lable>";
                $data['account_name'] = "<lable class=''>" . $account['name'] . "</lable>";
                $data['company_name'] = "<lable class=''>" . $company_data['name'] . "</lable>";
                $data['company_address'] = "<lable class=''>" . $company_data['address'] . "</lable>";
                $builder = $db->table('bank_tras');
                $builder->where(array("id" => $voucher_array[$voucherindex + 1]));
                $result = $builder->Update(array('is_pdf_generate' => 1));
                $new_data['voucher'][] = $data;
                $total_processing += 1;
            }
         
            $html =  view('pdf/cash_voucher_pdf', $new_data);
          
           
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $pdfContent = $dompdf->output();

            // Specify the folder where you want to save the PDF
            $folderPath = getcwd() . $task_data['TaskExcelPath'];

            // Specify the PDF file name
            $pdfFileName = 'cash_voucher_' . rand(111, 999) . $index_name . '' . @$index_name1 . '.pdf';

            // Save the PDF to the folder
            file_put_contents($folderPath . $pdfFileName, $pdfContent);

            //update pdf_generate in bank_tras table
            // $db = db_connect();
            // $db->setDatabase($company_session);
            // $update_data = $db->table('bank_tras')->where(array('id' => $voucher_array[$voucherindex]))->Update(array('is_pdf_generate' => 1));
            // $update_data1 = $db->table('bank_tras')->where(array('id' => $voucher_array[$voucherindex +1]))->Update(array('is_pdf_generate' => 1));

        }

        if ($total_data <= $CompleteData) {
            $TaskStatus = 'Complete';

            $the_folder = getcwd() . $task_data['TaskExcelPath'];
            $path_array = explode('/', $the_folder);

            // $zip_file_name = $path_array[5] . '/' . $path_array[6] . '/' . $path_array[7] . '/' . $path_array[8] . '/' . $path_array[9] . '.zip';
            $zip_file_name = $task_data['FileName']; 
            $za = new ZipArchive;
            $res = $za->open($zip_file_name, ZipArchive::CREATE);
            $BASE_PATH = $the_folder;
            $index_data = round($total_data/2);
            
            if ($res === TRUE) {
                foreach (glob($BASE_PATH . "*.pdf") as $filename) {
                    //$za->addFile($filename, $za->getNameIndex($index_data));
                    $za->addFile($filename, basename($filename));
                }
                $za->close();
            }
        } else {
            $TaskStatus = 'Running';
        }
        $data_result = array(
            "st" => "success",
            "txt" => "success",
            "TotalData" => $total_data,
            "total" => $total_data,
            "highestRow" => $total_processing,
            "TaskStatus" => $TaskStatus,
            "CompleteData" => $total_processing,
            "process_count" => $process_count + 1,
            "LastRowIndex" => $total_processing,
            "TaskActualStartTime" =>  $process_count == 0 ? date('Y-m-d H:i:s') : '',
            "TaskActualCompleteTime" => $TaskStatus == 'Complete' ? date('Y-m-d H:i:s') : '',
        );
        return $data_result;
    }
    public function generate_cashvoucher_no($task_data)
    {

        $voucher_id_array = json_decode($task_data['VoucherId']);
        $total_data = $task_data['TotalData'];
        $CompleteData = $task_data['CompleteData'];
        $process_data = $CompleteData + 200;
        $process_count = $task_data['process_count'];
        $company_session = $task_data['CompanySession'];
        $total_processing = $CompleteData;

        $db = $this->db;
        $db->setDatabase('manifest_erp');
        $builder = $db->table('company')
            ->where(array('code' => $company_session));
        $query = $builder->get();
        $company_data = $query->getRowArray();

        $db->setDatabase($task_data['CompanySession']);
        $builder = $db->table('bank_tras')
            ->where('is_generate_voucherno',0)
            ->whereIn('id', $voucher_id_array)
            ->orderBy('receipt_date', 'asc');
        $query6 = $builder->get();
        $voucher_array = $query6->getResultArray();
    
        $rowcount = count($voucher_array);

        for ($i = 0; $i < $rowcount; $i++) {
                $total_processing += 1;
                $time = strtotime($voucher_array[$i]['receipt_date']);
                $month_no = date("m", $time);
                $year_full = date("Y", $time);
                $year_half = date("y", $time);

                $builder = $db->table('bank_tras')
                    ->select('*')
                    ->where(array('is_delete' => '0', 'payment_type' => 'cash', 'month' => $month_no, 'year' => $year_full, 'is_manualy' => 0, 'is_generate_voucherno' => 1))
                    ->orderBy('series', 'desc');
                    $query = $builder->get();
                $voucher_data = $query->getRowArray();
              
                if (!empty($voucher_data)) {
                    if (!empty($voucher_data['voucher_no'])) {
                      
                        $new_num = $voucher_data['series'] + 1;
                        $s_number = str_pad($new_num, 4, "0", STR_PAD_LEFT);
                    } else {
                        $s_number = str_pad(0001, 4, "0", STR_PAD_LEFT);
                    }
                } else {
                    $s_number = str_pad(0001, 4, "0", STR_PAD_LEFT);
                }
                if ($task_data['CompanySession'] == 'ACE20227T93') {
                    $voucher_no = 'AI/CASH/' . $month_no . $year_half . '/' . $s_number;
                } elseif ($task_data['CompanySession'] == 'KLA2022ZFDH') {
                    $voucher_no = 'KE/CASH/' . $month_no . $year_half . '/' . $s_number;
                } elseif ($task_data['CompanySession'] == 'CGL2023N6EX') {
                    $voucher_no = 'CL/CASH/' . $month_no . $year_half . '/' . $s_number;
                } elseif ($task_data['CompanySession'] == 'KLA2022NRMY') {
                    $voucher_no = 'KA/CASH/' . $month_no . $year_half . '/' . $s_number;
                } else {
                    $voucher_no = "";
                }
               
                $pdata = array(
                    'month' => $month_no,
                    'year' => $year_full,
                    'series' =>  $s_number,
                    'voucher_no' => $voucher_no,
                    'is_generate_voucherno' => 1,
                );
               
                $builder->where(array("id" => $voucher_array[$i]['id']));
                $result = $builder->Update($pdata);
               
        }


        if ($total_data <= $rowcount) {
            $TaskStatus = 'Complete';
        } else {
            $TaskStatus = 'Running';
        }
        $data_result = array(
            "st" => "success",
            "txt" => "success",
            "TotalData" => $rowcount,
            "total" => $rowcount,
            "highestRow" => $total_processing,
            "TaskStatus" => $TaskStatus,
            "CompleteData" => $rowcount,
            "process_count" => $process_count + 1,
            "LastRowIndex" => $total_processing,
            "TaskActualStartTime" =>  $process_count == 0 ? date('Y-m-d H:i:s') : '',
            "TaskActualCompleteTime" => $TaskStatus == 'Complete' ? date('Y-m-d H:i:s') : '',
        );
        return $data_result;
    }
}

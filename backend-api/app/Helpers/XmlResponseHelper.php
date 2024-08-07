<?php

namespace App\Helpers;

use App\Models\Bill;
use Illuminate\Database\QueryException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class XmlResponseHelper
{
    
    public static function handleContrlNoResponse($contrlNo_Gepg_res){

        $gepg_response = GeneralCustomHelper::contrNoXmlResToArray($contrlNo_Gepg_res);
        $BillId = $gepg_response['BillId'];

        if (strlen($BillId) < 3) {
            $serial = date("YmdHis");
        } else {
            $serial = $BillId;
        }
        // Log::info('RECPAY-GEPG-REQUEST', [$contrlNo_Gepg_res, $serial, 'GEPG']);
        $varray = print_r($gepg_response, true);
        Log::info("\n\n---------------GEPG Control number \n", [$varray, $serial, "\n -------GEPG"]);

        $ResStsCode = $gepg_response['ResStsCode'];
        $codes = explode(';', $ResStsCode);

        /// save data based on Request

        //--- Consuming Gepg Response 
            try {
                $exists = Bill::where('id', $BillId)->exists();
                if($exists){
                    $theBill = Bill::where('id',$BillId)->first();
                        if (in_array('7101', $codes) OR in_array('7226', $codes)) {
                            //"UPDATE billing SET updated_at='$date',gepgstatus='$ResStsCode',controlno='$controlno' WHERE billid='$billid'");
                            $ResStsCode = 'GEPG-OK';
                            $cust_cntr_num = $gepg_response['CustCntrNum'];
                            $theBill->status_code = $ResStsCode;
                            $theBill->cust_cntr_num = $cust_cntr_num;
                            $theBill->save();            
                        }
                        else {
                            // "UPDATE billing SET gepgstatus='$ResStsCode' WHERE billid='$billid'");
                            $theBill->status_code = $ResStsCode;
                            $theBill->save();  
                        }
                         // Signing response
                        return GeneralCustomHelper::signedBillAck($gepg_response['ResId'],7101);
                        // Log::info('RECPAY-GEPG-RESPONSE', [$response, $serial, 'GEPG']);
                }
                
            } catch (QueryException $e) {
                // Handle the exception
                echo "Error occurred: " . $e->getMessage();
                // Optionally, log the error
                Log::error('Database query error', ['exception' => $e]);
                return GeneralCustomHelper::signedBillAck($gepg_response['ResId'],7303);
            }

    }

    public static  function handlePaymentReceipt($Gepg_res_Payment){

        $gepg_pay_res = GeneralCustomHelper::paymentXmlToArray($Gepg_res_Payment);
        $BillId = $gepg_pay_res['BillId'];
        // Log::info('RECPAY-GEPG-REQUEST', [$contrlNo_Gepg_res, $serial, 'GEPG']);
        $varray = print_r($gepg_pay_res, true);
        Log::info("\n\n---------------GEPG Payment Response \n", [$varray , "\n -------"]);
        //--- Consuming Gepg Response 
            try {
                $exists = Bill::where('id', $BillId)->exists();
                if($exists){
                    $theBill = Bill::where('id',$BillId)->first();
                            $ResStsCode = 'GEPG-PAID';
                            //"UPDATE billing SET gepgstatus='PAID' WHERE billid='$billid'");
                            $date = Carbon::now();
                            $theBill->status_code = $ResStsCode;
                            $theBill->paid_date = $date;
                            $theBill->sp_code  = $gepg_pay_res['SpCode'];
                            $theBill->entry_cnt  = $gepg_pay_res['EntryCnt'];
                            $theBill->GrpBillId  = $gepg_pay_res['GrpBillId'];
                            $theBill->SpGrpCode  = $gepg_pay_res['SpGrpCode'];
                            $theBill->psp_code  = $gepg_pay_res['PspCode'];
                            $theBill->psp_name  = $gepg_pay_res['PspName'];
                            $theBill->trx_id  = $gepg_pay_res['TrxId'];
                            $theBill->pay_ref_id  = $gepg_pay_res['PayRefId'];
                            $theBill->bill_amt  = $gepg_pay_res['BillAmt'];
                            $theBill->paid_amt  = $gepg_pay_res['PaidAmt'];
                            $theBill->bill_pay_opt  = $gepg_pay_res['BillPayOpt'];
                            $theBill->ccy  = $gepg_pay_res['Ccy'];
                            $theBill->coll_acc_num  = $gepg_pay_res['CollAccNum'];
                            $theBill->trx_dt_tm  = $gepg_pay_res['TrxDtTm'];
                            $theBill->usd_pay_chnl  = $gepg_pay_res['UsdPayChnl'];
                            $theBill->trd_pty_trx_id  = $gepg_pay_res['TrdPtyTrxId'];
                            $theBill->pyr_cell_num  = $gepg_pay_res['PyrCellNum'];
                            $theBill->pyr_name  = $gepg_pay_res['PyrName'];
                            $theBill->pyr_email  = $gepg_pay_res['PyrEmail'];
                            $theBill->rsv1  = $gepg_pay_res['Rsv1'];
                            $theBill->rsv2  = $gepg_pay_res['Rsv2'];
                            $theBill->rsv3  = $gepg_pay_res['Rsv3'];
                            $theBill->status = 1;
                            $theBill->save();
                         // Signing response
                         Log::info("\n\n-------- ** Payment Updated \n", ["------- \n "]);
                        return GeneralCustomHelper::signedPayemtAck($gepg_pay_res['ReqId'],7101);
                        // Log::info('RECPAY-GEPG-RESPONSE', [$response, $serial, 'GEPG']);
                }else{
                    Log::info("\n\n-------- Bill Not Found \n", ["------- \n "]);
                    return GeneralCustomHelper::signedPayemtAck($gepg_pay_res['ReqId'],7303);

                }
                
            } catch (QueryException $e) {
                // Handle the exception
                echo "Error occurred: " . $e->getMessage();
                // Optionally, log the error
                Log::error('Database query error', ['exception' => $e]);
                return GeneralCustomHelper::signedPayemtAck($gepg_pay_res['ReqId'],7303);
            }

    }
        
    public static  function handleReconcileReceipt($Gepg_res_Reconcile){

        $gepg_reconcile_res = GeneralCustomHelper::reconcileResXmlToArray($Gepg_res_Reconcile);
        return $gepg_reconcile_res;
        $BillId = $gepg_reconcile_res['BillId'];
        // Log::info('RECPAY-GEPG-REQUEST', [$contrlNo_Gepg_res, $serial, 'GEPG']);
        $varray = print_r($gepg_reconcile_res, true);
        Log::info("\n\n---------------GEPG Payment Response \n", [$varray , "\n -------"]);
        //--- Consuming Gepg Response 
            try {
                $exists = Bill::where('id', $BillId)->exists();
                if($exists){
                    $theBill = Bill::where('id',$BillId)->first();
                            $ResStsCode = 'GEPG-PAID';
                            //"UPDATE billing SET gepgstatus='PAID' WHERE billid='$billid'");
                            $date = Carbon::now();
                            $theBill->status_code = $ResStsCode;
                            $theBill->paid_date = $date;
                            $theBill->sp_code  = $gepg_reconcile_res['SpCode'];
                            $theBill->entry_cnt  = $gepg_reconcile_res['EntryCnt'];
                            $theBill->GrpBillId  = $gepg_reconcile_res['GrpBillId'];
                            $theBill->SpGrpCode  = $gepg_reconcile_res['SpGrpCode'];
                            $theBill->psp_code  = $gepg_reconcile_res['PspCode'];
                            $theBill->psp_name  = $gepg_reconcile_res['PspName'];
                            $theBill->trx_id  = $gepg_reconcile_res['TrxId'];
                            $theBill->pay_ref_id  = $gepg_reconcile_res['PayRefId'];
                            $theBill->bill_amt  = $gepg_reconcile_res['BillAmt'];
                            $theBill->paid_amt  = $gepg_reconcile_res['PaidAmt'];
                            $theBill->bill_pay_opt  = $gepg_reconcile_res['BillPayOpt'];
                            $theBill->ccy  = $gepg_reconcile_res['Ccy'];
                            $theBill->coll_acc_num  = $gepg_reconcile_res['CollAccNum'];
                            $theBill->trx_dt_tm  = $gepg_reconcile_res['TrxDtTm'];
                            $theBill->usd_pay_chnl  = $gepg_reconcile_res['UsdPayChnl'];
                            $theBill->trd_pty_trx_id  = $gepg_reconcile_res['TrdPtyTrxId'];
                            $theBill->pyr_cell_num  = $gepg_reconcile_res['PyrCellNum'];
                            $theBill->pyr_name  = $gepg_reconcile_res['PyrName'];
                            $theBill->pyr_email  = $gepg_reconcile_res['PyrEmail'];
                            $theBill->rsv1  = $gepg_reconcile_res['Rsv1'];
                            $theBill->rsv2  = $gepg_reconcile_res['Rsv2'];
                            $theBill->rsv3  = $gepg_reconcile_res['Rsv3'];
                            $theBill->status = 1;
                            $theBill->save();
                         // Signing response
                         Log::info("\n\n-------- ** Payment Updated \n", ["------- \n "]);
                        return GeneralCustomHelper::signedBillAck($gepg_reconcile_res['ReqId'],7101);
                        // Log::info('RECPAY-GEPG-RESPONSE', [$response, $serial, 'GEPG']);
                }else{
                    Log::info("\n\n-------- Bill Not Found \n", ["------- \n "]);
                    return GeneralCustomHelper::signedBillAck($gepg_reconcile_res['ReqId'],7303);

                }
                
            } catch (QueryException $e) {
                // Handle the exception
                echo "Error occurred: " . $e->getMessage();
                // Optionally, log the error
                Log::error('Database query error', ['exception' => $e]);
                return GeneralCustomHelper::signedBillAck($gepg_reconcile_res['ReqId'],7303);
            }

    }
        
}

<?php

namespace App\Exports;

use App\Models\Bill;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PaymentsExport implements FromCollection , WithHeadings{
    public function collection()
    {
        // return Bill::where('status', 1) -> select(
        //     "reference_no",
        //     "SpGrpCode",
        //     "phone_number",
        //     "payee_name",
        //     "customer_name",
        //     "name",
        //     "GfsCode",
        //     "tin_number",
        //     "bank_name",
        //     "account_number",
        //     "billGeneratedBy",
        //     "amount",
        //     "remarks",
        //     "email",
        //     "cust_cntr_num",
        //     "entry_cnt",
        //     "sp_code",
        //     "bill_ctr_num",
        //     "psp_name",
        //     "trx_id",
        //     "pay_ref_id",
        //     "bill_amt",
        //     "paid_amt",
        //     "bill_pay_opt",
        //     "ccy",
        //     "coll_acc_num",
        //     "trx_dt_tm",
        //     "usd_pay_chnl",
        //     "trd_pty_trx_id",
        //     "qt_ref_id",
        //     "pyr_cell_num",
        //     "pyr_email",
        //     "pyr_name",
        //     "status",
        //     "paid_date",
        //     "status_code",
        //     "status_description",
        //     "bill_exp",
        //  )->get();
        return  User::join(
            'user_infos', 'users.id', '=', 'user_infos.user_id')
        ->select(
            "users.firstName", 
            "users.middleName",
            "users.lastName", 
            "users.email",
            "user_infos.phoneNumber", // Example additional field
            "user_infos.institution",       // Example additional field
            "user_infos.position",     // Example additional field
            // "user_infos.nation",     // Example additional field
        ) ->get();
    }
    public function headings(): array
    {
        // return [
        //     "reference_no",
        //     "SpGrpCode",
        //     "phone_number",
        //     "payee_name",
        //     "customer_name",
        //     "name",
        //     "GfsCode",
        //     "tin_number",
        //     "bank_name",
        //     "account_number",
        //     "billGeneratedBy",
        //     "amount",
        //     "remarks",
        //     "email",
        //     "cust_cntr_num",
        //     "entry_cnt",
        //     "sp_code",
        //     "bill_ctr_num",
        //     "psp_name",
        //     "trx_id",
        //     "pay_ref_id",
        //     "bill_amt",
        //     "paid_amt",
        //     "bill_pay_opt",
        //     "ccy",
        //     "coll_acc_num",
        //     "trx_dt_tm",
        //     "usd_pay_chnl",
        //     "trd_pty_trx_id",
        //     "qt_ref_id",
        //     "pyr_cell_num",
        //     "pyr_email",
        //     "pyr_name",
        //     "status",
        //     "paid_date",
        //     "status_code",
        //     "status_description",
        //     "bill_exp",
        // ];
        return [

        ];
    }   
}



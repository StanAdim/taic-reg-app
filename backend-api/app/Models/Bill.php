<?php

namespace App\Models;

use App\Models\Taic\Conference;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory, HasUuids;
    protected $keyType = 'string';
    public $incrementing = false;    
    protected $fillable = [
        'reference_no',
        'conference_id',
        'event_fee',
        'ReqId',
        'GfsCode',
        'GrpBillId',
        'SpGrpCode',
        'phone_number',
        'payee_name',
        'customer_name',
        'name',
        'tin_number',
        'callback_url',
        'bank_name',
        'account_number',
        'event_id',
        'amount',
        'remarks',
        'req_id',
        'email',
        'grp_bill_id',
        'sp_grp_code',
        'cust_cntr_num',
        'entry_cnt',
        'sp_code',
        'bill_id',
        'bill_ctr_num',
        'billGeneratedBy',
        'billApproveBy',
        'psp_code',
        'psp_name',
        'trx_id',
        'pay_ref_id',
        'bill_amt',
        'paid_amt',
        'bill_pay_opt',
        'ccy',
        'currency',
        'rate',
        'coll_acc_num',
        'trx_dt_tm',
        'bill_exp',
        'usd_pay_chnl',
        'trd_pty_trx_id',
        'qt_ref_id',
        'pyr_cell_num',
        'pyr_email',
        'pyr_name',
        'rsv1',
        'rsv2',
        'rsv3',
        'status',
        'paid_date',
        'status_code',
        'status_description',
        'callback_token',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Conference::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PRFBody extends Model
{
    //
    protected $table = 'prf_body';

    protected $fillable = [
        'prf_header_id',
        'location_id',
        'account_id',
        'brand_id',
        'currency_id',
        'invoice_number',
        'invoice_date',
        'invoice_type_id',
        'payment_status_id',
        'vat_type_id',
        'interco_id',
        'product_id',
        'category_id',
        'particulars',
        'quantity',
        'line_value',
        'total_value',
        'error',
        'row_deleted',
        'coa'
    ];
}

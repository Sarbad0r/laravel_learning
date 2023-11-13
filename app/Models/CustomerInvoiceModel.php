<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInvoiceModel extends Model
{
    use HasFactory;

    protected $table = 'customer_invoice';

    static $specific_fields = [
        'id', 'customer_id', 'status',
        'qty', 'total', 'invoice_datetime', 'invoice_datetime',
        'invoice_date', 'invoice_time',
    ];

    static public function get_with_fields()
    {
        return self::get(self::$specific_fields);
    }

    static public function get_only_specific_customer_invoices($id = null)
    {
        if (!$id) return self::get();

        // when you want to use other static function with your request 
        // first use that functions then your request 
        return self::get_with_fields()->where('customer_id', $id)->values();
    }
}

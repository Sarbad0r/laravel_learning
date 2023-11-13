<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerModle extends Model
{
    use HasFactory;

    protected $table = "customers";


    static $customer_primary_fields =
    [
        'id',
        'first_name',
        'middle_name',
        'last_visit',
        'mobile',
        'created_at'
    ];

    static public function get_with_fields()
    {
        return self::get(self::$customer_primary_fields);
    }

    static public function get_speciffic_customer($id = null)
    {
        if (!$id) return null;

        return self::get_with_fields()->where('id', $id)->values();
    }
}

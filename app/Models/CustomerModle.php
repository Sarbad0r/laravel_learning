<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CustomerModle extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = "customers";


    // The primary key associated with the table.
    protected $primaryKey = "id";

    protected $guarded = ['id'];

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

    public function customer_invoices()
    {
        return $this->hasMany(CustomerInvoiceModel::class, 'customer_id');
    }
}

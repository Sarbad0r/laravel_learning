<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteModel extends Model
{
    use HasFactory;

    protected $table = 'delete_table';

    public $timestamps = false;

    //while you creating model and factory
    //do not forget to create same name model and factory
    //for example: Model's name is "DeleteModel"
    //factory name should be "DeleteModelFactory"
}

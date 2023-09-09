<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeleteModelResource;
use App\Models\DeleteModel;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class LaravelSanctumLearningController extends Controller
{
    use HttpResponses; //for using our "trait" file which is placed in app/Traits/HttpResponses
    //we will use that trais using "$this" keyword



    public function returnSuccess()
    {
        return $this->success(['ok' => "ok"], "successfully", 200);
    }

    public function returnError()
    {
        return $this->error(['ok' => "not_ok"], 'error', 201);
    }

    //for creating factories
    public function createFactories()
    {
        DeleteModel::factory()->times(30)->create();
    }


    public function get_delete_models_resources()
    {

        //if you want to get models with specify columns
        //just create resources for it
        //first run "php artisan make:resource YourModelResource"

        //then use like this to get columns
        //it replaces "select" keyword
        $deleted_model_resources =  DeleteModelResource::collection(
            DeleteModel
                ::join('users', 'delete_table.user_id', 'users.id')
                ->where('user_id', 22)
                ->get()
        );

        return $this->success($deleted_model_resources);
    }
}
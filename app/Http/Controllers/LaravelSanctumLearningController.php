<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeleteModelResource;
use App\Models\DeleteModel;
use App\Models\User;
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

    public function get_user_methods()
    {
        $query_by_static_method_of_class = User
            ::get_users_with_updated_at_in_static_method()
            ->get();

        //we can't call "simple not static methods" of class like above

        // instead of it we call the object of class than use the method of it

        // remember that you also can call static methods of class by creating the object of class

        $object_of_class = new User();

        $object_of_class->get_users_with_updated_at_in_simple_func();

        //static methods can be call too
        $object_of_class->get_users_with_updated_at_in_static_method();
    }
}

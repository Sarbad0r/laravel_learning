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


    public function laravel_collections()
    {


        //В Laravel, методы get и all используются для получения данных из базы данных, но они имеют некоторые различия:

        // get:
        // get является методом объекта запроса (QueryBuilder), и его обычно используют вместе с методами для построения запросов, такими как select, where, orderBy и так далее.
        // get возвращает коллекцию (обычно Illuminate\Support\Collection), содержащую результаты запроса.
        // Обычно вы будете использовать get для выполнения сложных запросов к базе данных.


        //all:
        // all является методом Eloquent модели и используется, когда у вас уже есть экземпляр модели и вы хотите получить все записи для этой модели без дополнительных условий.
        // all возвращает коллекцию Eloquent моделей.


        //основное различие заключается в том, что get используется для выполнения запросов и 
        // возвращает коллекцию, тогда как all используется для получения всех записей для
        //  конкретной модели и также возвращает коллекцию моделей.


        // the "all()" method returns the array of collections
        $all = User::all();

        // the "average('field')" method returns the middle value of something through given key
        // if you have array of values -> [10,10,20,40] if returns 20. (10 + 10 + 10 + 40) / 4
        // 4 is the array length 
        $average = User::average('id');

        //also you can write average like thie method down below
        $avg = User::avg('id');


        //The "chunk()" method breaks the collection into multiple, smaller collections of a given size
        //you should you use it after getting array of collections 
        $chunk = User::get()->chunk(2);


        // the "collapse()" method collect several arrays into one array
        $user_limit_10 = User::get()->take(10);
        $user_limit_5 = User::get()->take(5);
        $collections_of_users = collect([$user_limit_10, $user_limit_5]);
        $collapse = $collections_of_users->collapse();
        ////


        // method "collect()" return new copy of collections with the items currently in the collection:
        $collect = $collapse->collect();


        // method "concat()" addes all array or collection's values to the end of another array
        // this method combines two or more tables values
        $another_table = DeleteModel::get();
        $concat = $another_table->concat($all);



        // method "contains()" returns false or true by checking something in it
        $contains = $all->contains(function ($value, int $index) {
            return $value->user_name == 'Zena Hickle'; //true
        });
        //also there is another method same like "contains()" method but that checks everything 
        //very strictly -> (жестко)
        $contains_strictly = $all->containsStrict(function ($value, int $index) {
            return $value->user_name == 'Zena Hickle'; //true
        });
        //also there is another opposite method for checking values
        $doesnt_contain = $all->doesntContain(function ($value, int $index) {
            return $value->user_name == 'Zena Hickle'; //false, because it contains value
        });


        //to get length of array or collections use -> "count()"
        $count = $all->count();


        //method "each()" iterates every element in array
        $each = $all->each(function ($item, $index) {
            $item->some_value = $index + 1;
        });
        //or if you want to delete something
        // $each_methods = $all->collect()->each(function ($item, int $index) {
        //     unset($item['created_at'], $item['updated_at']);
        // });
        //


        //method "every()" checks whether every element equals to something. It returns false or true
        $every = $all->every(function ($item, $key) {
            return $item->some_value == 1;
        });


        // method "filter()" filters collection and return those element which pass a given truth test
        // it gives us object with keys that is why you should to use "->values()" to give only values
        $filter = $all->filter(function ($item, $index) {
            return $item->some_value > 10;
        })->values();


        // method "firstWhere()" return first collection from list of collections using "where" checker
        $first_whrere = $all->firstWhere('some_value', 10);



        // it gets every field of object in array and makes from them string
        // for example if you have name in object and object is in array 
        // -> "Zena Hickle, Fleta Spencer Sr., Gerald Pfeffer, Keegan Kemmer,"
        //like "join(', ')" in Dart
        $implode = $all->implode('user_name', ', ');


        //checks whether array is empty
        $is_empty = $all->isEmpty();


        //check whether array is not empty
        $is_not_empty = $all->isNotEmpty();


        //keyBy
        $keyBy = $all->keyBy('id');


        //method "keys()" gets keys and put them into array from key-value data
        $keys = $keyBy->keys();


        // method last return last element from array of collections

        $last = $all->last();

        //also you can write last as function and it returns last element which is true
        $last_method = $all->last(function ($item, int $index) {
            return $item->some_value >= 10 && $item->some_value <= 15;
        });


        //"map()" also does same thing as "each()" method. But unlike "each()" it should return something after changing or doing some stuff.
        $map = $all->map(function ($item, int $index) {
            $item->new_value = $index / 2 == 0 ? 1 : 0;
            return $item;
        })->all();


        $users = User
            ::leftJoin('delete_table', 'users.id', 'delete_table.user_id')
            ->where('created_at', '<', date('Y-m-d'))
            ->get();

        $users->map(function ($item) {
            $item->any = true;
        });

        $check_whether_all_user_has_created_at = $users->every(function ($item) {
            return $item->created_at;
        });



        return $users->isEmpty();
    }
}

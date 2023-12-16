<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeleteModelResource;
use App\Models\CustomerInvoiceModel;
use App\Models\CustomerModle;
use App\Models\DeleteModel;
use App\Models\User;
use App\Traits\HttpResponses;
use Bepsvpt\Blurhash\Facades\BlurHash;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

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


    public function create_token()
    {

        // to change token expiration datetime go -> config/sunctum.php
        //
        //https://laravel.com/docs/10.x/sanctum#token-expiration  

        $customer = CustomerModle::first();

        $token = $customer->createToken("TOKEN_NAME")->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function create_token_with_ability()
    {
        $customer = CustomerModle::first();

        // token ability: for ex: you have just simple users and pro users
        // simple users will not have ability to request or do something if the have not ability
        // you can write abilitis in array
        // for convenience, other token which will be created without abilities will return "true" by default
        // we can say that this ability will work only for current created token, other tokens will return true by default

        // that is why if you will you this, you should delete previous tokens and set new one

        // https://laravel.com/docs/10.x/sanctum#token-abilities

        $token = $customer->createToken("TOKEN_NAME", [
            'any:ability',
            'any:other-ability'
        ])->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function all_user_tokens(Request $request)
    {
        $user = $request->user();

        return $user->tokens;
    }

    public function token_can_do_any_abilities(Request $request)
    {
        if ($request->user()->tokenCan('any:ability')) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function deleting_tokens(Request $request)
    {
        // for deleting all tokens;
        $request->user()->delete();

        // for deleting current sending token through the bearer token 
        $request->user()->currentAccessToken()->delete();

        // and if you want to delete specific token use this one:

        $tokenId = 100;
        $request->user()->tokens()->where('id', $tokenId)->delete();
    }

    public function update_than_get_freshed_data()
    {
        $customer = CustomerModle::where('id', 5)->first();

        CustomerModle::where('id', 5)->update(['first_name' => "ok3"]);

        return $customer->fresh();
    }

    public function get_rejecting_some_collection()
    {
        $customers = CustomerModle::get();

        $customers = $customers->reject(function (CustomerModle $item) {
            return $item->first_name == 'Avaz';
        });

        // return CustomerModle::firstWhere('id', 1);

        return $customers->values();
    }


    public function check_if_model_changed_during_code()
    {
        $customer = CustomerModle::find(2);

        // if model will be changed during code
        $customer->update([
            'first_name' => "Avaz"
        ]);

        // this wasChanged() model's function will check if model changed in code
        $has_changed = $customer->wasChanged();

        // if you want to check current field
        // check like this
        // you can pass an array of fields
        $field_changed = $customer->wasChanged(['first_name']);

        return response()->json(['is_changes' => $has_changed, 'field_changed' => $field_changed]);
    }


    public function get_original_after_changing()
    {
        // if you changed some model during code and but you want to get 
        // the original data of model

        $customer = CustomerModle::find(2);

        $customer->first_name = 'avaz';

        $original_after_changing = $customer->getOriginal();

        return response()->json(['customer' => $original_after_changing]);
    }

    public function deleting_models()
    {
        // all about deleting models
        // you can find here:
        // https://laravel.com/docs/10.x/eloquent#deleting-models

        CustomerModle::where('id', 2)->delete();
    }

    public function customer_invoices()
    {
        return CustomerModle::where('id', 2)->with('customer_invoices')->first();
    }


    public function image_blur_hash()
    {
        $img = Image::make(storage_path('app/images/image_60f75wckinZyM4pRpaBmP5upy.jpg'));

        $blured = BlurHash::encode($img);

        return $blured;
    }

    public function image_url()
    {
        return response()->file(storage_path('app/images/image_60f75wckinZyM4pRpaBmP5upy.jpg'));
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


        // основное различие заключается в том, что get используется для выполнения запросов и 
        // возвращает коллекцию, тогда как all используется для получения всех записей для
        // конкретной модели и также возвращает коллекцию моделей.


        // the "all()" method returns the array of collections
        $all = User::all();

        // the "average('field')" method returns the middle value of something through given key
        // if you have array of values -> [10,10,20,40] if returns 20. (10 + 10 + 10 + 40) / 4
        // 4 is the array length 
        $average = User::average('id');

        //also you can write average like this method down below
        $avg = User::avg('id');


        //The "chunk()" method breaks the collection into multiple, smaller collections of a given size
        //you should use it after getting array of collections 
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
        // you can also get values using "->values()" property


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


    public function collection_average()
    {

        $customer_invoice = CustomerInvoiceModel::average('qty');

        $specific_customer_total_average = CustomerInvoiceModel
            ::where('customer_id', 4)
            ->average("total");


        return $specific_customer_total_average;
    }


    // this function is similar to "concatinate_two_tables_and_do_some_code()" function
    public function method_collaps()
    {
        // sending id
        $customer_invoice = CustomerInvoiceModel::get_only_specific_customer_invoices(4);

        //sending id
        $customers = CustomerModle::get_speciffic_customer(4);


        $collect = collect([$customer_invoice, $customers]);

        // here combine two arrays
        $collapse = $collect->collapse();


        //this gives us key value 
        $get_total_using_filter = $collapse->filter(function ($item, $index) {
            return $item->total && $item->total > 50;
        });

        // get only values
        $get_total_using_filter = $get_total_using_filter->values();

        return $get_total_using_filter;
    }


    //this function is similar to "method_collaps()" function
    public function concatinate_two_tables_and_do_some_code()
    {
        // sending id
        $customer_invoice = CustomerInvoiceModel::get_only_specific_customer_invoices(4);

        //sending id
        $customers = CustomerModle::get_speciffic_customer(4);

        // return $customers;

        $concate = $customers->concat($customer_invoice);


        //this gives us key value 
        $get_total_using_filter = $concate->filter(function ($item, $index) {
            return $item->total && $item->total > 50;
        });

        // get only values
        $get_total_using_filter = $get_total_using_filter->values();


        return $get_total_using_filter;
    }

    public function contain_and_every_methods()
    {
        $customer_invoices = CustomerInvoiceModel::get_only_specific_customer_invoices(4);

        $every =  $customer_invoices->every(function ($item, $index) {
            return $item->status == '-Выполнен-';
        });


        $contains = $customer_invoices->contains(function ($item, $index) {
            return $item->invoice_date == '2024-08-01';
        });

        return response([
            'every' => $every,
            'contains' => $contains,
            'invoice' => $customer_invoices
        ]);
    }

    public function each_and_map_methods()
    {
        $customer_invoice = CustomerInvoiceModel::get_only_specific_customer_invoices(4);

        $customer_invoice->map(function ($item, $index) {
            return $item->first_added_field = "$index 1";
        });

        $customer_invoice->each(function ($item, $index) {
            return $item->second_added_field = "$index 1";
        });

        return $customer_invoice;
    }

    public function collect_several_array_of_collections()
    {
        
    }
}

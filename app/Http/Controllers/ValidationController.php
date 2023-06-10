<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationRequest;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function validation(ValidationRequest $request)
    {
        $validated_fileds = $request->validated();


        return response(['success' => true, "validated_fields" => $validated_fileds]);
    }


    public function temp_image()
    {
        return response()->file(storage_path('/app/images/new.jpg'));
    }
}

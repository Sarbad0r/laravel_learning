<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationRequest;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class ValidationController extends Controller
{
    public function validation(ValidationRequest $request)
    {
        $validated_fileds = $request->validated();


        return response(['success' => true, "validated_fields" => $validated_fileds]);
    }


    public function temp_image()
    {
        return response()->file(storage_path('/app/images/image_60f75wckinZyM4pRpaBmP5upy.jpg'));
    }

    public function store_multi_image(Request $request)
    {

        if ($request->file('images')) {

            $images = $request->file('images');

            foreach ($images as $image) {
                $ext = $image->getClientOriginalExtension();

                $image_name = "image_" . Str::random(25) . "." . $ext;


                $save_img = Image::make($image);


                $save_img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                });


                $save_img->save(storage_path('app/images/' . $image_name));
            }

            return response(['success' => true]);
        } else {
            return response(['success' => false, 'message' => 'no images']);
        }
    }
}

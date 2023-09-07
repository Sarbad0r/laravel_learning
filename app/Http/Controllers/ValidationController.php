<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidationRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class ValidationController extends Controller
{

    //
    //



    public function validation(ValidationRequest $request)
    {
        $validated_fileds = $request->validated();


        return response(['success' => true, "validated_fields" => $validated_fileds]);
    }


    //
    //

    public function temp_image()
    {
        return response()->file(storage_path('/app/images/image_60f75wckinZyM4pRpaBmP5upy.jpg'));
    }


    //
    //

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


    //
    //
    public function isOrderTimeWithinWorkingHours($orderTime, $fromTime, $toTime)
    {

        //Код isOrderTimeWithinWorkingHours проверяет, попадает ли указанное время заказа в указанный промежуток рабочего времени, даже если это рабочее время охватывает полночь. Вот подробное описание кода:

        //Преобразование ввода в экземпляры Carbon:

        //Функция начинается с преобразования времени заказа и рабочих часов в экземпляры Carbon. Это   позволяет легко работать с датами и временем.
        //Проверка, распространяются ли рабочие часы за полночь:

        // Затем выполняется проверка, пересекаются ли рабочие часы за полночь. Если нет, это означает, что рабочее время не охватывает период после полуночи. В этом случае используется метод between для проверки, находится ли время заказа между начальным и конечным временем рабочих часов.
        // Работа с периодами, пересекающимися за полночь:

        // Если рабочее время охватывает период после полуночи, используются методы greaterThanOrEqualTo и lessThanOrEqualTo. Они проверяют, что время заказа больше или равно начальному времени рабочих часов, или что оно меньше или равно конечному времени рабочих часов.
        // Возвращение результата:

        // Функция возвращает true, если время заказа находится внутри рабочих часов, и false в противном случае.

        $orderTime = Carbon::parse($orderTime);

        $workingFromTime = Carbon::parse($fromTime);
        $workingToTime = Carbon::parse($toTime);

        if ($workingFromTime <= $workingToTime) {
            return $orderTime->between($workingFromTime, $workingToTime);
        } else {
            return $orderTime->greaterThanOrEqualTo($workingFromTime) || $orderTime->lessThanOrEqualTo($workingToTime);
        }
    }
}

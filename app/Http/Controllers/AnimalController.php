<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Field;
use App\Models\Type;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnimalController extends Controller
{
    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function set_animal(Request $request, $id): JsonResponse
    {
        if ($field_data = Field::find($id)) {
            $validate_animal_data = Validator::make($request['data'], [
                "X" => "required|numeric|min:1|max:$field_data->size_x",
                "Y" => "required|numeric|min:1|max:$field_data->size_y",
                "type" => "required|string|in:Wolf,Hare"
            ]);
            if ($validate_animal_data->fails()) {
                return $this->validate_exception($validate_animal_data);
            }
            $animal_created = Animal::create([
                'current_x' => $request['data']['X'],
                'current_y' => $request['data']['Y'],
                'type_id' => Type::where('name', $request['data']['type'])->first()->id,
                'steps' => $field_data->steps,
                'field_id' => $field_data->id,
            ]);
            if ($animal_created) {
                return response()->json([
                    'data' => $animal_created,
                    'message' => 'Created.'
                ], 201);
            } else {
                return $this->unknown_exception();
            }
        } else {
            return $this->not_found_exception();
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function set_random_animals(Request $request, $id): JsonResponse
    {
        if ($field_data = Field::find($id)) {
            $validate_animals_data = Validator::make($request['data'], [
                "type" => "required|string|in:Wolf,Hare",
                "volume" => "required|numeric|min:1",
            ]);
            if ($validate_animals_data->fails()) {
                return $this->validate_exception($validate_animals_data);
            }
            for ($i = 0; $i < $request['data']['volume']; $i++) {
                $animals_created[] = Animal::create([
                    'steps' => $field_data->steps,
                    'current_x' => rand(1, $field_data->size_x),
                    'current_y' => rand(1, $field_data->size_y),
                    'type_id' => Type::where('name', $request['data']['type'])->first()->id,
                    'field_id' => $field_data->id,
                ]);
            }
            if ($animals_created) {
                return response()->json([
                    'data' => $animals_created,
                    'message' => 'Created.'
                ], 201);
            } else {
                return $this->unknown_exception();
            }
        } else {
            return $this->not_found_exception();
        }
    }
}

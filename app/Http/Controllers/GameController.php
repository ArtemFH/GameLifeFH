<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Field;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class GameController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function view_fields(): JsonResponse
    {
        if ($field_data = Field::all()) {
            return response()->json([
                'data' => $field_data,
                'message' => 'Received.'
            ], 201);
        } else {
            return $this->not_found_exception();
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function set_field(Request $request): JsonResponse
    {
        $validate_field_data = Validator::make($request['data'], [
            "X" => "required|numeric|min:1",
            "Y" => "required|numeric|min:1",
            "N" => "required|numeric|min:1"
        ]);
        if ($validate_field_data->fails()) {
            return $this->validate_exception($validate_field_data);
        } elseif ($field_created = Field::create([
            'size_x' => $request['data']['X'],
            'size_y' => $request['data']['Y'],
            'steps' => $request['data']['N']
        ])) {
            return response()->json([
                'data' => [
                    'id' => $field_created->id,
                    'X' => $field_created->size_x,
                    'Y' => $field_created->size_y,
                    'N' => $field_created->steps
                ],
                'message' => 'Created.'
            ], 201);
        } else {
            return $this->unknown_exception();
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function get_animals($id): JsonResponse
    {
        if ($field_data = Field::find($id)) {
            return response()->json([
                'data' => $field_data->animals,
                'message' => 'Received.'
            ], 201);
        } else {
            return $this->not_found_exception();
        }
    }

    /**
     * @param $id
     * @return JsonResponse|void
     */
    public function verification_game($id)
    {
        $game_data['Wolf'] = Animal::whereFieldId($id)->whereTypeId(Type::whereName('Wolf')->first()->id)->count();
        $game_data['Hare'] = Animal::whereFieldId($id)->whereTypeId(Type::whereName('Hare')->first()->id)->count();

        $validate_game_data = Validator::make($game_data, [
            "Wolf" => "required|numeric|min:1",
            "Hare" => "required|numeric|min:1",
        ]);

        if ($validate_game_data->fails()) {
            return $this->validate_exception($validate_game_data);
        }
    }

    /**
     * @var array
     */
    public $animals = [];

    /**
     * @param $id
     */
    public function launch_game($id)
    {
        $field = Field::find($id);
        $this->animals = $field->animals;
        foreach ($this->animals as $key => $animal) {
            $this->launch_motion($animal, $field->first(), $key);
        }
    }

    /**
     * @param $animal
     * @param $game
     * @param int $key
     */
    public function launch_motion($animal, $game, int $key)
    {
        while (true) {
            switch (rand(0, 3)) {
                case 0:
                    if (($animal->current_x + 1) >= $game->size_x) {
                        break;
                    }
                    $animal->current_x++;
                    break 2;
                case 1:
                    if (($animal->current_y + 1) >= $game->size_y) {
                        break;
                    }
                    $animal->current_y++;
                    break 2;
                case 2:
                    if ($animal->current_x == 0) {
                        break;
                    }
                    $animal->current_x--;
                    break 2;
                case 3:
                    if ($animal->current_y == 0) {
                        break;
                    }
                    $animal->current_y--;
                    break 2;
            }
        }
        if ($animal->type == 'Wolf') {
            $animal->steps--;
            if ($animal->steps == 0) {
                $this->animals->forget($key);
                $animal->delete();
            } else {
                $animal->save();
            }
        } else {
            $animal->save();
        }
    }

    public function next_move($id)
    {
        if (Field::find($id)) {
            if ($game = $this->verification_game($id)) {
                return $game;
            } else {
                return $this->launch_game($id);
            }
        } else {
            return $this->not_found_exception();
        }
    }
}

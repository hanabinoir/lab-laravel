<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GameController extends RestController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::all();
        $data = empty($games) ? [] : $games;
        return $this->response($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'asin' => ['required', 'string', 'max:10', 'min:10'],
            'title' => ['required', 'string', 'max:255'],
            'price' => ['required', 'between:2.99,200.00', 'regex:/^(\d+(,\d{1,2})?)?$/']
        ])->validate();

        $game = Game::create($request->all());
        return $this->response($game);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::where('asin', $id);
        return is_null($game)
        ? $this->error('Game not found')
        : $this->response($game->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $game = Game::where('asin', $id);
        if (is_null($game)) {
            return $this->error('Game not found');
        } else {
            Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'price' => ['required', 'between:2.99,200.00', 'regex:/^(\d+(,\d{1,2})?)?$/']
            ])->validate();

            $game->title = $request->title;
            $game->price = $request->price;
            $game->save();

            return $this->response($game);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::where('asin', $id);
        if (is_null($game)) {
            return $this->error('Game not found');
        } else {
            $game->delete();
            return $this->response('Game deleted: {$id}.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;

class RecipesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $recipes = Recipe::orderBy('created_at', 'desc')->paginate(10);
        return view('recipes.index')->with('recipes', $recipes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $recipe = new Recipe;
        $recipe->title = $request->title;
        $recipe->body = $request->body;
        $recipe->save();

        return redirect('/recipes')->with('success', 'Новый рецепт успешно добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $recipe = Recipe::find($id);
        if (!$recipe) {
            return redirect('/recipes');
        }
        return view('recipes.show')->with('recipe', $recipe);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $recipe = Recipe::find($id);
        if (!$recipe) {
            return redirect('/recipes');
        }
        return view('recipes.edit')->with('recipe', $recipe);
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
        //
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $recipe = Recipe::find($id);
        if (!$recipe) {
            return redirect('/recipes');
        }
        $recipe->title = $request->title;
        $recipe->body = $request->body;
        $recipe->save();

        return redirect('/recipes')->with('success', 'Рецепт успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $recipe = Recipe::find($id);
        if (!$recipe) {
            return redirect('/recipes');
        }
        $recipe->delete();
        return redirect('/recipes')->with('success', 'Рецепт успешно удален'); 
    }
}

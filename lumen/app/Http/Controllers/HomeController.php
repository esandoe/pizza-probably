<?php


namespace App\Http\Controllers;


use App\Models\Recipe;

class HomeController extends Controller
{
    public function show()
    {
        $recipes = Recipe::where('name', '!=', 'untitled')->orderBy('name', 'ASC')->get();
        return view('home', ['recipes' => $recipes]);
    }
}

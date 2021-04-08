<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    $recipes = DB::collection('recipes')->get();

    return view('home', ['recipes' => $recipes]);
});

$router->get('/edit/untitled', function () use ($router) {
    return view('edit', ['title' => 'untitled', 'content' => '']);
});

$router->get('/edit/{recipe}', function ($recipe) use ($router) {
    $recipe = DB::collection('recipes')
        ->where(['name' => $recipe])
        ->get()[0];

    return view('edit', $recipe);
});

$router->get('/recipe/{recipe}', function ($recipe) use ($router) {
    $recipe = DB::collection('recipes')
        ->where(['name' => $recipe])
        ->get()[0];
    $parsedown = new Parsedown();
    $recipe['content'] = $parsedown->text($recipe['content']);

    return view('view', $recipe);
});

$router->post('/edit/{recipe}', function (Illuminate\Http\Request $request, $recipe) use ($router) {
    $content = $request->input('content');
    $title = $request->input('title');
    $name = strtolower($title);
    $name = str_replace([" ", "_"], "-", $name);
    $name = str_replace(["æ", "ø", "å"], ["a", "o", "a"], $name);
    $name = preg_replace('/[^0-9a-z\-_]/', '', $name);

    if (strtolower($recipe) == 'untitled')
    {
        DB::collection('recipes')
            ->insert([
                'name' => $name,
                'title' => $title,
                'content' => $content
            ]);
    }
    else {
        DB::collection('recipes')
            ->where(['name' => strtolower($recipe)])
            ->update([
                'name' => $name,
                'title' => $title,
                'content' => $content
            ]);
    }

    return redirect('/recipe/'.$name);
});

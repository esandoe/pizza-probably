<?php


namespace App\Http\Controllers;


use App\Classes\RecipeParsing;
use App\Models\Recipe;
use DateTime;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(string $id)
    {
        $recipe = Recipe::find($id);

        if ($recipe->created_at == null)
        {
            $recipe->created_at = new DateTime();
            $recipe->save();
        }

        return view('view')
            ->with('recipe', $recipe);
    }

    public function edit(string $id)
    {
        $recipe = Recipe::find($id);

        if ($id == 'untitled')
        {
            $new = new Recipe;
            $new->name = uniqid('untitled_');
            $new->title = $recipe->title;
            $new->image = $recipe->image;
            $new->content = $recipe->content;
            $new->save();
            return redirect('edit/'.$new->name);
        }

        return view('edit')
            ->with('content', $recipe->content)
            ->with('images', $recipe->images ?? [])
            ->with('id', $id);
    }

    public function update(Request $request, $id)
    {
        $content = $request->input('content');

        $errors = RecipeParsing::validate($id, $content);
        if ($errors)
        {
            return view('edit')
                ->with('content', $content)
                ->with('errors', $errors)
                ->with('images', Recipe::find($id)->images ?? [])
                ->with('id', $id);
        }

        $metadata = RecipeParsing::getMetadata($content);
        $uri = RecipeParsing::createUri($metadata['title']);

        $recipe = $id === 'untitled'
            ? new Recipe
            : Recipe::find($id);

        $recipe->name = $uri;
        $recipe->title = $metadata['title'];
        $recipe->image = $metadata['image'];
        $recipe->content = $content;
        $recipe->save();

        return redirect('/recipe/'.$uri);
    }
}

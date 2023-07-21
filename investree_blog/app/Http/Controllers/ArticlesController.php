<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(8);

        return view('main', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;



        $validator = Validator::make($request->all(),[
            'title' =>'required|string|max:255',
            'content' => 'required|string',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $article = new Article();
        $category = new Category();

        $article->user_id = $user_id;
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $image = $request->file('image');

        if($image)
        {
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('images/article_image');
            $image->move($path,$fileName);
    
            $article->image = $fileName;
        }

        $category->name = $request->input('categories_name');
        $category->user_id = $user_id;
        $category->save();

        $article->categories_id = $category->id;

        $article->save();
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $article = Article::findOrFail($id);

        return view('article', compact('article'));
    }

     /**
     * Display the current user created articles.
     */
    public function showPersonal()
    {
        $user_id = auth()->id();

        $articles = Article::where('user_id', $user_id)->paginate(8);

        return view('my_article', compact('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $article = Article::find($id);

        if(!$article)
        {
            return redirect()->back()->with('error', 'Article not found');
        }

        return view('edit_article', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $article = Article::find($id);
        $user_id = Auth::user()->id;

        if(!$article)
        {
            return redirect()->back()->with('error', 'Article not found');
        }


        $validator = Validator::make($request->all(),[
            'title' =>'required|string|max:255',
            'content' => 'required|string',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $article->user_id = $user_id;
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $image = $request->file('image');

        if($image)
        {
            $fileName = time().'.'.$image->getClientOriginalExtension();
            $path = public_path('images/article_image');
            $image->move($path,$fileName);
    
            $article->image = $fileName;
        }
        $categoryName = $request->input('categories_name');

        if ($categoryName) {
            $category = Category::where('name', $categoryName)->first();

            if (!$category) {
                $category = new Category();
                $category->name = $categoryName;
                $category->user_id = $user_id;
                $category->save();
            }

            $article->categories_id = $category->id;
        }

        $article->save();
        return redirect()->route('article.show', ['id' => $article->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $article = Article::find($id);

        if(!$article)
        {
            return redirect()->back()->with('error','Article not found');
        }

        $article->category->delete();
        $article->delete();
        

        return redirect()->back()->with('success', 'Article deleted successfully');
    }
}

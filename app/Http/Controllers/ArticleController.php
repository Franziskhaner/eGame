<?php

namespace App\Http\Controllers;

use App\Article;
use App\ContentBasedFiltering;
use Illuminate\Http\Request;

class ArticleController extends Controller{

    public function __construct(){
        $this->middleware('auth', ['except' => ['show', 'showByPlatform']]);    /*Para acceder a las vistas de los artículos será necesario que nos logueemos primero, salvo para ver un artículo en concreto (show.blade.php) o el catálogo por plataformas(showByPlatform.blade.php)*/
    }

    public function index(){
    	$articles = Article::orderBy('id','asc')->paginate(10);	//Así listamos los artículos traídos desde BD por el modelo ordenados por orden descendiente por su publicación y con un máximo de 3 artículos por página.
    	return view('article.index', compact('articles')); //compact('article') equivale a ['article' => $article]
    }

    public function create(){
        $article = new Article;
    	return view('article.create', compact('article'));
    }

    public function store(Request $request){
        $hasFile = $request->hasFile('cover') && $request->cover->isValid();  //El método hasFile de Laravel nos permite saber si el artículo contiene una imagen o no. isValid() devuelve true cuando el archivo se pudo subir correctamente.

    	$this->validate($request, ['name' => 'required', 'price' => 'required', 'quantity' => 'required', 'release_date' => 'required', 'players_num' => 'required', 'gender' => 'required', 'platform' => 'required', 'description' => 'required', 'assessment' => 'required|max:5']);

        $article = new Article;

        $article->name = $request->name;
        $article->price = $request->price;
        $article->quantity = $request->quantity;
        $article->release_date = $request->release_date;
        $article->players_num = $request->players_num;
        $article->gender = $request->gender;
        $article->platform = $request->platform;
        $article->description = $request->description;
        $article->assessment = $request->assessment;

        if($hasFile){
            $extension = $request->cover->extension();  //Nos devuelve cual es la extension del archivo que se está intentando subir.
            $article->extension = $extension;
        }
        if($article->save()){
            if($hasFile){
                $request->cover->storeAs('images', "$article->id.$extension"); //Con storeAs() definimos donde y con que nombre almacenamos la imagen.
            }
            return redirect()->route('articles.index')->with('success','Register created succsessfully');
        }
        else
            return back();
    }

    public function show($id){
        $articles = Article::filteredBySimilarArticles($id);
        $article  = Article::find($id);

        if(sizeof($articles) == 0)
            return 'There aren´t products to recommend';
        else
            return view('article.show', compact('article', 'articles'));
    }

    public function edit($id){
        $article=Article::find($id);
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, $id){
        $hasFile = $request->hasFile('cover') && $request->cover->isValid();  //El método hasFile de Laravel nos permite saber si el artículo contiene una imagen o no. isValid() devuelve true cuando el archivo se pudo subir correctamente.

        $this->validate($request, ['name' => 'required', 'price' => 'required', 'quantity' => 'required', 'release_date' => 're quired', 'players_num' => 'required', 'gender' => 'required', 'platform' => 'required', 'description' => 'required', 'assessment' => 'required|max:5']);
        
        $article = Article::find($id);

        $article->update($request->all());

        if($hasFile){
            $extension = $request->cover->extension();  //Nos devuelve cual es la extension del archivo que se está intentando subir.
            $article->extension = $extension;
        }

        if($article->save()){
            if($hasFile){
                $request->cover->storeAs('images', "$article->id.$extension"); //Con storeAs() definimos donde y con que nombre almacenamos la imagen.
            }
            return redirect()->route('articles.index')->with('success','Register updated succsessfully');
        }
        else
            return view('article.edit', compact('article'));
    }

    public function destroy($id){
        Article::find($id)->delete();
        return redirect()->route('articles.index')->with('success','Register deleted succsessfully');
    }

    public function showByPlatform($platform){
        $articles = Article::orderBy('id','desc')->where('platform', $platform)->get();
        return view('article.showByPlatform', compact('articles'));
    }
}

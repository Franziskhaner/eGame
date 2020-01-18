<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Rating;
use App\Article;
use App\ContentBasedFiltering;
use App\RecommendationsSystemWeigth;

use Illuminate\Http\Request;

class ArticleController extends Controller{

    public function __construct(){
        $this->middleware('admin', ['except' => ['show', 'showByPlatform']]);    /*Para acceder a las vistas de los artículos será necesario que nos autentiquemos primero y además deberá ser exclusivamente con rol de administrador, salvo para ver un artículo en concreto (show.blade.php) o el catálogo por plataformas(showByPlatform.blade.php). Éste Middleware se ha definido en el fichero Kernel.php con el nombre 'admin' e implementado en la ruta: C:\wamp64\www\eGame\app\Http\Middleware\IsAdmin.php*/
    }

    public function index(){
    	$articles = Article::orderBy('id','desc')->paginate(5);	
    	return view('article.index', compact('articles'));
    }

    public function create(){
        $article = new Article;
    	return view('article.create', compact('article'));
    }

    public function store(Request $request){
        $hasFile = $request->hasFile('cover') && $request->cover->isValid();  //El método hasFile de Laravel nos permite saber si el artículo contiene una imagen o no. isValid() devuelve true cuando el archivo se pudo subir correctamente.

    	$this->validate($request, [
            'name'         => 'required',
            'price'        => 'required',
            'quantity'     => 'required',
            'release_date' => 'required',
            'players_num'  => 'required',
            'gender'       => 'required',
            'platform'     => 'required',
            'description'  => 'required',
            'assessment'   => 'required|max:5'
        ]);

        $article = new Article;

        $article->name         = $request->name;
        $article->price        = $request->price;
        $article->quantity     = $request->quantity;
        $article->release_date = $request->release_date;
        $article->players_num  = $request->players_num;
        $article->gender       = $request->gender;
        $article->platform     = $request->platform;
        $article->description  = $request->description;
        $article->assessment   = $request->assessment;

        if($hasFile){
            $extension = $request->cover->extension();  //Nos devuelve cual es la extension del archivo que se está intentando subir.
            $article->extension = $extension;
        }
        if($article->save()){
            if($hasFile){
                $request->cover->storeAs('images', "$article->id.$extension"); //Con storeAs() definimos donde y con que nombre almacenamos la imagen.
            }
            return redirect()->route('articles.index')->with('success','Article created successfully!');
        }
        else
            return back();
    }

    public function show($id){
        $articles = Article::filteredBySimilarArticles($id);
        $article = Article::find($id);
        $reviews = Rating::getReviews($id);
        $users = User::all();

        if(sizeof($articles) == 0)
            return 'There aren´t products to recommend';
        else
            return view('article.show', compact('article', 'articles', 'reviews', 'users'));
    }

    public function edit($id){
        $article = Article::find($id);
        return view('article.edit', compact('article'));
    }

    public function update(Request $request, $id){
        $hasFile = $request->hasFile('cover') && $request->cover->isValid();

        $this->validate($request, [
            'name'         => 'required',
            'price'        => 'required',
            'quantity'     => 'required',
            'release_date' => 'required',
            'players_num'  => 'required',
            'gender'       => 'required',
            'platform'     => 'required',
            'description'  => 'required',
            'assessment'   => 'required|max:5'
        ]);
        
        $article = Article::find($id);

        $article->update($request->all());

        if($hasFile){
            $extension = $request->cover->extension();
            $article->extension = $extension;
        }

        if($article->save()){
            if($hasFile){
                $request->cover->storeAs('images', "$article->id.$extension");
            }
            return redirect()->route('articles.index')->with('success','Article updated successfully!');
        }
        else
            return view('article.edit', compact('article'));
    }

    public function destroy($id){
        Article::find($id)->delete();
        return redirect()->route('articles.index')->with('success','Article deleted successfully');
    }

    public function showByPlatform($platform){
        $articles = Article::orderBy('id','desc')->where('platform', $platform)->paginate(8);
        return view('article.show_by_platform', compact('articles'));
    }
}

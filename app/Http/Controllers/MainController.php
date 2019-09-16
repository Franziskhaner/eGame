<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;

class MainController extends Controller
{
    public function home(){
    	$articles = Article::orderBy('id','desc')->paginate(8);
    	return view('main.home', compact('articles'));
    }

    public function search(Request $request){
        $search = $request->get('search');
        $articles = Article::where('name', 'like', '%'.$search.'%')->paginate(4);
        if($articles->count() > 0)
        	return view('main.home', compact('articles'));
        else
        	return back()->with('There is no games with this name'); /*Mostrar que no hay juegos con el nombre introducido, ESTE MENSAJE NO FUNCIONA!!*/
    }
}

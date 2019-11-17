<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;
use Auth;

class MainController extends Controller
{
    public function home(){
    	if(Auth::check()){
            if(Auth::user()->role == 'User'){   /*Usuario registrado*/
                $articles = Article::filteredByUserPurchases();
                if(count($articles))    
                    return view('recommended_article.home_original', compact('articles'));
                else{   /*Si el usuario autenticado no ha comprado nada, no podremos recomendar, por lo que se le muestra la vista home normal*/
                    $articles = Article::orderBy('id','desc')->paginate(8);
                    return view('main.home', compact('articles'));
                }
            }
            else{   /*Usuario administrador*/
                $articles = Article::orderBy('id','desc')->paginate(8);
                return view('main.home', compact('articles'));
            }
        }
        else{   /*Usuario invitado*/
            $articles = Article::orderBy('id','desc')->paginate(8);
        	return view('main.home', compact('articles'));
        }
    }

    public function search(Request $request){
        $search = $request->get('search');
        $articles = Article::where('name', 'like', '%'.$search.'%')->paginate(4);
        if($articles->count())
        	return view('main.home', compact('articles'));
        else
        	return back()->with('There is no games with this name.'); /*Mostrar que no hay juegos con el nombre introducido, ESTE MENSAJE NO FUNCIONA!!*/
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\Article;
use App\Rating;
use App\CollaborativeFiltering;

class MainController extends Controller
{
    public function home(){

    	if(Auth::check()){ /*Si el usuario ha iniciado sesión,*/

            if(Auth::user()->role == 'User'){   /*Y es de rol usuario registrado, le mostraremos recomendaciones en base a sus compras mediante el filtrado basado en contenido y en base a sus gustos similares a otros usuarios mediante el filtrado colaborativo.*/

                $articlesByContentBasedFiltering = Article::filteredByUserPurchases();
                $articlesByCollaborativeFiltering = CollaborativeFiltering::getRecommendations();

                if(count($articlesByContentBasedFiltering) > 0 || $articlesByCollaborativeFiltering > 0){    /*Las recomendaciones basadas en compras las haremos siempre y cuando el usaurio haya hecho al menos una al igual que las del filtrado colaborativo se harán siempre que el usuario haya valorado algún artículo:*/
                    return view('recommended_article.home', compact(['articlesByContentBasedFiltering', 'articlesByCollaborativeFiltering']));
                }
                else{   /*Si el usuario acaba de registrase y aún no ha comprado ni valorado ningún artículo, se le mostrará la vista home normal:*/
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

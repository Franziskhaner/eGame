<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;
use App\User;
use App\Order;
use App\Rating;
use App\Article;
use App\ContentBasedFiltering;
use App\CollaborativeFiltering;
use App\RecommendationsSystemWeigth;

class MainController extends Controller
{
    public function home(){

    	if(Auth::check()){ /*Si el usuario ha iniciado sesión,*/
            if(Auth::user()->role == 'User'){   /*Y es de rol usuario registrado, le mostraremos recomendaciones en base a sus compras mediante el filtrado basado en contenido y en base a sus gustos similares a otros usuarios mediante el filtrado colaborativo.*/
                
                $articlesByContentBasedFiltering = Article::filteredByUserPurchases();
                $articlesByCollaborativeFiltering = CollaborativeFiltering::getRecommendations();

                $bestRated = Article::bestRated();
                $bestSellers = Article::bestSellers();

                $ratings = Rating::all();   /*Para contar el número de votos de cada artículo en la vista*/

                /*Las recomendaciones basadas en compras las haremos siempre y cuando el usuario haya hecho al menos una, al igual que las del filtrado colaborativo, se harán siempre que el usuario haya valorado algún artículo.Si el usuario acaba de registrase y aún no ha comprado ni valorado ningún artículo, se le mostrará la vista home sin recomendaciones de ningún tipo, únicamente los top sales y to ratings.*/
                return view('recommended_article.home', compact(['ratings', 'bestRated', 'bestSellers', 'articlesByContentBasedFiltering', 'articlesByCollaborativeFiltering']));
            }
            else{   /*Usuario administrador*/
                $totalIncomes = Order::totalIncomes();
                $totalCount = Order::count();
                $totalMonth = Order::totalMonth();
                $totalMonthCount = Order::totalMonthCount();
                $weigths = RecommendationsSystemWeigth::first();

                return view('main.admin', compact(['weigths', 'totalIncomes', 'totalCount', 'totalMonth', 'totalMonthCount']));
            }
        }
        else{   /*Usuario invitado*/
            $articles = Article::orderBy('id','desc')->paginate(16);
        	return view('main.home', compact('articles'));
        }
    }

    public function update(Request $request){
        $weigths = RecommendationsSystemWeigth::first();

        $weigths->update($request->all());

        if($weigths->save())
            return redirect()->route('home')->with('success','Weigths updated successfully!');
    }

    public function search(Request $request){
        $search = $request->get('search');
        $articles = Article::where('name', 'like', '%'.$search.'%')->paginate(8);
        if($articles->count())
        	return view('main.search', compact('articles', 'search'));
        else{
            \Session::put('error', 'There is no results with "'.$search.'"');
        	return back();
        }
    }

    public function advancedSearch(Request $request){
        $name = $request->get('name');
        $platform = $request->get('platform');
        $gender = $request->get('gender');
        $price = $request->get('price');
        $release_date = $request->get('release_date');
        $search = $request->get('name');

        /*A continuación hacemos uso de los métodos Scope definidos en la clase Article.php para optimizar las búsquedas en BD:*/
        $articles = Article::orderBy('id', 'DESC')->name($name)->gender($gender)->platform($platform)->price($price)->releaseDate($release_date)->paginate(8);

        if($articles->count())
            return view('main.search', compact('articles', 'search'));
        else{
            \Session::put('error', 'There is no results for this query.');
            return back();
        }
    }

    public function crudSearch(Request $request){
        $search = $request->get('crud_search');
        $crud_path = $request->path();

        switch ($crud_path) {
            case 'users/crud_search':
                $users = User::where('id', 'like', '%'.$search.'%')->orWhere('first_name', 'like', '%'.$search.'%')->orWhere('last_name', 'like', '%'.$search.'%')->orWhere('email', 'like','%'.$search.'%')->orWhere('email', 'like','%'.$search.'%')->orWhere('created_at', 'like','%'.$search.'%')->paginate(20);
                if($users->count())
                    return view('user.index', compact('users'));
                else{
                    \Session::put('error','No user was found with that data! Please, try again');
                    return back();
                }
                break;
            case 'articles/crud_search':
                $articles = Article::where('id', 'like', '%'.$search.'%')->orWhere('name', 'like', '%'.$search.'%')->orWhere('price', 'like', '%'.$search.'%')->orWhere('gender', 'like','%'.$search.'%')->orWhere('platform', 'like','%'.$search.'%')->orWhere('release_date', 'like','%'.$search.'%')->paginate(20);
                if($articles->count())
                    return view('article.index', compact('articles'));
                else{
                    \Session::put('error','No article was found with that data! Please, try again');
                    return back();
                }
                break;
            case 'orders/crud_search':
                $orders = Order::where('id', 'like', '%'.$search.'%')->orWhere('user_id', 'like', '%'.$search.'%')->orWhere('recipient_name', 'like', '%'.$search.'%')->orWhere('total', 'like','%'.$search.'%')->orWhere('email', 'like','%'.$search.'%')->orWhere('status', 'like','%'.$search.'%')->orWhere('line1', 'like','%'.$search.'%')->orWhere('city', 'like','%'.$search.'%')->orWhere('country_code', 'like','%'.$search.'%')->orWhere('payment_method', 'like','%'.$search.'%')->orWhere('custom_id', 'like','%'.$search.'%')->orWhere('created_at', 'like','%'.$search.'%')->paginate(20);

                if($orders->count())
                    return view('order.index', compact('orders'));
                else{
                    \Session::put('error','No order was found with that data! Please, try again');
                    return back();
                }
                break;
            case 'ratings/crud_search':
                $ratings = Rating::where('id', 'like', '%'.$search.'%')->orWhere('score', 'like', '%'.$search.'%')->orWhere('user_id', 'like', '%'.$search.'%')->orWhere('article_id', 'like','%'.$search.'%')->orWhere('created_at', 'like','%'.$search.'%')->paginate(20);
                if($ratings->count())
                    return view('rating.index', compact('ratings'));
                else{
                    \Session::put('error','No rating was found with that data! Please, try again');
                    return back();
                }
                break;
            
            default:
                \Session::put('error','Something was wrong!! Please, contact with your admin server.');
                return back(); 
                break;
        }    
    }
}

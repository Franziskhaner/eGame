<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Rating;
use App\User;
use App\Article;
use App\Order;
use App\OrderedArticle;

class RatingController extends Controller
{
    public function __construct(){  /*Con el Middelware definimos que para acceder al recurso Users, hay que autenticarse primero, este middleware es a nivel de controlador, también puede definirse a nivel de rutas.*/
        $this->middleware('admin', ['except' => ['store', 'rateYourOrder']]); /*Este middleware se ha definido en el fichero Kernel.php con el nombre 'admin' e implementado en la ruta: C:\wamp64\www\eGame\app\Http\Middleware\IsAdmin.php para que sólo el usuario administrador pueda acceder a las vistas de este controlador, excepto a las de store y rateYourOrder para que el usuario registrado pueda valorar sus pedidos.*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::orderBy('id', 'DESC')->paginate(10);

        //$articlesRating = Rating::articlesRating(); //NO está terminado

        return view('rating.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rating   = new Rating;
        $users    = User::all();
        $articles = Article::all();

        return view('rating.create', compact(['rating', 'users', 'articles']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role == 'Admin'){
            $this->validate($request,[
                'user_id'    => 'required|integer',
                'score'      => 'required|integer',
                'article_id' => 'required|integer'            
            ]);
            
            Rating::create([
                'user_id'    => $request['user_id'],
                'score'      => $request['score'],
                'comment'    => $request['comment'],
                'article_id' => $request['article_id']
            ]);

            return redirect('ratings')->with('success', 'Rating created successfully!');
        }
        else{
            $this->validate($request,['score' => 'required|integer']);
            
            Rating::create([
                'user_id'    => Auth::user()->id,
                'score'      => $request['score'],
                'comment'    => $request['comment'],
                'article_id' => $request['article_id']
            ]);

            /*Recalculamos la valoración media del artículo, con este nuevo rating:*/
            $assessment = Rating::articleAverageRating($request['article_id']);

            /*Y la actualizamos en el artículo en cuestión:*/
            Article::find($request['article_id'])->update(['assessment' => $assessment]);

            return redirect()->route('user_ratings')->with('success', 'Rating created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rating   = Rating::find($id);
        $users    = User::all();
        $articles = Article::all();

        return view('rating.edit', compact(['rating', 'users', 'articles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'user_id'    => 'required|integer',
            'score'      => 'required|integer',
            'article_id' => 'required|integer'
        ]);
        
        $rating = Rating::find($id);

        $rating->update($request->all());

        if($rating->save())
            return redirect('ratings')->with('success', 'Rating updated successfully!');
        else
            return view('rating.edit', compact('rating'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Rating::find($id)->delete();
        return redirect()->route('ratings.index')->with('success','Rating deleted successfully!');
    }

    public function rateYourOrder($article)
    {
        $rating = new Rating;
        $article = Article::where('name', $article)->first();
        
        return view('rating.rate_your_order', compact(['rating', 'article']));
    }
}

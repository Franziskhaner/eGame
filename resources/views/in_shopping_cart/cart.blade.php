@extends('layouts.app')

@section('content')
<div class="container">
  <!-- Title -->
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h2>Shopping Cart</h2>
        </div>
 
          <!-- Product #1 -->
        <div class="item">
          <div class="buttons">
            <span class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></span>
            <span class="like-btn"></span>
          </div>
       
          <div class="image">
            <img src="image/item-1.png" alt="" />
          </div>
       
          <div class="description">
            <span>Common Projects</span>
            <span>Bball High</span>
            <span>White</span>
          </div>
       
          <div class="quantity">
            <button class="plus-btn" type="button" name="button">
              <img src="image/plus.svg" alt="" />
            </button>
            <input type="text" name="name" value="1">
            <button class="minus-btn" type="button" name="button">
              <img src="image/minus.svg" alt="" />
            </button>
          </div>
       
          <div class="total-price">$549</div>
        </div>
       
        <!-- Product #2 -->
        <div class="item">
          <div class="buttons">
            <span class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></span>
            <span class="like-btn"></span>
          </div>
       
          <div class="image">
            <img src="image/item-2.png" alt=""/>
          </div>
       
          <div class="description">
            <span>Maison Margiela</span>
            <span>Future Sneakers</span>
            <span>White</span>
          </div>
       
          <div class="quantity">
            <button class="plus-btn" type="button" name="button">
              <img src="image/plus.svg" alt="" />
            </button>
            <input type="text" name="name" value="1">
            <button class="minus-btn" type="button" name="button">
              <img src="image/minus.svg" alt="" />
            </button>
          </div>
       
          <div class="total-price">$870</div>
        </div>
       
        <!-- Product #3 -->
        <div class="item">
          <div class="buttons">
            <span class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-trash"></span></span>
            <span class="like-btn"></span>
          </div>
       
          <div class="image">
            <img src="image/item-3.png" alt="" />
          </div>
       
          <div class="description">
            <span>Our Legacy</span>
            <span>Brushed Scarf</span>
            <span>Brown</span>
          </div>
       
          <div class="quantity">
            <button class="plus-btn" type="button" name="button">
              <img src="image/plus.svg" alt="" />
            </button>
            <input type="text" name="name" value="1">
            <button class="minus-btn" type="button" name="button">
              <img src="image/minus.svg" alt="" />
            </button>
          </div>
       
          <div class="total-price">$349</div>
        </div>

        <!-- Payment Button -->
        {{--
        {!! Form::open(['url' => '/cart', 'method' => 'POST', 'class' => 'inline-block']) !!}
          <input type="hidden" name="article_id" value="{{$article->id}}">
          <input type="submit" value="Add to cart" class="btn btn-info">
        {!! Form::close() !!}
          --}}
      </div>
    </div>
  </div>
</div>

@endsection
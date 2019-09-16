<?php
//www/eGame/app/Http/Controllers/Hola.php

namespace App\Http\Controllers;

class Hola extends Controller{

	public function index(){
		return "Welcome to my first controller on Laravel!";
	}

	public function saludo($nombre){
		return "Hola {$nombre}, bienvenido a mi primer controlador en Laravel";
	}

	public function saludo2($nombre, $edad){
		return "Hola {$nombre}, tienes {$edad} años";
	}

	public function metodoParametro($parametro){
		return "parametro=$parametro";
	}

	public function metodoParametro2($parametro, $parametro2){

		return view('pruebaVista', ['parametro' => $parametro, 'parametro2' => $parametro2 ]);
	}
}
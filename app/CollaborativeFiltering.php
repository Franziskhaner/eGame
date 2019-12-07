<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CollaborativeFiltering extends Model
{
	public static function prueba (){
		$text = 'The text you are desperate to analyze :)';
		$process = new Process("C:/wamp64/www/eGame/app/analyse_string.py \"{$text}\"");
		$process->run();

		// executes after the command finishes
		if (!$process->isSuccessful()) {
		    throw new ProcessFailedException($process);
		}

		echo $process->getOutput();
		//Result (string): {'neg': 0.204, 'neu': 0.531, 'pos': 0.265, 'compound': 0.1779}
		/*
		ob_start();
		black_box_function_printing_to_command_line();
		$output = ob_get_clean();
		*/
	}	
}

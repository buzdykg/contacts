<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showWelcome()
	{
		return View::make('hello');
	}

	public function postWelcome()
	{
		$lines = file(Input::file('csv')->getRealPath(), FILE_IGNORE_NEW_LINES);

		foreach ($lines as $key => $value)
		{
			$csv[$key] = str_getcsv($value, ';', '"');
		}

		$processor = App::make('\Contact\Processor');
		$results   = $processor->process($csv);

		return View::make('hello', [
			'processedData' => $results,
			'originalData'  => $csv
		]);
	}

}

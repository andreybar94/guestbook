<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function index()
	{
		$data = array('title' => 'Гостевая книга',
					  'pagetitle'  => 'Гостевая книга');
    	return view('pages.index',$data);
	}
}

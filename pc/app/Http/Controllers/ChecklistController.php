<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class ChecklistController extends Controller
{
	public function checklist()
	{
		return view('layout.checkin.checkin');
	}
}
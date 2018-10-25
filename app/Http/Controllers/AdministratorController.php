<?php

namespace App\Http\Controllers;


use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class AdministratorController extends Controller {
	//
	
	/**
	 * Display a listing of the resource.
	 *
	 * - @return Response
	 */
	public function index() {
		$current_user_id = Auth::id ();
		$current_administrator = \App\Amministration::find($current_user_id)->first();
		$data = array();
		$data['current_administrator']= $current_administrator;
		return view ( 'pages.Administration.amministratori',$data );
		
		
	}
	public function create() {
		
		
	}
	public function store(Request $request) {
	}
	public function show($id) {
		//
	}
	public function edit($id) {
		
		//
	}
	
	/**
	 * - Update the specified resource in storage.
	 *
	 * - @param Request $request
	 * - @param int $id
	 * - @return Response
	 */
	public function update(Request $request, $id) {
		//
	}
	
	/**
	 * - Remove the specified resource from storage.
	 *
	 * - @param int $id
	 * - @return Response
	 */
	public function destroy($id) {
		//
	}
}

<?php

namespace App\Http\Controllers;


use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdministratorController extends Controller {
	//
	
	/**
	 * Display a listing of the resource.
	 *
	 * - @return Response
	 */
	public function index() {
		
		
		return view ( 'pages.Administration.amministratori',[] );
		
		
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

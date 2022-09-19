<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('adminauth');
	}

    public function index()
    {
    	return view('admin.admin-dashboard');
    }

    public function busList()
    {
    	$bus_info = DB::table('buses')->get();
    	return view('admin.admin-bus-list', ['bus_info' => $bus_info]);
    }

    public function showAddBusForm()
    {
    	return view('admin.admin-add-bus');
    }

    public function addBus(Request $request)
    {
    	$this->bus_validation($request);
    	$bus_name 	= $request->get('bus_name');
    	$total_seat = $request->get('total_seat');
    	$insertionData = [
    		'bus_name' 		=> $bus_name,
    		'total_seat' 	=> $total_seat,
    		'created_at' 	=> \Carbon\Carbon::now(),
    		'updated_at' 	=> \Carbon\Carbon::now()
    	];
    	DB::table('buses')->insert($insertionData);
    	Session::flash('msg', 'A new bus inserted successfully');
    	return redirect('admin/add-bus');
    }

    public function bus_validation($request)
    {
    	$rules = [
    		'bus_name' 		=> 'required',
    		'total_seat' 	=> 'required'
    	];

    	$custom_message = [
    		'bus_name.required' 	=> 'Bus name cannot be empty',
    		'total_seat.required' 	=> 'Total seat cannot be empty'
    	];

    	return $this->validate($request, $rules, $custom_message);
    }

    public function deleteBus(Request $request, $id)
    {
    	$bus_busy_in_booking = DB::table('booking')->where('bus_id', $id)->count();
    	if ( $request->method() == "DELETE" && $bus_busy_in_booking == 0 ) {
    		DB::table('buses')->where('id', $id)->delete();
    		Session::flash('msg', 'Selected Bus has been deleted successfully');
    		return redirect('admin/bus-list');
    	}
    	Session::flash('msg', 'One of a customer booked one or more seat already so this bus cannot be deleted right now.');
    	return redirect('admin/bus-list');
    }
}

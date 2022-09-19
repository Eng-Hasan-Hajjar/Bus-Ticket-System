<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use DB;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;
use App\Order;

class CustomerController extends Controller
{
	public function __construct()
	{
		$this->middleware('authuser');
	}

    public function index()
    {
    	return view('customer.customer-welcome');
    }

    public function profile()
    {
        $user_id = auth()->user()->id;
        $customer_info = Customer::where('user_id', $user_id)->get();
    	return view('customer.customer-profile', ['customer_info' => $customer_info]);
    }

    public function showEditProfileForm()
    {
        $user_id = auth()->user()->id;
        $customer_info = Customer::where('user_id', $user_id)->get();
        return view('customer.edit-profile-form', ['customer_info' => $customer_info]);
    }

    public function updateProfileInfo(Request $request)
    {
        $user_id = auth()->user()->id;
        $customer_info = Customer::where('user_id', $user_id)->get();
        if ( count($customer_info) > 0 ) {
            $address = $request->get('address');
            $phone = $request->get('phone');
            if ( $request->hasFile('pp') ) {
                $fileName = $user_id . '-' . $request->file('pp')->getClientOriginalName();
                $destinationPath = public_path('/images');
                $request->file('pp')->move($destinationPath, $fileName);
                // Now update the database table only photo field
                $update_data = [
                    'photo' => $fileName
                ];
                Customer::where('user_id', $user_id)->update($update_data);
            }
            $update_data = [
                'address'   => $address,
                'phone'     => $phone
            ];
            Customer::where('user_id', $user_id)->update($update_data);
            session()->flash('msg', 'Customer information updated successfully');
            return redirect('edit-profile-form');
        }
    }

    public function showBusList()
    {
        $bus_info = DB::table('buses')->get();
        return view('customer.customer-bus-list', ['bus_info' => $bus_info]);
    }

    public static function getAvailableSeat($id)
    {
        $bus_info = DB::table('buses')->where('id', $id)->get();
        $total_seat = $bus_info[0]->total_seat;
        $booked_seat = DB::table('booking')->where('bus_id', $id)->count();
        return $total_seat - $booked_seat;
    }

    public function showBusSeatDetail($id)
    {
        $bus_info = DB::table('buses')->where('id', $id)->get();
        //Make array for available seat numbers
        $booking_info = DB::table('booking')->where('bus_id', $id)->where('status', 1)->get();
        
        $busy_seat_array = [];
        if ( count($booking_info) > 0 ) {
            foreach ( $booking_info as $value ) {
                array_push($busy_seat_array, $value->seat_no);
            }
        }
        
        return view('customer.booking-form', ['bus_info' => $bus_info, 'busy_seats' => $busy_seat_array]);
    }

    public function bookingNow(Request $request)
    {
        $this->booking_validation($request);
        $user_id = auth()->user()->id;
        $bus_id = $request->get('bus_id');
        $seat_no = $request->get('seat_no');

        //Check this seat is free in this bus or not
        $check = DB::table('booking')
                    ->where('bus_id', $bus_id)
                    ->where('seat_no', $seat_no)
                    ->where('status', 1)
                    ->count();
        if ( $check == 0 ) {
            $this->validate($request, [
                'card_no' => 'required',
                'ccExpiryMonth' => 'required',
                'ccExpiryYear' => 'required',
                'cvvNumber' => 'required',
                //’amount’ => ‘required’,
            ]);
            $input = $request->all();
            
            $input = array_except($input, array('_token'));
            $stripe = Stripe::make('sk_test_8f9V9KyZmYYOoGYc4jX8LA4u');
            try {
                $token = $stripe->tokens()->create([
                    'card' => [
                        'number' => $request->get('card_no'),
                        'exp_month' => $request->get('ccExpiryMonth'),
                        'exp_year' => $request->get('ccExpiryYear'),
                        'cvc' => $request->get('cvvNumber'),
                    ],
                ]);
                // $token = $stripe->tokens()->create([
                // ‘card’ => [
                // ‘number’ => ‘4242424242424242’,
                // ‘exp_month’ => 10,
                // ‘cvc’ => 314,
                // ‘exp_year’ => 2020,
                // ],
                // ]);
                if ( !isset($token['id']) ) {
                    return redirect()->route('booking-form');
                }
                $charge = $stripe->charges()->create([
                    'card' => $token['id'],
                    'currency' => 'USD',
                    'amount' => $request->get('book_cost'),
                    'description' => 'Add in wallet',
                ]);
                
                if ( $charge['status'] == 'succeeded' ) {
                    /**
                    * Write Here Your Database insert logic.
                    */
                    $insertData = [
                        'user_id'       => $user_id,
                        'bus_id'        => $bus_id,
                        'seat_no'       => $seat_no,
                        'status'        => 1,
                        'created_at'    => \Carbon\Carbon::now(),
                        'updated_at'    => \Carbon\Carbon::now()
                    ];
                    DB::table('booking')->insert($insertData);

                    Order::create([
                        //'status' => OrderStatus::$INIT,
                        'user_id' => $user_id,
                        'name' => auth()->user()->fname . ' ' . auth()->user()->lname,
                        'email' => auth()->user()->email,
                        'order_number' => 'Ord-' . $user_id . time(),
                        'invoice_number' => 'Inv-' . $user_id . time(),
                        'billing_address' => isset($input['billing']['address']) ? $input['billing']['address'] : '',
                        'shipping_address' => isset($input['shipping']['address']) ? $input['shipping']['address'] : '',
                        'payment_type' => isset($input['payment_type']) ? $input['payment_type'] : 'stripe',
                        'card_number' => $input['card_no'] != null ? encrypt($input['card_no']) : encrypt(null),
                        'card_full_name' => isset($input['card']['card_brand']) ? encrypt($input['card']['card_brand']) : encrypt(null),
                        'card_expire' => encrypt($input['ccExpiryMonth'].'/'.$input['ccExpiryYear']),
                        'card_cvc' => isset($input['cvvNumber']) ? encrypt($input['cvvNumber']) : encrypt(null),
                        'total' => $input['book_cost']
                    ]);

                    session()->flash('msg', 'Seat Booking has been done successfully');
                    //return redirect('show-bus-list');
                    // echo "<pre>";
                    // print_r($charge);exit();
                    return redirect()->route('show-bus-list');
                } 
                else {
                    session()->flash('error', 'Money not add in wallet!!');
                    return redirect()->route('show-bus-list');
                }
            } catch (Exception $e) {
                session()->flash('error',$e->getMessage());
                return redirect()->route('show-bus-list');
            } catch(\Cartalyst\Stripe\Exception\CardErrorException $e) {
                session()->flash('error', $e->getMessage());
                return redirect()->route('show-bus-list');
            } catch(\Cartalyst\Stripe\Exception\MissingParameterException $e) {
                session()->flash('error', $e->getMessage());
                return redirect()->route('show-bus-list');
            }
        } 
        else {
            session()->flash('err-msg', 'This Seat is Unavailable');
            return redirect('show-bus-list');
        }
    }

    public function booking_validation($request)
    {
        $rules = [
            'seat_no' => 'required|numeric'
        ];

        $custom_message = [
            'seat_no.required' => 'Please input your seat number'
        ];

        return $this->validate($request, $rules, $custom_message);
    }
}

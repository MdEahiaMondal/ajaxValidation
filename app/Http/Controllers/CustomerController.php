<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function showForm(){
      return view('customer');
    }


    public function insert(Request $request){
        $valid =  $request->validate([
            'name' => 'required',
            'email' => 'required|unique:customers',
            'password' => 'required|confirmed',
        ]);



        Customer::create($valid);
        session()->flash('success_message', 'Registration successful!');

        return response()->json(['success' => true]);
    }

}

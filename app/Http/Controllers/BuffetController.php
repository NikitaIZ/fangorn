<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buffet;

class BuffetController extends Controller
{
    function index(){
        $buffet = Buffet::select('*')->get();
        return view('buffet', compact('buffet'));
    }

    function update(Request $request){

        Buffet::select('*')
                ->where('service', 'Breakfast Plus')
                ->update(['adults' => $request->Breakfast_Plus_adults,
                        'children' => $request->Breakfast_Plus_children]);

        Buffet::select('*')
                ->where('service', 'Breakfast')
                ->update(['adults' => $request->Breakfast_adults,
                        'children' => $request->Breakfast_children]);

        Buffet::select('*')
                ->where('service', 'Lunch')
                ->update(['adults' => $request->Lunch_adults,
                        'children' => $request->Lunch_children]);

        Buffet::select('*')
                ->where('service', 'Dinner')
                ->update(['adults' => $request->Dinner_adults,
                        'children' => $request->Dinner_children]);

        Buffet::select('*')
                ->where('service', 'Brunch')
                ->update(['adults' => $request->Brunch_adults,
                        'children' => $request->Brunch_children]);

        Buffet::select('*')
                ->where('service', 'Pool Day')
                ->update(['adults' => $request->Pool_Day_adults,
                        'children' => $request->Pool_Day_children]);

        Buffet::select('*')
                ->where('service', 'Additional Pax')
                ->update(['adults' => $request->Additional_Pax_adults,
                        'children' => $request->Additional_Pax_children]);
                        
        return redirect()->route('dashboard');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Lead;
use App\Mail\NewContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    
  public function store(Request $request) {

    $data = $request->all();
    
    //validazione
    $validator = Validator::make($data, 
    
        [
          'name' => 'required',
          'email' => 'required|email',
          'message' => 'required',
        ]
    );

    //se la validazione fallisce
    if ($validator->fails()) {

      return response()->json([
          'success'=>false,
          'errors'=>$validator->errors(),
      ]);
    
    } else {
    
        $lead = new Lead();
        $lead->fill($data);
        $lead->save();

        //se la validazione ha successo invio la mail
        Mail::to('info@boolpress.com')->send(new NewContact($lead));

        return response()->json([
          'success'=> true,
      ]); 

    }

  }

}

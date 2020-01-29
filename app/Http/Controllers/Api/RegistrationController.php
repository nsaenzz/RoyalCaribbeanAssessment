<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GuestRegistration;
use Illuminate\Support\Facades\Validator;

class RegistrationController extends Controller
{
    public function index(){
        return GuestRegistration::all()->toArray();
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'personal_id' => 'required|numeric|unique:guest_registration,personal_id|digits:7',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email_address' => 'required|max:100|email:rfc,dns',
            'brand' => 'required|in:A,C,R',
            'ship' => 'required|max:100',
            'sail_date' => 'after:today',
            'email_list_flag' => 'boolean',
            'comments' => 'max:500',
        ]);
        
       if ($validator->fails()) {
            return $validator->messages()->first();
       }

        GuestRegistration::create([
            'personal_id'   => $request->personal_id,
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email_address' => $request->email_address,
            'brand'         => $request->brand,
            'ship'    => $request->ship,
            'sail_date'     => $request->sail_date,
            'email_list_flag'     => $request->email_list_flag,
            'comments'      => $request->comments,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($personal_id)
    {
        GuestRegistration::where('personal_id', $personal_id)
                        ->delete();
    }
}

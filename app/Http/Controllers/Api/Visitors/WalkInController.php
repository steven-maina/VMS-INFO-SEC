<?php

namespace App\Http\Controllers\Api\Visitors;

use App\Http\Controllers\Controller;
use App\Models\Nationality;
use App\Models\TimeLog;
use App\Models\UserDetail;
use App\Models\VehicleInformation;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WalkInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {

        return response()->json(Visitor::with(['resident2','sentry', 'purpose', 'visitorType', 'timeLogs'])->where('sentry_id', $request->user()->id)
        ->where('type', 'walkin')
        ->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'type' => 'required|string',
            'identification_type_id' => 'required|integer',
            'visitor_type_id' => 'required|integer',
            'purpose_id' => 'required|integer',
            'nationality' => 'required|string',
            'resident_id' => 'required|integer',
            'IDNO'=>'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
// check if nationality already exists
        $nationality = Nationality::where('name', $request['nationality'])->first();
        if (!$nationality) {
            $nationality = new Nationality;
            $nationality->name = $request['nationality'];
            $nationality->save();
        }

        $visitor = new Visitor();
        $visitor->name = $request->input('name');
        $visitor->type = $request->input('type');
        $visitor->identification_type_id = $request->input('identification_type_id');
        $visitor->visitor_type_id = $request->input('visitor_type_id');
        $visitor->purpose_id = $request->input('purpose_id');
        $visitor->sentry_id = $request->user()->id;
        $visitor->nationality_id = $nationality->id;
        $visitor->resident_id = $request->input('resident_id');
        $visitor->tag=$request->input('tag');
        $visitor->attachment1=$request->input('attachment1');
        $visitor->attachment2=$request->input('attachment2');
        $visitor->attachment3=$request->input('attachment3');
        $visitor->attachment4=$request->input('attachment4');
        $timeLog = new TimeLog;
        $timeLog->entry_time=now();
        $timeLog->save();

        $visitor->time_log_id = $timeLog->id;


        $user_details= UserDetail::where('ID_number', $request['IDNO'])->first();
        if (!$user_details) {
            $user_details= new UserDetail();
            $user_details->phone_number = $request->input('phone1');
            $user_details->secondary_phone_number = $request->input('phone2');
            $user_details->date_of_birth = $request->input('DOB');
            $user_details->ID_number= $request->input('IDNO');
            $user_details->gender = $request->input('gender');
            $user_details->image = $request->input('image');
            $user_details->save();
        }
        $visitor->user_detail_id = $user_details->id;
        $visitor->save();
        return response()->json(['success' => 'Visitor Walkin information added successfully.'], 201);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

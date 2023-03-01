<?php

namespace App\Http\Controllers\Visit;

use App\Http\Controllers\Controller;
use App\Models\DriveIn;
use App\Models\TimeLog;
use App\Models\Visitor;
use Illuminate\Http\Request;

class AllCheckinsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.visitor.allcheckins.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitor = DriveIn::with('purpose1','sentry','timeLogs')->whereId($id)->first();
        $visitorCount = Visitor::where('user_detail_id', $visitor->user_details->id)->count();
        $lastTimeLog=TimeLog::where('id', $visitor->time_log_id)->orderBy('id', 'desc')->first();
        return view('app.visitor.allcheckins.visitorDetails',compact('visitor', 'visitorCount', 'lastTimeLog'));
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
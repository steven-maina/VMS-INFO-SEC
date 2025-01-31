<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Organization;
use App\Models\Sentry;
use App\Models\UserDetail;
use App\Models\Visitor;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Premise;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;


class SentryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livewire.sentry.layout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSentryRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|min:2|unique:sentries,name',
            'premise_id' => 'required',
            'date_of_birth'=> 'required',
            'ID_number'=> 'required|numeric',
            'physical_address'=>'required|string',
            'gender'=>'required|string',
            'phone_number' => 'required|numeric|unique:sentries,phone_number',

        ]);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        $org_code=Premise::where('id',  $request->input('premise_id'))->first();

        $organization=Organization::where('code', $org_code->organization_code)->first();
        $new_user=User::where('phone_number',  $request->input('phone_number'))->where('role_id', 4)->first();
        if (!$new_user==null){
            return back()->with('Error', 'Sentry already exists');
        }
        User::create([

            'name' => $request->input('name'),

            'email' => $organization->email ?? $request->input('name'),
            'phone_number' => $request->phone_number,

            'organization_code' =>$org_code->organization_code,

            'role_id' => 4,

            'email_verified_at' => now(),

            'password' => Hash::make($request->phone_number),
        ]);

        $user_detail=UserDetail::where('phone_number',$request->phone_number)->first();

        if (!$user_detail) {
            $user_detail = new UserDetail();
            $user_detail->phone_number = $request->phone_number ?? '';
            $user_detail->date_of_birth = $request->date_of_birth ?? '';
            $user_detail->ID_number = $request->ID_number ?? '';
            $user_detail->image = $request->image ?? '';
            $user_detail->gender = $request->gender ?? 'male';
            $user_detail->company = $request->company ?? '';
            $user_detail->physical_address = $request->physical_address;
            $user_detail->save();
        }
//        UserDetail::create([
//            'phone_number' => $request->phone_number ?? '',
//            'date_of_birth' => $request->date_of_birth ?? '',
//            'ID_number' => $request->ID_number ?? '',
//            'image' => $request->image ?? '',
//            'gender' => $request->gender ?? 'male',
//            'company' => $request->company ?? '',
//            'physical_address' => $request->physical_address,
//        ]);

        Sentry::create([
            'name' => $request->name,

            'phone_number' => $request->phone_number,

            'status' => 1,

            'device_id' => $request->device_id ?? 0,

            'user_detail_id' => $user_detail->id,

            'shift_id' => $request->shift_id ?? 1,

            'premise_id' => $request->premise_id,

        ]);
        Activity::create([
            'name' => $request->user()->name,
            'target' => "Guard creation",
            'organization' => $request->user()->organization_code,
            'activity' => "Created a new guard with name" . $request->name .
                " and phone number " . $request->phone_number . "."
        ]);
        return redirect()->to('users/sentries')->with('success', 'Sentry added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sentry  $sentry
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $sentry = Sentry::find($id);
        $premises = Premise::where('status', 1)->where('id', $sentry->premise_id)->first();
        $visitors =Visitor::with('timeLogs')->where('sentry_id', $sentry->id)->get();
        $organization = Organization::where('status', 1)->where('code', $premises->organization_code)->first();
        $device= Device::where('sentry_id', $sentry->id)->first();

        $activities = Activity::where('name', $sentry->name)->paginate(10);
        $activities->appends(request()->query());
        $activities->links('pagination::bootstrap-4');

        return view('livewire.sentry.show', compact('sentry', 'device', 'premises','activities', 'organization', 'visitors'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sentry  $sentry
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sentry = Sentry::find($id);

        $premises = Premise::where('status', 1)->get();

        $shifts = Shift::where('status', 1)->get();

        return view('livewire.sentry.edit', compact('sentry', 'premises', 'shifts'));


        // return view('livewire.sentry.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSentryRequest  $request
     * @param  \App\Models\Sentry  $sentry
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $sentry = Sentry::find($id);

        $sentry->name = $request->input('name');

        $sentry->phone_number = $request->input('phone_number');

        $sentry->premise_id  = $request->input('premise_id');

        $sentry->shift_id  = $request->input('shift_id');

        $sentry->device_id  = $request->input('device_id') ?? 0;

        $sentry->save();


        return redirect()->to('/users/sentries')->with('success', 'Guard Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sentry  $sentry
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Sentry::find($id);

        $delete->delete();

        Toastr::success('Data deleted successfully :)', 'Success');

        return redirect()->route('Sentry');
    }

    public function status_update($id)
    {

        //get unit status with the help of  ID
        $sentries = DB::table('sentries')
            ->select('status')
            ->where('id', '=', $id)
            ->first();

        //Check unit status
        if ($sentries->status == '1') {
            $status = '0';
        } else {
            $status = '1';
        }

        //update unit status
        $values = array('status' => $status);
        DB::table('sentries')->where('id', $id)->update($values);

        session()->flash('msg', 'User status has been updated successfully.');
        return redirect()->route('Sentry');
    }
}

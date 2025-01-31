<?php

namespace App\Http\Livewire\Sentry;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Sentry;
use App\Models\Device;
use App\Models\Premise;
use App\Models\Shift;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public ?string $search = null;
    public $orderBy = 'id';
    public $orderAsc = true;
    public $sortTimeField = 'time';
    public $sortTimeAsc = true;

    public $userDetailsId;
    public $shiftId;

    public  $name, $email, $phone_number, $shift_id, $device_id, $premise_id;



    public function render()
    {


        $searchTerm = '%' . $this->search . '%';

        $user = Auth::user();
        $userAccountType = $user->role_id;
        if ($userAccountType===1) {
        $sentries = Sentry::with('user_detail','shift','device','premise')
            ->when($this->userDetailsId, function ($query) {
                $query->where('user_detail_id', $this->userDetailsId);
            })
            ->when($this->shiftId, function ($query) {
                $query->where('shift_id', $this->shiftId);
            })
            ->whereLike(['name','user_detail.ID_number','user_detail.phone_number', 'user_detail.company','shift.name','device.identifier','premise.name'], $searchTerm)
            ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
            ->paginate($this->perPage);

        $premises = Premise::where('status', 1) ->get();

        $shifts = Shift::where('status', 1) ->get();

        $devices = Device::all();

        return view('livewire.sentry.dashboard', [
            'sentries' => $sentries,
            'premises' => $premises,
            'shifts' => $shifts,
            'devices' => $devices,
        ]);
        } elseif ($userAccountType == 2) {
            $organization_code = Auth::user()->organization_code;
            $sentries = Sentry::with('user_detail','shift','device','premise')
                ->when($this->userDetailsId, function ($query) {
                    $query->where('user_detail_id', $this->userDetailsId);
                })
                ->when($this->shiftId, function ($query) {
                    $query->where('shift_id', $this->shiftId);
                })
                ->whereHas('premise.organization', function ($query) use ($organization_code) {
                    $query->where('code', $organization_code);
                })
                ->whereLike(['name','user_detail.ID_number','user_detail.phone_number', 'user_detail.company','shift.name','device.identifier','premise.name'], $searchTerm)
                ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
                ->paginate($this->perPage);

            $premises = Premise::where('status', 1) ->get();

            $shifts = Shift::where('status', 1) ->get();

            $devices = Device::all();

            return view('livewire.sentry.dashboard', [
                'sentries' => $sentries,
                'premises' => $premises,
                'shifts' => $shifts,
                'devices' => $devices,
            ]);
        }
    }


    private function resetInput()
    {
        $this->name = null;
        $this->email = null;
        $this->location = null;
        $this->primary_phone = null;
        $this->secondary_phone = null;
        $this->websiteUrl = null;
        $this->description = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|min:2',

            'device_id'=> 'required',

            'premise_id' => 'required',

            'shift_id' => 'required',

        ]);



        $sentry = new Sentry;

        $sentry->name = $this->name;



        $sentry->premise_id  = $this->premise_id;

        $sentry->shift_id  = $this->shift_id;

        $sentry->device_id  = $this->device_id;

        $sentry->save();


        return redirect()->route('Sentry');
    }

    public function editSentry($id)
    {

        $sentry  = Sentry::where('id', $id)->first();

        $this->sentry_edit_id = $id;

        $this->name = $sentry ->name;

        $this->phone_number = $sentry ->phone_number;

        $this->premise_id = $sentry->premise_id;

        $this->shift_id =  $sentry->shift_id;

        $this->device_id = $sentry->device_id;

        $this->dispatchBrowserEvent('show-edit-sentry-modal');
    }

    public function editsentryData()
    {

        $sentry  = Sentry::where('id', $this->sentry_edit_id)->first();

        $sentry ->name = $this->name;
        $sentry ->phone_number = $this->phone_number;
        $sentry->premise_id = $this->premise_id;
        $sentry->shift_id = $this->shift_id;
        $sentry->device_id  = $this->device_id;

        $sentry->save();

        return redirect()->route('Sentry')->with('success','Sentry updated successfully.');
    }

//    public function destroy($id)
//    {
//        if ($id) {
//            $sentry = Sentry::where('id', $id);
//            $sentry ->delete();
//
//            return redirect()->to('/users/sentries')->with('error','Sentry Deleted successfully!');
//        }
//    }

    public function activate($id, $phone_number)
    {

       Sentry::whereId($id)->update(
          ['status' => "1"]
       );
       User::where('phone_number', $phone_number)->update(
           ['status' => "1"]
       );
       return redirect()->to('/users/sentries')->with('success','Sentry Activated successfully!');
    }

    public function deactivate($id, $phone_number)
    {

       Sentry::whereId($id)->update(
          ['status' => "0"]
       );
        User::where('phone_number', $phone_number)->update(
            ['status' => "0"]
        );
       return redirect()->to('/users/sentries')->with('warning','Sentry Disabled successfully!');
    }

}

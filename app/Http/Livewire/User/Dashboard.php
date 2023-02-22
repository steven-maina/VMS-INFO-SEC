<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use App\Models\User;
use App\Models\Organization;
use App\Models\Role;
use Livewire\WithPagination;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

    public $organizationId;
    public $roleId;

    public  $name, $email, $phone_number, $role_id, $password, $organization_id;


    public function render()
    {
    
        $searchTerm = '%' . $this->search . '%';

        $users = User::with('organization','role')
            ->when($this->organizationId, function ($query) {
                $query->where('organization_id', $this->organizationId);
            })
            ->when($this->roleId, function ($query) {
                $query->where('role_id', $this->roleId);
            })
            ->whereLike(['name','organization.name','role.name'], $searchTerm)
            ->orderBy($this->orderBy, $this->orderAsc ? 'desc' : 'asc')
            ->paginate($this->perPage);

        $organizations = Organization::all();

        $roles = Role::all();


        return view('livewire.user.dashboard', [ 
            'users' => $users, 
             'organizations' => $organizations,
             'roles' => $roles,
        ]);
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

            'email' => 'required|email|max:255|unique:organizations,email',

            'phone_number'=> 'required|numeric',

            'organization_id'=> 'required|numeric',

            'role_id'=> 'required|numeric',

        ]);

        // if ($this->validator->fails()) {
        //     return response()->json(['error' => $this->validator->errors()], 400);
        // }

        $user = new User;

        $user->name = $this->name;

        $user->email = $this->email;

        $user->phone_number  = $this->phone_number;

        $user->organization_id  = $this->organization_id;

        $user->role_id  = $this->role_id;

        $user->password = Hash::make($this->password);


        $user->save();
  
        $this-> resetInput();

        return redirect()->route('OrganizationUsers');
    }

    public function edituser($id)
    {
        
        $user  = User::where('id', $id)->first();

        $this->user_edit_id = $id;

        $this->name = $user ->name;

        $this->email = $user->email;

        $this->phone_number =  $user->phone_number;

        $this->organization_id = $user->organization_id;

        $this->role_id = $user->role_id;

  

        $this->dispatchBrowserEvent('show-edit-org-modal');
    }

    public function editUserData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|max:255|unique:organizations,email',
            'phone_number'=> 'required|numeric',
           
        ]);

        $user  = User::where('id', $this->user_edit_id)->first();

        $user ->name = $this->name;
        $user->email = $this->email;
        $user->phone_number = $this->phone_number;
        $user->organization_id  = $this->organization_id;
        $user->role_id  = $this->role_id;

        $user->save();

        return redirect()->route('OrganizationUsers');
    }

    public function destroy($id)
    {
        if ($id) {
            $user = User::where('id', $id);
            $user ->delete();

            return redirect()->to('/organization/users');
        }
    }

    public function activate($id)
    {
       
       User::whereId($id)->update(
          ['status' => "1"]
       );
       return redirect()->to('/organization/users');
    }

    public function deactivate($id)
    {
       
       User::whereId($id)->update(
          ['status' => "0"]
       );
       return redirect()->to('/organization/users');
    }

}
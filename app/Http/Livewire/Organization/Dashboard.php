<?php

namespace App\Http\Livewire\Organization;


use App\Models\User;
use App\Models\Organization;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

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

    public $sortTimeAsc = true;

    public $data, $name, $email, $primary_phone, $secondary_phone, $location, $websiteUrl, $description, $organization_edit_id;

    public function sortBy($field)
    {
        if ($field === $this->sortField) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = $field;
            $this->sortAsc = true;
        }
    }

    public function render()
    {

        $searchTerm = '%' . $this->search . '%';

        $organization = Organization::withCount(['user' => function($query) {$query->where('organization_id','=','$id');}])
    
            ->whereLike(['name', 'email' ,'primary_phone','location','user.organization_id'], $searchTerm)
                
        ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
            ->paginate($this->perPage);
        return view('livewire.organization.dashboard', ['organizations' => $organization]);
    }

    public $orgs, $orgCount;

    public function mount(Organization $id)
    {
        $this->orgs = Organization::all();
        $this->orgCount = User::where('organization_id', '=', $id)->count();

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

            'primary_phone'=> 'required|numeric',

            'location' => 'required',

        ]);
    
        $code = Str::random(20);

        $organization = new Organization;

        $organization->code = $code;

        $organization->name = $this->name;

        $organization->location = $this->location;

        $organization->email = $this->email;

        $organization->primary_phone  = $this->primary_phone;

        $organization->secondary_phone  = $this->secondary_phone;

        $organization->websiteUrl  = $this->websiteUrl;

        $organization->description = $this->description;

        $organization->save();

        return redirect()->route('OrganizationInformation');

         $this->resetInput();
    }

    public function editOrganization($id)
    {
        
        $organization  = Organization::where('id', $id)->first();

        $this->organization_edit_id = $id;

        $this->name = $organization ->name;

        $this->location = $organization->location;

        $this->email =  $organization->email;

        $this->primary_phone = $organization->primary_phone;

        $this->secondary_phone = $organization->secondary_phone;

        $this->websiteUrl = $organization->websiteUrl;

        $this->description = $organization->description; 

        $this->dispatchBrowserEvent('show-edit-org-modal');
    }

    public function editOrganizationData()
    {
        //on form submit validation
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email|max:255|unique:organizations,email',
            'primary_phone'=> 'required|numeric',
            'location' => 'required',
        ]);

        $organization  = Organization::where('id', $this->organization_edit_id)->first();
        $identificationType->name = $this->name;
        $organization ->name = $this->name;
        $organization->location = $this->location;
        $organization->email = $this->email;
        $organization->primary_phone  = $this->primary_phone;
        $organization->secondary_phone  = $this->secondary_phone;
        $organization->websiteUrl  = $this->websiteUrl;
        $organization->description = $this->description;
        $organization->save();

        return redirect()->route('OrganizationInformation');
    }

    public function destroy($id)
    {
        if ($id) {
            $organization = Organization::where('id', $id);
            $organization ->delete();

            return redirect()->to('/organization/information');
        }
    }

    public function activate($id)
    {
       
       Organization::whereId($id)->update(
          ['status' => "1"]
       );
       return redirect()->to('/organization/information');
    }

    public function deactivate($id)
    {
       
       Organization::whereId($id)->update(
          ['status' => "0"]
       );
       return redirect()->to('/organization/information');
    }


}
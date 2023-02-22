<div>
            <div class="card">
                <h5 class="card-header">Search Filter</h5>
                <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                    <div class="col-md-4 resident_role">
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i data-feather="search"></i></span>
                            </div>
                            <input wire:model="search" type="search" id="search" class="form-control" name="search"
                              placeholder="Search" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="selectSmall">Select Per Page</label>
                            <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall" id="table1">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="selectSmall">Sort</label>
                            <select wire:click.prevent="sortBy('name')" class="form-control form-control-sm" id="selectSmall">
                          
                            <option value="desc">Ascending</option>
                                <option value="asc">Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                    <button type="button" class="btn btn-icon btn-outline-success" style="background-color: #1877F2; color:#fff;"  data-toggle="modal" id="smallButton" data-target="#modals-slide-in" 
                            data-placement="top" title="New resident">
                          + Add New Resident
                               
                        </button>
                    </div>
                </div>
            </div>
            <!-- residents filter end -->
            {{-- @include('partials.loaderstyle') --}}
            <!-- list section start -->
            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                    <div class="card-datatable table-responsive">
                        <table class="table" >
                            <thead>
                                <tr>
                             
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>PhoneN umber</th>
                                    <th>Unit Name</th>
                                    <th>Status</th>
                                    <th>Last Login</th>
                                    <th>Check Out</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>

                         

                            <tbody>
                            @forelse ($residents as $key => $resident)
                                <tr>
                                    <!-- <td> {{ $resident ->id }} </td> -->
                                    <td> {{ $resident ->name }} </td>

                                    <td>{{ $resident ->email }}</td>
                                    <td> {{ $resident ->phone_number }} </td>
                                   
                                    <td>{!! $resident->unit()->pluck("name")->implode('')!!} </td>
                                
                                  
                                     <td>
                                     <?php if($resident->status == '1'){ ?> 

                                        <a href="#" class="Active" style="color:#73A561;">Active</a>

                                        <?php }else{ ?> 

                                        <a href="#" class="inactive" style="color:#8B0000;">Disabled</a>

                                        <?php } ?>
                                    
                                    </td>
                                    <td>{{ now() }}</td>
                                    <td>{{ now() }}</td>
                                    <td>
                                        <div class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                        <div class="dropdown-menu">

                                                <!--update link-->
                                        <a  wire:ignore.self href="#" class="" wire:click="editresident({{ $resident->id }})" style="padding-right:20px"  data-toggle="modal" id="smallButton" data-target="#modals-edit-slide-in"  data-placement="top" > Edit </a>
                                        <!-- delete link -->
                                        <?php if($resident->status == '0'){ ?>
                                        <a wire:ignore.self href="#" wire:click="activate({{ $resident->id }})"  onclick="return confirm('Are you sure to want to Activate the resident?')" style="padding-right:20px; " > Activate </a>
                                        <?php }else{ ?>
                                        <a wire:ignore.self href="#" wire:click="deactivate({{ $resident->id }})"  onclick="return confirm('Are you sure to want to suspend the resident?')" style="padding-right:20px; " > Suspend</i> </a>
                                        <?php } ?>

                                        <a wire:ignore.self href="#" wire:click="destroy({{ $resident->id }})" onclick="return confirm('Are you sure to want to delete the resident?')" > Delete </a>

                                        </div>
                                        </div>
                                        </td>
                                </tr>
                              
                         
                                @empty
                                <tr>
                                    <td colspan="8" style="text-align: center; ">No Record Found</td>
                                </tr>
                            @endforelse
                       
                            </tbody>
                          
                        </table>
             
                        <div style="margin-left: 80%"  class="mt-1">{{ $residents->links() }}
                        </div>
                    </div>
                </div>
   
        </div>

    
              <!-- Modal to add new resident starts-->
    <div wire:ignore.self class="modal modal-slide-in new-resident-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-resident modal-content pt-0" >
        {{ csrf_field() }} 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">New Resident</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
              <input  type="text" wire:model="name"  class="form-control" required />

            </div>
   
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-email">Email</label>
              <input  type="email" wire:model="email"  class="form-control" required />

              <small class="form-text text-muted"> You can use letters, numbers & periods </small>
            </div>
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Phone Number</label>
              <input  type="tel" wire:model="phone_number"  class="form-control" required />

            </div>


            <fieldset class="form-group">
              <label class="form-label" for="resident-role">Organization</label>
              <select id="organization_id" wire:model="organization_id" class="form-control">
               <option  value="#"> Select</option>
                @foreach ($organizations as $organizat)
                    <option  value="{{ $organizat ->id }}"> {{ $organizat ->name }}</option>
                @endforeach  
              </select>
            </fieldset>

            <fieldset class="form-group">
              <label class="form-label" for="resident-role">Role</label>
              <select id="role_id" wire:model="role_id" class="form-control" required>
              <option  value="#"> Select</option>
                @foreach ($roles as $ros)
                    <option  value="{{ $ros ->id }}"> {{ $ros ->name }}</option>
                @endforeach  
              </select>
            </fieldset>



            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Password</label>
              <input  type="password" wire:model="password"  class="form-control" required />
            </div>
            
            <button wire:click="store" type="submit" class="btn btn-primary mr-1 data-submit">     {{ __('Register') }} </button>
            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new resident Ends-->

     <!-- Modal to Edit resident starts-->
     <div wire:ignore.self class="modal modal-slide-in new-resident-modal fade" id="modals-edit-slide-in">
      <div class="modal-dialog">
        <form class="add-new-resident modal-content pt-0" >
        {{ csrf_field() }} 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Edit resident</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
              <input  type="text" wire:model="name"  class="form-control" required />

            </div>
   
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-email">Email</label>
              <input  type="email" wire:model="email"  class="form-control" required />

              <small class="form-text text-muted"> You can use letters, numbers & periods </small>
            </div>
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Phone Number</label>
              <input  type="tel" wire:model="phone_number"  class="form-control" required />

            </div>


            <fieldset class="form-group">
              <label class="form-label" for="resident-role">Organization</label>
              <select id="organization_id" wire:model="organization_id" class="form-control">
               <option  value="#"> Select</option>
                @foreach ($organizations as $organ)
                    <option  value="{{ $organ ->id }}"> {{ $organ ->name }}</option>
                @endforeach  
              </select>
            </fieldset>

            <fieldset class="form-group">
              <label class="form-label" for="resident-role">Role</label>
              <select id="role_id" wire:model="role_id" class="form-control" required>
              <option  value="#"> Select</option>
                @foreach ($roles as $roll)
                    <option  value="{{ $roll ->id }}"> {{ $roll ->name }}</option>
                @endforeach  
              </select>
            </fieldset>

            
            <button wire:click="editresidentData" type="submit" class="btn btn-primary mr-1 data-submit">     {{ __('Update') }} </button>
            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to Edit resident Ends-->

      <!-- Dashboard Ecommerce ends -->
      @push('scripts')
    <script>


        window.addEventListener('show-edit-org-modal', event =>{
            $('#modals-edit-slide-in').modal('show');
        });

    
    </script>
@endpush

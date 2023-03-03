<div>
            <div class="card">
                <h5 class="card-header">Search Filter</h5>
                <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                    <div class="col-md-4 user_role">
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i data-feather="search"></i></span>
                            </div>
                            <input wire:model="search" type="text" id="fname-icon" class="form-control" name="fname-icon"
                                placeholder="Search" />
                        </div>
                    </div>
                  
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="selectSmall">Premise</label>
                            <select wire:model="premiseId" class="form-control form-control-sm" >
                                <option value="">  All  </option>
                                @foreach ($premises as $pre)
                                    <option  value="{{ $pre ->id }}"> {{ $pre ->name }}</option>
                                @endforeach  
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="selectSmall">Select Per Page</label>
                            <select wire:model="perPage" class="form-control form-control-sm" id="selectSmall">
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                    <button type="button" class="btn btn-icon btn-outline-success" style="background-color: #1877F2; color:#fff;"  data-toggle="modal" id="smallButton" data-target="#modals-slide-in" 
                            data-placement="top" > + Add Block   
                        </button>
                    </div>
                </div>
            </div>
            <!-- users filter end -->
            {{-- @include('partials.loaderstyle') --}}

            @include('livewire.Notification.flash-message')
            
            <!-- list section start -->
            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                    <div class="card-datatable table-responsive">
                        <table class="table">
                            <thead>
                                <tr>        
                                   <th>Block Name</th>
                                   <th>Premise</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse ($blocks as $block)
                                <tr>
                                   
                                    <td> {{ $block ->name }} </td>
                                    <td>{!! $block->premise()->pluck("name")->implode('')!!} </td>
                                    <td>{{ $block ->created_at }}</td>
                                    <td>
                                     <?php if($block->status == '1'){ ?> 
                                             <span class="badge badge-pill badge-light-success mr-1">Active</span>
                                    
                                     <?php }else{ ?> 
                                             <span class="badge badge-pill badge-light-warning mr-1">Disabled</span>

                                      <?php } ?>
                                    
                                    </td>
                                   
                                    <td>
<div class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    <i class="fas fa-ellipsis-v"></i>
</a>
<div class="dropdown-menu">

        <!--update link-->
        <a  href="{{ route('BlockInformation.edit',$block->id)}}" class="" style="padding-right:20px"   id="smallButton"   data-placement="top" > Edit </a>  
<!-- delete link -->
<?php if($block->status == '0'){ ?>
<a wire:ignore.self href="#" wire:click="activate({{ $block->id }})"  onclick="return confirm('Are you sure to want to Activate the block?')" style="padding-right:20px; " > Activate </a>
<?php }else{ ?>
<a wire:ignore.self href="#" wire:click="deactivate({{ $block->id }})"  onclick="return confirm('Are you sure to want to suspend the block?')" style="padding-right:20px; " > Suspend</i> </a>
<?php } ?>

<a wire:ignore.self href="#" wire:click="destroy({{ $block->id }})" onclick="return confirm('Are you sure to want to delete the block?')" > Delete </a>

</div>
</div>
</td>
                                </tr>

                                @empty
                                <tr>
                                <td colspan="5" style="text-align: center;"> No Record Found </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <div style="margin-left: 80%"  class="mt-1">{{ $blocks->links() }}
                        </div>
                    </div>
                </div>
 
        </div>



         <!-- Modal to add new block starts-->
    <div wire:ignore.self class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-user modal-content pt-0" method="POST" action="{!! route('BlockInformation.store') !!}">
        {{ csrf_field() }} 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">New Block</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Block Name</label>
              <input  type="text" name="name"  class="form-control" required />

            </div>
            <fieldset class="form-group">
              <label class="form-label" for="user-role">Premise Name</label>
              <select id="premise_id"  name="premise_id" class="form-control">
                
                @foreach ($premises as $premise)
                    <option  value="{{ $premise ->id }}"> {{ $premise ->name }}</option>
                @endforeach  
              </select>
            </fieldset>
            
            <button type="submit" class="btn btn-primary mr-1 data-submit">     {{ __('Register') }} </button>
            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new block Ends-->

          <!-- Modal to edit block starts-->
          <div wire:ignore.self class="modal modal-slide-in new-user-modal fade" id="modals-edit-slide-in">
      <div class="modal-dialog">
        <form class="add-new-user modal-content pt-0" >
        {{ csrf_field() }} 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">Edit Block</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Block Name</label>
              <input  type="text" wire:model="name"  class="form-control" required />

            </div>
            <fieldset class="form-group">
              <label class="form-label" for="user-role">Premise Name</label>
              <select id="premise_id"  wire:model="premise_id" class="form-control">
                
                @foreach ($premises as $premise)
                    <option  value="{{ $premise ->id }}"> {{ $premise ->name }}</option>
                @endforeach  
              </select>
            </fieldset>
            
            <button wire:click="editBlockData" type="submit" class="btn btn-primary mr-1 data-submit">     {{ __('Update') }} </button>
            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new block Ends-->



    @push('scripts')
    <script>
  

        window.addEventListener('show-edit-block-modal', event =>{
            $('#modals-edit-slide-in').modal('show');
        });

    
    </script>
@endpush
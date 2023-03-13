  <!-- Modal to add new resident starts-->
    <div wire:ignore.self class="modal modal-slide-in new-resident-modal fade" id="modals-slide-in">
      <div class="modal-dialog">
        <form class="add-new-resident modal-content pt-0"  method="POST" action="{!! route('ResidentInformation.store') !!}">
        {{ csrf_field() }} 
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
          <div class="modal-header mb-1">
            <h5 class="modal-title" id="exampleModalLabel">New Resident</h5>
          </div>
          <div class="modal-body flex-grow-1">
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Full Name</label>
              <input  type="text" name="name"  class="form-control" required />

            </div>
   
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-email">Email</label>
              <input  type="email" name="email"  class="form-control" required />

              <small class="form-text text-muted"> You can use letters, numbers & periods </small>
            </div>
            <div class="form-group">
              <label class="form-label" for="basic-icon-default-fullname">Phone Number</label>
              <input  type="tel" name="phone_number"  class="form-control" required />

            </div>


     <fieldset class="form-group">
              <label class="form-label" for="resident-role">Block</label>
              <select id="unit_id" name="unit_id" class="select2 form-control form-control-lg" wire:model="selectedBlock" >
               <option  value="0"> Select</option>
                @foreach ($blocks as $uni)
                    <option  value="{{ $uni ->id }}"> {{ $uni ->name }}</option>
                @endforeach  
              </select>
            </fieldset>

      @if (!is_null($units))
            <fieldset class="form-group">
              <label class="form-label" for="resident-role">Unit</label>
              <select id="unit_id" name="unit_id" class="form-control" wire:model="selectedUnit">
               <option  value="0"> Select</option>
                @foreach ($units as $uni)
                    <option  value="{{ $uni ->id }}"> {{ $uni ->name }}</option>
                @endforeach  
              </select>
            </fieldset>

                @endif

            {{ $selectedUnit }}




            <button type="submit" class="btn btn-primary mr-1 data-submit">     {{ __('Register') }} </button>
          
            <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
          </div>
        </form>
      </div>
    </div>
    <!-- Modal to add new resident Ends-->



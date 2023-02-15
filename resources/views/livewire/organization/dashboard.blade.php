{{--@if (session('success'))--}}
{{--    <div class="alert alert-success">--}}
{{--        {{ session('success') }}--}}
{{--    </div>--}}
{{--@endif--}}

    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">
        <section>
            <!-- users filter start -->
            <div class="card">
                <h5 class="card-header">Search Filter</h5>
                <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">
                    <div class="col-md-4 user_role">
                        <div class="input-group input-group-merge">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i data-feather="search"></i></span>
                            </div>
                            <input type="text" id="search" class="form-control" name="search"
                                placeholder="Search" />
                        </div>
                    </div>

                    <div class="col-ms-3">
                        <label style="color: #070707" for="">Items Per</label>
                        <select wire:model="perPage" class="form-control">`
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="selectSmall">Sort</label>
                            <select class="form-control form-control-sm" id="selectSmall">
                                <option value="1">Ascending</option>
                                <option value="0">Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-icon btn-outline-success" data-toggle="modal" id="smallButton" data-target="#modals-slide-in"
                            data-placement="top" title="New Organazition">Add new Organization               </button>
                    </div>
                </div>
            </div>
            <!-- users filter end -->
            {{-- @include('partials.loaderstyle') --}}
            <!-- list section start -->
            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                    <div class="card-datatable table-responsive">
                        <table class="invoice-list-table table" >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody class="alldata">
                            @foreach ($organizations as $org)
                                <tr>
                                    <td>{{ $org ->code }}</td>
                                    <td>{{ $org ->name }}</td>
                                    <td>{{ $org ->email }}</td>
                                    <td>
                                    <?php if($org->status == '1'){ ?>

                                    <a href="#" class="Active" style="color:#00FF00;">Active</a>

                                    <?php }else{ ?>

                                    <a href="#" class="inactive" style="color:#FF0000;">Suspended</a>

                                    <?php } ?>

                                    </td>
                                    <td>{{ $org ->location }}</td>
                                    <td>



                                          <div class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu">

                                                   <!--update link-->
                                        <a href="{{ url('organization/users/'.$org->id) }}" class="" style="padding-right:20px"  data-toggle="modal" id="smallButton" data-target="#modals-edit-slide-in"  data-placement="top" > Edit   </a>
                                        <!-- delete link -->
                                        <?php if($org->status == '0'){ ?>
                                        <a href="{{ url('organization/information/suspend/'.$org->id) }}" onclick="return confirm('Are you sure to want to Activate the organization?')" style="padding-right:20px; " > Activate </a>
                                        <?php }else{ ?>
                                            <a href="{{ url('organization/information/suspend/'.$org->id) }}" onclick="return confirm('Are you sure to want to suspend the organization?')" style="padding-right:20px; " > Suspend</i> </a>
                                        <?php } ?>

                                        <a href="{{ url('organization/information/delete/'.$org->id) }}" onclick="return confirm('Are you sure to want to delete the organization?')" > Delete </a>

                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                            <tbody id="Content" class="searchdata"></tbody>
                        </table>
                        <div class="mt-1">{!! $organizations->links() !!}</div>
                        <div class="mt-1">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </div>
   <!-- Modal to add new organization starts-->
        <div class="modal modal-slide-in new-user-modal fade" id="modals-slide-in">
            <div class="modal-dialog">
                <form class="add-new-user modal-content pt-0" method="POST" action="{!! route('OrganizationInformation.store') !!}">
                    @csrf
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">×</button>
                    <div class="modal-header mb-1">
                        <h5 class="modal-title" id="exampleModalLabel">New Organization</h5>
                    </div>
                    <div class="modal-body flex-grow-1">
                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-fullname">Name</label>
                            <input
                                type="text"
                                name="name"
                                :value="old('name')"
                                class="form-control dt-full-name"
                                id="basic-icon-default-fullname"
                                aria-describedby="basic-icon-default-fullname2" required
                            />
                        </div>


                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-email">Email</label>
                            <input
                                type="email"
                                name="email"
                                :value="old('email')"
                                class="form-control dt-email"
                                aria-describedby="basic-icon-default-email2"
                                id="user-email" required
                            />
                            <small class="form-text text-muted"> You can use letters, numbers & periods </small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-email">Phone Number</label>
                            <input
                                type="tel"
                                name="phone"
                                :value="old('email')"
                                class="form-control dt-phone"
                                aria-describedby="basic-icon-default-phone"
                                id="phone" required
                            />
                            <small class="form-text text-muted"> You can numbers</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-email">Other Phone Number</label>
                            <input
                                type="tel"
                                name="phone2"
                                :value="old('email')"
                                class="form-control dt-phone"
                                aria-describedby="basic-icon-default-phone"
                                id="phone2"
                            />
                            <small class="form-text text-muted"> You can numbers</small>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-fullname">Location</label>
                            <input
                                type="text"
                                name="location"
                                :value="old('location')"
                                class="form-control dt-full-name"
                                id="basic-icon-default-location"
                                aria-describedby="basic-icon-default-location2" required
                            />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-fullname">Website URL</label>
                            <input
                                type="text"
                                name="url"
                                :value="old('url')"
                                class="form-control dt-full-url"
                                id="basic-icon-default-url"
                                aria-describedby="basic-icon-default-url"
                            />
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="basic-icon-default-fullname">Organization Description</label>
                            <input
                                type="text"
                                name="description"
                                :value="old('description')"
                                class="form-control dt-full-description"
                                id="basic-icon-default-description2"
                                aria-describedby="basic-icon-default-description2" required
                            />
                        </div>

                        <button type="submit" class="btn btn-primary mr-1 data-submit">     {{ __('Register') }} </button>
                        <button type="reset" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    <!-- Modal to add new organization Ends-->


{{--        <h2 class="brand-text">TODO ON ORGANIZATIONS</h2>--}}
{{--        <div class="card-body">--}}
{{--            <div id="jstree-basic">--}}
{{--                <ul>--}}
{{--                    <li class="jstree-open" data-jstree='{"icon" : "far fa-folder"}'>--}}
{{--                        CRUD--}}
{{--                        <ul>--}}
{{--                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Create</li>--}}
{{--                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Read</li>--}}
{{--                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Updated</li>--}}
{{--                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Delete</li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="jstree-open" data-jstree='{"icon" : "far fa-folder"}'>--}}
{{--                        Action--}}
{{--                        <ul data-jstree='{"icon" : "far fa-folder"}'>--}}
{{--                            <li data-jstree='{"icon" : "far fa-file-image"}'>Suspend</li>--}}
{{--                            <li data-jstree='{"icon" : "far fa-file-image"}'>Others</li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="jstree-open" data-jstree='{"icon" : "far fa-folder"}'>--}}
{{--                        Relationship--}}
{{--                        <ul data-jstree='{"icon" : "far fa-folder"}'>--}}
{{--                            <li data-jstree='{"icon" : "far fa-file-image"}'>Users</li>--}}
{{--                            <li data-jstree='{"icon" : "far fa-file-image"}'>Organization</li>--}}
{{--                            <li data-jstree='{"icon" : "far fa-file-image"}'>Hierarchy under Organization</li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="jstree-open" data-jstree='{"icon" : "far fa-folder"}'>--}}
{{--                        Table--}}
{{--                        <ul>--}}
{{--                            <li data-jstree='{"icon" : "fab fa-node-js"}'>Filter</li>--}}
{{--                            <li data-jstree='{"icon" : "fab fa-node-js"}'>Pagination</li>--}}
{{--                            <li data-jstree='{"icon" : "fab fa-node-js"}'>Search by *</li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li data-jstree='{"icon" : "fab fa-html5"}'>Any Other</li>--}}
{{--                    <li data-jstree='{"icon" : "fab fa-html5"}'>Martin to Advise</li>--}}
{{--                    <li data-jstree='{"icon" : "fab fa-html5"}'>Isaac to Provide images, and secondary colors</li>--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
        <script type="application/javascript">
            $(document).on('click', '.dropdown-toggle', function(e) {
                e.preventDefault();
                $(this).next('.dropdown-menu').toggle();
            });
            $(document).on('mouse-enter', '.dropdown-toggle', function(e) {
                e.preventDefault();
                $(this).next('.dropdown-menu').toggle();
            });
        </script>
    </section>
    <!-- Dashboard Ecommerce ends -->

@section('vendor-script')
<script type="text/javascript">

      $('#search').on('keyup',function()
      {
       $value=$(this).val();

       if($value)
       {
        $('.alldata').hide();
        $('.searchdata').show();
       }
       else{
        $('.alldata').show();
        $('.searchdata').hide();
       }
       $.ajax({

            type : 'get',
            url : '{{URL::to('search')}}',
            data:{'search':$value},

     success:function(data)
     {
            $('#Content').html(data);
    }
    });
    })
    </script>

    {{-- vendor files --}}
    <script src="{{ asset(mix('vendors/js/charts/apexcharts.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/toastr.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/extensions/jstree.min.js')) }}"></script>
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pages/dashboard-ecommerce.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
@endsection


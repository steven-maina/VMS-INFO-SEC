
@extends('layouts.contentLayoutMaster')
@section('title', 'User Settings')

@section('vendor-style')
  <!-- vendor css files -->
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

@section('vendor-style')
    {{-- vendor css files --}}
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/charts/apexcharts.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('fonts/font-awesome/css/font-awesome.min.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/jstree.min.css')) }}">
@endsection
@section('page-style')
    {{-- Page css files --}}

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-tree.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/pages/dashboard-ecommerce.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/charts/chart-apex.css')) }}">
    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">
@endsection

@section('content')
    @if(Auth::check() && Auth::user()->role_id == 1)
    <section id="page-account-settings">
            @if (session('status'))
                <div class="col-md-6 col-xl-12">
                    <div class="card bg-success text-white">
                      <div class="card-body">
                        <p class="card-text">    {{ session('status') }}</p>
                      </div>
                    </div>
                  </div>
            @elseif (session('error'))
                <div class="col-md-6 col-xl-12">
                    <div class="card bg-danger text-white">
                      <div class="card-body">
                        <p class="card-text"> {{ session('error') }}</p>
                      </div>
                    </div>
                  </div>
            @endif
        <div class="row">
            <!-- left menu section -->
            <div class="col-md-3 mb-2 mb-md-0">
                <ul class="nav nav-pills flex-column nav-left">

                    <!-- change password -->
                    <li class="nav-item">
                        <a class="nav-link active" id="account-pill-password" data-toggle="pill" href="#account-vertical-password"
                            aria-expanded="false">
                            <i data-feather="user" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">General</span>
                        </a>
                    </li>


                                    {{-- <li class="nav-item">
                        <a class="nav-link" id="account-pill-general" data-toggle="pill"
                            href="#account-vertical-general" aria-expanded="true">

                            <i data-feather="lock" class="font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">Reset Password</span>
                        </a>
                    </li> --}}
                </ul>
            </div>
            <!--/ left menu section -->

            <!-- right content section -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">



                            <!-- general tab -->
                            <div role="tabpanel" class="tab-pane fade" id="account-vertical-general"
                                aria-labelledby="account-pill-general" aria-expanded="true">




                                <!-- form -->
                                <form class="validate-form" action="" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-new-password">New Password</label>
                                                <div class="input-group form-password-toggle input-group-merge">
                                                    <input type="password" id="account-new-password" name="new_password"
                                                        class="form-control" placeholder="New Password"/>
                                                    <div class="input-group-append">
                                                        <div class="input-group-text cursor-pointer">
                                                            <i data-feather="eye"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary mr-1 mt-1">Save changes</button>
                                            <button type="reset" class="btn btn-outline-secondary mt-1">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <!--/ general tab -->

                            <!-- change password -->
                            <div class="tab-pane  active" id="account-vertical-password" role="tabpanel"
                                aria-labelledby="account-pill-password" aria-expanded="false">



                                <!-- form -->
                                <form class="validate-form mt-2" method="post" action="{{ route('OrganizationUsers.update', $user->id) }}">
                                @method('PATCH')
            @csrf
                                <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-username">Full Names</label>
                                                <input type="text" class="form-control"
                                                    name="name"
                                                    value="{{ $user ->name }}"  required/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-name">Email</label>
                                                <input type="email" class="form-control"
                                                 name="email"
                                                  value="{{ $user ->email}}"   required/>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label for="account-e-mail">Phone Number</label>
                                                <input type="tel" class="form-control"
                                                    name="phone_number"
                                                    value="{{ $user ->phone_number }}"
                                                required/>
                                            </div>
                                        </div>


                                        <div class="col-12 col-sm-6">
                                        <fieldset class="form-group">
                                          <label  for="user-role">Organization</label>
                                          <select  name="organization_code" class="form-control" required>
                                            @foreach ($organizations as $organizat)
                                            
                                                <option value="{{ $organizat ->code }}" @if($organizat ->code == $user->organization_code) selected @endif>{{ $organizat->name }}</option>
                                            @endforeach
                                          </select>
                                        </fieldset>
                                        </div>


                                        <div class="col-12 col-sm-6">
                                        <fieldset class="form-group">
                                          <label  for="user-role">Role</label>
                                          <select  name="role_id" class="form-control" required>
                                            @foreach ($roles as $ros)
                                               
                                                <option value="{{ $ros->id }}" @if($ros->id == $user->role_id) selected @endif>{{ $ros->name }}</option>
                                            @endforeach
                                          </select>
                                        </fieldset>
                                        </div>

                                        <div class="col-12">
                                        <button type="submit" class="btn btn-primary mr-1 mt-1">Update</button>

                                        <a href="{{ route('OrganizationUsers') }}" type="reset" class="btn btn-outline-secondary mt-1">Cancel</a>
                                    </div>

                                    </div>
                                </form>
                                <!--/ form -->
                            </div>
                            <!--/ change password -->


                        </div>
                    </div>
                </div>
            </div>
            <!--/ right content section -->
        </div>
    </section>
    @else
    <div class="misc-inner p-2 p-sm-3">
            <div class="w-100 text-center">
                <h2 class="mb-1">You are not authorized! 🔐</h2>
                <p class="mb-2">Sorry, but you do not have the necessary permissions to access this page.</p>
                <img class="img-fluid" src="{{asset('images/pages/not-authorized.svg')}}" alt="Not authorized page" />
            </div>
        </div>
    @endif
@endsection


@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-tooltip-valid.js')) }}"></script>
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pages/dashboard-ecommerce.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
@endsection

@extends('layouts.contentLayoutMaster')

@section('title', 'Services Catergory')

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
                            <input type="text" id="fname-icon" class="form-control" name="fname-icon"
                                placeholder="Search" />
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="selectSmall">Select Per Page</label>
                            <select class="form-control form-control-sm" id="selectSmall">
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
                            <select class="form-control form-control-sm" id="selectSmall">
                                <option value="1">Ascending</option>
                                <option value="0">Descending</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-icon btn-outline-success" data-toggle="tooltip"
                            data-placement="top" title="New Booking">
                            <img src="{{ asset('images/icons/excel.png') }}"alt="Add" width="20" height="20"
                                data-toggle="tooltip" data-placement="top" title="Export Excel">
                        </button>
                    </div>
                </div>
            </div>
            <!-- users filter end -->
            {{-- @include('partials.loaderstyle') --}}
            <!-- list section start -->
            <div class="card">
                <div class="pt-0 card-datatable table-responsive">
                    <div class="card-datatable table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Catering</td>
                                    <td>{{ now() }}</td>
                                    <td>View/Delete</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Cleaning</td>
                                    <td>{{ now() }}</td>
                                    <td>View/Delete</td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="mt-1">
                        </div>
                    </div>
                </div>
        </section>
        </div>

        <h2 class="brand-text">TODO ON Services Catergories</h2>
        <div class="card-body">
            <div id="jstree-basic">
                <ul>
                    <li class="jstree-open" data-jstree='{"icon" : "far fa-folder"}'>
                        CRUD
                        <ul>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Create</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Read</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Updated</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Delete</li>
                        </ul>
                    </li>
                    {{-- <option value="1">Utilities - Water and Power</option>
                    <option value="2">Logistics and Transport</option>
                    <option value="3">Security Service Provider</option>
                    <option value="4">Entertainment Service Provider</option>
                    <option value="5">Media and Entertainment</option>
                    <option value="6">Data Collection</option>
                    <option value="7">Government Agency</option>
                    <option value="8">Casual Workers</option>
                    <option value="9">Cleaning Service Provider</option>
                    <option value="10">Maintenance Service Provider</option>
                    <option value="12">Financial Services Provider</option> --}}
                    <li class="jstree-open" data-jstree='{"icon" : "far fa-folder"}'>
                        Examples
                        <ul>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Utilities - Water and Power</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Logistics and Transport</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Security Service Provider</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Entertainment Service Provider</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Data Collection</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Casual Workers</li>
                            <li data-jstree='{"icon" : "fab fa-css3-alt"}'>Financial Services Provider</li>
                        </ul>
                    </li>
                    <li class="jstree-open" data-jstree='{"icon" : "far fa-folder"}'>
                        Table
                        <ul>
                            <li data-jstree='{"icon" : "fab fa-node-js"}'>Filter</li>
                            <li data-jstree='{"icon" : "fab fa-node-js"}'>Pagination</li>
                            <li data-jstree='{"icon" : "fab fa-node-js"}'>Search by *</li>
                        </ul>
                    </li>
                    <li data-jstree='{"icon" : "fab fa-html5"}'>Any Other</li>
                    <li data-jstree='{"icon" : "fab fa-html5"}'>Martin to Advise</li>
                    <li data-jstree='{"icon" : "fab fa-html5"}'>Isaac to Provide images, and secondary colors</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Dashboard Ecommerce ends -->
@endsection

@section('vendor-script')
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

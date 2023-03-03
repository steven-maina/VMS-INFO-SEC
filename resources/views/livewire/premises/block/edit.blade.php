@extends('layouts.contentLayoutMaster')

@section('title', 'Block Setting')

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
  
<section id="multiple-column-form">
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">#{{ $block ->name }}</h4>
      </div>
      <div class="card-body">
      
      
      
      
        <form class="form"  method="post" action="{{ route('BlockInformation.update', $block->id) }}">
        @method('PATCH') 
        @csrf  
        <div class="row">


            <div class="col-md-6 col-12">
              <div class="form-group">
                <label for="last-name-column">Block Name</label>
                    <input type="name" class="form-control"  name="name" value="{{ $block ->name}}"   />
              </div>
            </div>

            <div class="col-12 col-sm-6">
                                        <fieldset class="form-group">
                                          <label  for="user-role">Premise Name</label>
                                          <select  name="premise_id" class="form-control">
                                          <option  value="{{ $block ->premise_id }}" > Select ...</option>
                                            @foreach ($premise as $pre)
                                                <option  value="{{ $pre ->id }}"> {{ $pre ->name }}</option>
                                            @endforeach  
                                          </select>
                                        </fieldset>
                                        </div>
                                        

            <div class="col-12">
              <button type="submit" class="btn btn-primary mr-1">Update</button>
              <button type="reset" class="btn btn-outline-secondary">Cancel</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</section>
<!-- Basic Floating Label Form section end -->


@endsection


@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pages/dashboard-ecommerce.js')) }}"></script>
    <script src="{{ asset(mix('js/scripts/extensions/ext-component-tree.js')) }}"></script>
@endsection

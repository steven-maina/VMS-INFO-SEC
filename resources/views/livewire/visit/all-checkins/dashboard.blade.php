@php
    use Carbon\Carbon;
@endphp


<div>

    <div class="card">
        <h5 class="card-header">Search Filter</h5>
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">

            <div class="col-md-4">
                <div class="form-group">
                    <label for="selectSmall"> Visitor Type </label>
                    <select wire:model="visitorTypeId" class="form-control form-control-sm">
                        <option value=""> All </option>
                        @foreach ($visitorTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>

                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label for="selectSmall"> Check-In Type </label>
                    <select wire:model="visitorTypeId" class="form-control form-control-sm">
                        <option value=""> All </option>
                        @foreach ($checkInTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>


            <div class="col-md-4">
                <div class="form-group">
                    <label for="selectSmall">Time</label>
                    <select wire:model="timeFilter" wire:change="applyTimeFilter" class="form-control form-control-sm">
                        <option value="all">Select Time Duration </option>
                        <option value="daily">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                    </select>
                </div>
            </div>

        </div>
    </div>
    <!-- users filter end -->
    <!-- users filter end -->
    {{-- @include('partials.loaderstyle') --}}


    @include('livewire.Notification.flash-message')

    <!-- list section start -->
    <div class="card">
        <div class="pt-0 pb-2 d-flex justify-content-between align-items-center mx-50 row">


            <div class="col-md-4 user_role">
                <div class="input-group input-group-merge">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i data-feather="search"></i></span>
                    </div>
                    <input wire:model.debounce.300ms="search" type="search" id="search" class="form-control"
                        name="search" placeholder="Search" />
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
                    <label for="selectSmall">Sort By Time</label>
                    <select wire:model="sortTimeAsc" class="form-control form-control-sm" id="selectSmall">
                        <option value="1">Ascending</option>
                        <option value="0">Descending</option>
                    </select>
                </div>
            </div>



        </div>


        <div class="pt-0 card-datatable table-responsive">
            <div class="card-datatable table-responsive">



                <table class="table">
                    <thead>
                        <tr>
                            {{--                            <th wire:click="sortBy('id')">ID --}}
                            {{--                                @if ($sortField === 'id') --}}
                            {{--                                    @if ($sortAsc) --}}
                            {{--                                        <i class="fas fa-sort-up"></i> --}}
                            {{--                                    @else --}}
                            {{--                                        <i class="fas fa-sort-down"></i> --}}
                            {{--                                    @endif --}}
                            {{--                                @endif --}}
                            {{--                            </th> --}}
                            <th wire:click="sortBy('name')">Name
                                @if ($sortField === 'name')
                                    @if ($sortAsc)
                                        <i class="fas fa-sort-up"></i>
                                    @else
                                        <i class="fas fa-sort-down"></i>
                                    @endif
                                @endif

                                @endif
                            </th>
                            <th>Site</th>
                            <th>Section</th>
                            <th>Organization</th>
                            <th>Check-in type</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Duration</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($visitors as $key => $visitor)
                            <td>{!! $visitor->name !!} </td>
                            <td>{{ $visitor->resident->unit->block ? $visitor->resident->unit->block->premise->name : '' }}
                            </td>
                            <td>{!! $visitor->resident->unit->name !!}</td>
                            <td>{!! $visitor->resident->unit->block->premise->organization()->pluck('name')->implode('') !!}</td>
                            <td>{!! $visitor->type !!} </td>
                            <td>{!! $visitor->timeLog->entry_time ?? null !!}</td>
                            @if (!isset($visitor->timeLog->exit_time))
                                <td>...</td>
                                <td> <span class="mr-1 badge badge-pill badge-light-primary">Visit Active</span> </td>
                            @else
                                <td>{!! $visitor->timeLog->exit_time ?? null !!}</td>

                                <td>
                                    <span class="mr-1 badge badge-pill badge-light-dark">
                                        {!! Carbon::parse($visitor->timeLog->entry_time ?? now())->diff(Carbon::parse($visitor->timeLog->exit_time ?? now()))->format('%H Hrs %I Mins ') !!}
                                    </span>
                                </td>
                            @endif
                            <td>
                                <a href="{{ route('VisitAllCheckIn.show', $visitor->id) }}">
                                    <i class="fa fa-eye" style="color:#808080"> </i></a>
                            </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="padding-left: 40%">No Records Found!... </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div style="margin-left: 80%" class="mt-1">{{ $visitors->links() }}
                </div>

            </div>
        </div>

    </div>
</div>
</div>
<style>
    .option {
        color: #0c0c0c;
    }

    .dropdown {
        display: inline-block;
        position: relative;
    }

    .dropdown-toggle {
        cursor: pointer;
        color: darkgray;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        display: none;
        background-color: #fff;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-menu a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-menu a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    th,
    td {
        text-align: left;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }
</style>
</div>

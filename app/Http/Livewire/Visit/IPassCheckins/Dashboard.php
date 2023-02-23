<?php

namespace App\Http\Livewire\Visit\IPassCheckins;

use App\Models\Visitor;
use App\Models\VisitorType;
use App\Models\WalkIn;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $perPage = 10;
    public $sortField = 'id';
    public $sortAsc = true;
    public ?string $search = null;
    public $visitorTypeId;
    public $sortTimeField='entry_time';
    public $sortTimeAsc = true;
    public $timeFilter = 'all';
    protected $visitors;

    public function sortBy($field)
    {
        if ($field === $this->sortField) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortField = $field;
            $this->sortAsc = true;
        }
    }
    public function sortByTime($field)
    {
        if ($field === $this->sortTimeField) {
            $this->sortTimeAsc = !$this->sortTimeAsc;
        } else {
            $this->sortTimeField = $field;
            $this->sortTimeAsc = true;
        }
    }
    public function applyTimeFilter()
    {
        $this->resetPage();
        $searchTerm = '%' . $this->search . '%';
        $this->visitors = WalkIn::with('organization', 'timeLogs','Resident.unit.block.premise.organization')
            ->when($this->visitorTypeId, function ($query) {
                $query->where('visitor_type_id', $this->visitorTypeId);
            })
            ->where('type', 'iPass')
            ->when($this->timeFilter != 'all', function ($query) {
                $query->whereHas('timeLogs', function ($subQuery) {
                    if ($this->timeFilter == 'daily') {
                        $subQuery->whereDate('entry_time', Carbon::now()->toDateString());
                    } else if ($this->timeFilter == 'weekly') {
                        $subQuery->whereBetween('entry_time', [
                            Carbon::now()->startOfWeek()->toDateTimeString(),
                            Carbon::now()->endOfWeek()->toDateTimeString(),
                        ]);
                    } else if ($this->timeFilter == 'monthly') {
                        $subQuery->whereYear('entry_time', Carbon::now()->year)
                            ->whereMonth('entry_time', Carbon::now()->month);
                    }
                });
            })->whereLike(['name'], $searchTerm)->orWhereHas('Resident.unit.block.premise.organization', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })->orWhereHas('Resident.unit.block.premise', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })->orWhereHas('Resident.unit.block', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })->orWhereHas('Resident.unit', function ($query) use ($searchTerm) {
                $query->where('name', 'like', $searchTerm);
            })
            ->leftJoin('time_logs', 'visitors.time_log_id', '=', 'time_logs.id')
            ->orderBy('time_logs.entry_time', $this->sortTimeAsc ? 'asc' : 'desc')
            ->orderBy('visitors.id', $this->sortField === 'id' ? ($this->sortAsc ? 'asc' : 'desc') : '')
            ->paginate($this->perPage);
    }
    public function render()
    {
        $this->applyTimeFilter();
        $visitorTypes = VisitorType::all();
        foreach ($this->visitors as $visitor) {
            $entryTime = Carbon::parse($visitor->timeLogs->entry_time);
            $exitTime = Carbon::parse($visitor->timeLogs->exit_time);
            $duration = $entryTime->diff($exitTime);

            $visitor->duration = $duration->format('%H Hours %I Minutes %S Seconds');
        }
        return view('livewire.visit.i-pass-checkins.dashboard', [
            'visitors' => $this->visitors,
            'visitorTypes' => $visitorTypes,
        ]);
    }
}

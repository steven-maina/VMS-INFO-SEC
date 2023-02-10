<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Organization;
use App\Models\Premise;
use App\Models\Vehicle;
use App\Models\Nationality;
use App\Models\Tag;

class WalkIn extends Model
{
    use HasFactory;
    protected $table = 'visitors';
    protected $guarded = [];

    public function organization(): HasMany
    {
        return $this->hasMany(Organization::class, 'id', 'organizationId');
    }
    public function visitorType() {
        return $this->belongsTo(VisitorType::class);
    }
}

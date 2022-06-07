<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class ClassroomRegistrar extends Model
{
    use HasFactory, Searchable;

    protected $guarded = ['id'];

    public function toSearchableArray()
    {
        return [
            'name' => $this->name
        ];
    }
}

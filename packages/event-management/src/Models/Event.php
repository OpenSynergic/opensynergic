<?php

namespace OpenSynergic\EventManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenSynergic\EventManagement\Database\Factories\EventFactory;
use Spatie\Translatable\HasTranslations;

class Event extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];

    protected $casts = [
        'name' => 'array',
        'date' => 'date',
    ];

    protected $fillable = [
        'name',
        'date',
        'time',
        'type',
        'status'
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory<static>
     */
    protected static function newFactory()
    {
        return new EventFactory();
    }
}

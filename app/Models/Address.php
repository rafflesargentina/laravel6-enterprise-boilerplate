<?php

namespace App\Models;

use App\Models\Traits\AddressTrait;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use AddressTrait;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'coordinates',
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'addressable_id',
        'addressable_type',
        'country',
        'door_number',
        'featured',
        'floor_number',
        'lat',
        'lng',
        'locality',
        'state',
        'street_name',
        'street_number',
        'sublocality',
        'zip',
    ];

    /**
     * Get all of the owning addressable models.
     */
    public function addressable()
    {
        return $this->morphTo();
    }
}

<?php

namespace App\Models;

use App\Models\Traits\UserTrait;

use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasRolesAndPermissions, Notifiable, SoftDeletes, UserTrait;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'blocked',    
    'document_number',    
    'document_type_id',    
    'email',    
    'first_name',
        'last_name',
    'password',
    'validation_code',
        'slug',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'validation_code',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = 'avatar';

    /**
     * Get the user's address.
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    /**
     * Get all of the user's addresses.
     */
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get the user's avatar.
     */
    public function avatar()
    {
        return $this->morphOne(FeaturedPhoto::class, 'photoable')->withDefault();
    }

    /**
     * Get the user's company.
     */
    public function company()
    {
        return $this->morphOne(Company::class, 'companyable');
    }

    /**
     * Get 
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    /**
     * Get the user's contact.
     */
    public function contact()
    {
        return $this->morphOne(Contact::class, 'contactable');
    }

    /**
     * Get the user's contacts.
     */
    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    /**
     * Get the user's billing address.
     */
    public function billing_address()
    {
        return $this->morphOne(BillingAddress::class, 'addressable');
    }

    /**
     * Get the user's photos.
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description',
        'name',
        'slug',
    ];

    /**
     * Get the document type's featured photo.
     */
    public function featured_photo()
    {
        return $this->morphOne(FeaturedPhoto::class, 'photoable')->withDefault();
    }

    /**
     * Get all of the document type's photos.
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    /**
     * Get all of the document type's unfeatured photos.
     */
    public function unfeatured_photos()
    {
        return $this->morphMany(UnfeaturedPhoto::class, 'photoable');
    }

    /**
     * Get all of the users for the document type.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

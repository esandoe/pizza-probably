<?php

namespace App\Models;

use App\Classes\RecipeParsing;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Recipe extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'name';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'title', 'content'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the recipe's content as an html string.
     *
     * @return string
     */
    public function getHtmlAttribute(): string
    {
        return RecipeParsing::getHtml($this->content);
    }

    /**
     * Get the recipe's metadata as key/value pairs
     *
     * @return array
     */
    public function getMetadataAttribute(): array
    {
        return RecipeParsing::getMetadata($this->content);
    }
}

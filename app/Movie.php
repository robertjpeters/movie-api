<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Movie extends Model
{
    /**
     * @var array Available formats
     */
    public static $formats = ['VHS', 'DVD', 'Streaming'];

    /**
     * @var array Sortable fields
     */
    public static $sortable = ['title', 'format','length','year', 'rating'];

    public static $defaultSort = 'id';

    protected $fillable = ['id', 'title', 'format','length','year', 'rating'];

    /**
     * Returns the validation rules for this model
     *
     * @return array Validation rules
     */
    public static function rules()
    {
        return [
            'title' => 'required|string|min:1|max:50',
            'format' => ['required', Rule::in(Movie::$formats)],
            'length' => 'required|integer|min:1|max:499',
            'year' => 'required|integer|min:1801|max:2099',
            'rating' => 'nullable|integer|min:1|max:5'
        ];
    }
}

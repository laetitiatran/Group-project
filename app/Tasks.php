<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model {
    protected $table = 'tasks';

    protected $fillable = ['name', 'author', 'order', 'description'];

    // Disable the automatic timestamp add by lumen
    public $timestamps = false;

    // if you are using append const MODEL = "App\\Task"; in your controller
    public static $rules = [
        // Validation rules
    ];

    // Relationships

}

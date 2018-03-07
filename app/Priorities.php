<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Priorities extends Model {

    public $table = "priorities";
    
    protected $fillable = ['name', 'color'];

    // Disable the automatic timestamp add by lumen
    public $timestamps = false;

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}

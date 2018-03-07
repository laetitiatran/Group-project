<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model {

    protected $table = 'frequency';
    
    protected $fillable = ['name'];

    // Disable the automatic timestamp add by lumen
    public $timestamps = false;

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}

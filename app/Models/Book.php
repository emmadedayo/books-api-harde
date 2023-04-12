<?php
/*
* @author Adenagbe Emmanuel Adedayo
* @github https://github.com/emmadedayo
* @linkedIn https://www.linkedin.com/in/adenagbe-adedayo/
* @email emmadenagbe@gmail.com
* @project hardes
* @created Wed, Apr 2023
* @Time 2:35 pm
*/
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'isbn', 'authors', 'number_of_pages', 'country', 'publisher', 'release_date'
    ];

    protected $dates = ['deleted_at'];

    public static $searchableFields = [
        'name', 'isbn', 'country', 'publisher', 'release_date'
    ];

}

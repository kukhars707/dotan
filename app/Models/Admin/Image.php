<?php

namespace App\Models\Admin;

use App\CoreClasses\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Validator;

class Image extends Model
{
    use CrudTrait;

    /*
   |--------------------------------------------------------------------------
   | GLOBAL VARIABLES
   |--------------------------------------------------------------------------
   */

    protected $table = 'images';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'url', 'h1', 'name', 'meta_title',
        'meta_description', 'image', 'alt_image', 'description',
        'sort', 'active', 'user_id', 'image_category_id'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * getImage
     * @return string
     */
    public function getImage()
    {
        return '<img style="max-width: 150px" src="' . $this->image . '">';
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->active == BaseModel::ACTIVE ? 'Опубликовано' : 'Не опубликовано';
    }

    /**
     * @param array $array
     * @return $this
     */
    public function checkUrl(array $array)
    {
        $validator = Validator::make($array,
            [
                'url' => 'unique:articles,url|unique:images,url,' . $array['id'] . '|unique:manuals,url|unique:pages,url|unique:videos,url'
            ],
            [
                'url.unique' => 'Данная ссылка уже есть в базе выберите другую'
            ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getPageLink()
    {
        return url($this->url);
    }

    /**
     * @return string
     */
    public function getOpenButton()
    {
        return '<a class="btn btn-default btn-xs" href="' . $this->getPageLink() . '" target="_blank">' .
            '<i class="fa fa-eye"></i> Просмотреть</a>';
    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function whoAdd()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('App\Models\Admin\ImageCategory', 'id', 'image_category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

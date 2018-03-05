<?php

namespace App\Models\Admin;

use App\CoreClasses\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Validator;

class Video extends Model
{
    use CrudTrait;

    /*
   |--------------------------------------------------------------------------
   | GLOBAL VARIABLES
   |--------------------------------------------------------------------------
   */

    protected $table = 'videos';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'h1', 'name', 'meta_title',
        'meta_description', 'image', 'alt_image', 'code',
        'sort','url','video_category_id', 'description', 'active', 'user_id'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @param string $str
     * @return string
     */
    public function getUrlImage(string $str)
    {
        $str = stristr($str, 'youtube');
        $array = explode('"', $str);
        $needString = str_replace('youtube.com/embed/', '', $array[0]);

        return "http://img.youtube.com/vi/$needString/mqdefault.jpg";
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return '<img style="max-width: 300px" src="' . $this->image . '">';
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
                'url' => 'unique:articles,url|unique:images,url|unique:manuals,url|unique:pages,url|unique:videos,url,'.$array['id']
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

    public function getPageLink()
    {
        return url($this->url);
    }

    public function getOpenButton()
    {
        return '<a class="btn btn-default btn-xs" href="'.$this->getPageLink().'" target="_blank">'.
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

    public function category()
    {
        return $this->hasOne('App\Models\Admin\VideoCategory', 'id', 'video_category_id');
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

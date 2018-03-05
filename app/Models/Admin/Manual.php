<?php

namespace App\Models\Admin;

use App\CoreClasses\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Validator;

class Manual extends Model
{
    use CrudTrait;

     /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'manuals';
    //protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
     protected $fillable = [
         'url', 'h1', 'name', 'text', 'meta_title',
         'meta_description', 'image','alt_image', 'sort', 'active','user_id'
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
    public function getImage() {
        return '<img style="max-width: 150px" src="/uploads/'. $this->image . '">';
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
                'url' => 'unique:articles,url|unique:images,url|unique:manuals,url,'.$array['id'].'|unique:pages,url|unique:videos,url'
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
    public function whoAdd()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
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
    /**
     * @param $value
     */
    public function setImageAttribute($value)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "manuals";

        // if the image was erased
        if ($value==null) {
            // delete the image from disk
            \Storage::disk($disk)->delete($this->{$attribute_name});

            // set null in the database column
            $this->attributes[$attribute_name] = null;
        }

        // if a base64 was sent, store it in the db
        if (starts_with($value, 'data:image'))
        {
            // 0. Make the image
            $image = \Image::make($value);
            // 1. Generate a filename.
            $filename = md5($value.time()).'.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path.'/'.$filename, $image->stream());
            // 3. Save the path to the database
            $this->attributes[$attribute_name] = $destination_path.'/'.$filename;
        }
    }
}

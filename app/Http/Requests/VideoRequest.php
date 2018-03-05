<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VideoRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $urlRule = 'unique_all_tables';
        if(!is_null($this->id)){
            $urlRule = "unique:articles,url|unique:images,url|unique:manuals,url|unique:pages,url|unique:videos,url,$this->id";
        }

        $rules = [
            'name' => 'required',
            'code' => 'required',
            'url' => $urlRule
        ];

        if (!is_null($this->sort)){
            $rules['sort'] = 'integer';
        }

        return $rules;
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => 'Поле Код из ютуба обязательно для заполнения',
            'name.required' => 'Поле Имя для админки обязательно для заполнения',
            'sort.integer' => 'Поле Сортировка должно быть числом',
            'url.unique' => 'Данная ссылка уже есть в базе выберите другую',
            'url.unique_all_tables' => 'Данная ссылка уже есть в базе выберите другую'
        ];
    }
}

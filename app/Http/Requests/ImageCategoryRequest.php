<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Traits\AdminValidateTrait;

class ImageCategoryRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
{
    use AdminValidateTrait;

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

        if (!is_null($this->id)) {
//            $urlRule = $this->getRileForUniqueData($this->id, 'image_categories');
            $urlRule = 'unique:image_categories,url,1';
        }

        $rules = [
            'name' => 'required',
            'url' => $urlRule
        ];

        if (!is_null($this->sort)) {
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
            'url' => 'ссылка'
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
            'name.required' => 'Поле Имя для админки обязательно для заполнения',
            'sort.integer' => 'Поле Сортировка должно быть числом',
            'url.unique_all_tables' => 'Данная :attribute уже есть в базе выберите другую',
            'url.unique' => 'Данная :attribute уже есть в базе выберите другую',
        ];
    }
}

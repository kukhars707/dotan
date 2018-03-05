<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;

class ImageRequest extends CrudRequest
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
        $id = '';

        if (!is_null($this->id)) {
            $urlRule = "";
            $id = ",$this->id";
        }

        $rules = [
            'name' => 'required|unique:images,name' . $id,
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
            'name' => 'Имя для админки'
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
            'name.unique' => 'Данное :attribute уже занято',
            'sort.integer' => 'Поле Сортировка должно быть числом',
            'url.unique_all_tables' => 'Данная ссылка уже есть в базе выберите другую'
        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ArticleRequest extends \Backpack\CRUD\app\Http\Requests\CrudRequest
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
            $urlRule = "";
        }

        $rules = [
            'name' => 'required',
            'category_article_id' => 'required',
            'url' => $urlRule,
            'text' => 'required',
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
            'text.required' => 'Поле Текст статьи обязательно для заполнения',
            'name.required' => 'Поле Имя для админки обязательно для заполнения',
            'category_article_id.required' => 'Поле Категория обязательно для выбора',
            'sort.integer' => 'Поле Сортировка должно быть числом',
            'url.unique_all_tables' => 'Данная ссылка уже есть в базе выберите другую'
        ];
    }
}


<?php

namespace App\Http\Controllers\Admin;

use App\CoreClasses\Models\BaseModel;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ManualRequest as StoreRequest;
use App\Http\Requests\ManualRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;

class ManualCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\Manual');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/manuals');
        $this->crud->setEntityNameStrings('гайд', 'Гайды');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        $this->crud->addFields([
            [
                'name' => 'url',
                'label' => 'Ссылка',
                'tab' => 'Главное'
            ],
            [
                'name' => 'h1',
                'hint' => 'Если оставите пустым примет значения поля Имя для админки',
                'tab' => 'Главное'
            ],
            [
                'name' => 'name',
                'label' => 'Имя для админки *',
                'hint' => 'Обязательное поле',
                'tab' => 'Главное'
            ],
            [
                'name' => 'text',
                'label' => 'Текст статьи',
                'type' => 'ckeditor',
                'extra_plugins' => ['oembed', 'widget', 'justify'],
                'tab' => 'Главное'
            ],
            [
                'name' => 'image',
                'label' => 'Превью изображение',
                'type' => 'image',
                'upload' => true,
                'crop' => true,
                'tab' => 'Главное'
            ],
            [
                'name' => 'alt_image',
                'label' => 'Alt для превью',
                'tab' => 'Главное'
            ],
            [
                'name' => 'sort',
                'label' => 'Сортировка',
                'tab' => 'Главное'
            ],
            [
                'name' => 'active',
                'label' => 'Публикация',
                'type' => 'radio',
                'options' => [
                    0 => 'Не опубликовано',
                    1 => 'Опубликовано',
                ],
                'tab' => 'Главное'
            ],
            [
                'name' => 'meta_title',
                'label' => 'Мета тайтл',
                'hint' => 'Если оставите пустым примет значения поля Имя для админки',
                'tab' => 'SEO'
            ],
            [
                'name' => 'meta_description',
                'label' => 'Мета дескрипшн',
                'type' => 'textarea',
                'tab' => 'SEO'
            ],
        ], 'update/create/both');


         $this->crud->removeField('user_id', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack

        $this->crud->removeColumns(['h1', 'text','alt_image', 'meta_title', 'meta_description', 'text']); // remove an array of columns from the stack
        $this->crud->setColumnDetails('url', ['label' => 'Ссылка']); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('name', ['label' => 'Имя для администратора']); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('user_id', [
            'label' => 'Кто добавил',
            'type' => "select",
            'name' => 'parent_id', // the column that contains the ID of that connected entity;
            'entity' => 'whoAdd', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\User", // foreign key model
        ]); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('image', [
            'label' => 'Превью',
            'type' => 'model_function',
            'function_name' => 'getImage'
        ]); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('sort', ['label' => 'Сортировка']); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('active', ['label' => 'Публикация',
            'type' => 'model_function',
            'function_name' => 'getStatus'
        ]);
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']); // adjusts the properties of the passed in column (by name)
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
        $this->crud->addButtonFromModelFunction('line', 'open', 'getOpenButton', 'beginning');
        // possible positions: 'beginning' and 'end'; defaults to 'beginning' for the 'line' stack, 'end' for the others;
        // $this->crud->addButton($stack, $name, $type, $content, $position); // add a button; possible types are: view, model_function
        // $this->crud->addButtonFromModelFunction($stack, $name, $model_function_name, $position); // add a button whose HTML is returned by a method in the CRUD model
        // $this->crud->addButtonFromView($stack, $name, $view, $position); // add a button whose HTML is in a view placed at resources\views\vendor\backpack\crud\buttons
        // $this->crud->removeButton($name);
        // $this->crud->removeButtonFromStack($name, $stack);
        // $this->crud->removeAllButtons();
        // $this->crud->removeAllButtonsFromStack('line');

        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ REVISIONS
        // You also need to use \Venturecraft\Revisionable\RevisionableTrait;
        // Please check out: https://laravel-backpack.readme.io/docs/crud#revisions
        // $this->crud->allowAccess('revisions');

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though:
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable();

        // ------ DATATABLE EXPORT BUTTONS
        // Show export to PDF, CSV, XLS and Print buttons on the table view.
        // Does not work well with AJAX datatables.
        // $this->crud->enableExportButtons();

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->addClause('withoutGlobalScopes');
        // $this->crud->addClause('withoutGlobalScope', VisibleScope::class);
        // $this->crud->with(); // eager load relationships
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function store(StoreRequest $request)
    {
        $request->merge(['url' => is_null($request->url) ? \Slug::make($request->name) : \Slug::make($request->url)]);

        BaseModel::checkUrl($request->all());

        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['meta_title' => is_null($request->meta_title) ? $request->name : $request->meta_title]);
        $request->merge(['h1' => is_null($request->h1) ? $request->name : $request->h1]);
        $request->merge(['alt_image' => is_null($request->alt_image) ? $request->name : $request->alt_image]);

        $redirect_location = parent::storeCrud($request);

        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        $request->merge(['url' => is_null($request->url) ? \Slug::make($request->name) : \Slug::make($request->url)]);
        $this->crud->getModel()->checkUrl($request->all());
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['meta_title' => is_null($request->meta_title) ? $request->name : $request->meta_title]);
        $request->merge(['h1' => is_null($request->h1) ? $request->name : $request->h1]);
        $request->merge(['alt_image' => is_null($request->alt_image) ? $request->name : $request->alt_image]);

        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

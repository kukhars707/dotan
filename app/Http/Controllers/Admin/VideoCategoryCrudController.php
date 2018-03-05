<?php

namespace App\Http\Controllers\Admin;

use App\CoreClasses\Models\BaseModel;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VideoCategoryRequest as StoreRequest;
use App\Http\Requests\VideoCategoryRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoCategoryCrudController extends CrudController
{
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\VideoCategory');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/video-category');
        $this->crud->setEntityNameStrings('видео категорию', 'Видео категории');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
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
            ]
        ], 'update/create/both');


         $this->crud->addField(
             [
                 'name' => 'description',
                 'type' => 'textarea',
                 'label' => 'Описание',
                 'tab' => 'Главное'
             ], 'update/create/both')->beforeField('active');
         $this->crud->addField(
             [
                 'label' => "Родительская категория",
                 'type' => 'select',
                 'name' => 'parent_id', // the db column for the foreign key
                 'entity' => 'category', // the method that defines the relationship in your Model
                 'attribute' => 'name', // foreign key attribute that is shown to user
                 'model' => "App\Models\Admin\VideoCategory", // foreign key model
                 'tab' => 'Главное'
             ], 'update/create/both')->beforeField('active');

         $this->crud->removeField('user_id', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
         $this->crud->removeColumns(['h1', 'meta_title', 'meta_description', 'meta_title', 'description']);
         $this->crud->setColumnDetails('url', [
             'label' => 'Ссылка'
         ]);
         $this->crud->setColumnDetails('name', [
             'label' => 'Имя для администратора'
         ]);
         $this->crud->setColumnDetails('sort', [
             'label' => 'Сортировка'
         ]);
         $this->crud->setColumnDetails('user_id', [
             'label' => 'Кто добавил',
             'type' => "select",
             'entity' => 'whoAdd',
             'attribute' => "name",
             'model' => "App\User",
         ]);
         $this->crud->setColumnDetails('active', [
             'label' => 'Публикация',
             'type' => 'active'
         ]);
         $this->crud->setColumnDetails('parent_id', [
             'label' => 'Родитель',
             'type' => "select",
             'entity' => 'parent', // the method that defines the relationship in your Model
             'attribute' => "name", // foreign key attribute that is shown to user
             'model' => "App\Models\Admin\VideoCategory", // foreign key model
         ]);
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);

        // ------ CRUD BUTTONS
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

        $validator = Validator::make($request->all(),
            [
                'url' => 'unique_all_tables'
            ],
            [
                'url.unique_all_tables' => 'Данная ссылка уже есть в базе выберите другую'
            ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $request->merge(['h1' => is_null($request->h1) ? $request->name : $request->h1]);
        $request->merge(['meta_title' => is_null($request->meta_title) ? $request->name : $request->meta_title]);
        $request->merge(['user_id' => Auth::id()]);

        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

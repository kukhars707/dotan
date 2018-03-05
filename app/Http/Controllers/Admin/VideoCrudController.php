<?php

namespace App\Http\Controllers\Admin;

use App\CoreClasses\Models\BaseAdminModel;
use App\CoreClasses\Models\BaseModel;
use App\Models\Admin\Video;
use App\Models\Admin\VideoHasVideoCategory;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\VideoRequest as StoreRequest;
use App\Http\Requests\VideoRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoCrudController extends CrudController
{
    /**
     *
     */
    public function setup()
    {

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\Video');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/videos');
        $this->crud->setEntityNameStrings('видео', 'Видео');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        // ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');

        $this->crud->addField(
            [
                'label' => 'Список статей',
                'type' => 'checklist_create',
                'name' => 'video_has_video_caterogy',
                'attribute' => 'name',
                'model' => "App\Models\Admin\VideoCategory",
                'pivot' => true,
                'tab' => 'Категории'
            ], 'create');


        $this->crud->addField(
            [
                'label' => 'Список статей',
                'type' => 'checklist_update',
                'name' => 'video_has_video_caterogy',
                'attribute' => 'name',
                'model' => "App\Models\Admin\VideoCategory",
                'pivot' => true,
                'tab' => 'Категории'
            ], 'update');

        $this->crud->addField(
            [
                'name' => 'description',
                'label' => 'Описание изображения',
                'type' => 'textarea',
                'tab' => 'Главное'
            ], 'update/create/both')->afterField('alt_image');
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
                'name' => 'code',
                'label' => 'Код из ютуба',
                'type' => 'textarea',
                'tab' => 'Главное'
            ],
            [
                'name' => 'alt_image',
                'label' => 'Alt превью',
                'hint' => 'Если оставите пустым примет значения поля Имя для админки',
                'tab' => 'Главное'
            ],
            [
                'name' => 'sort',
                'label' => 'Сортировка',
                'tab' => 'Главное'
            ],
            [
                'name' => 'video_category_id',
                'label' => 'Категория',
                'type' => 'select2_custom',
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'allows_null' => true,
                'model' => "App\Models\Admin\VideoCategory", // foreign key model
                'pivot' => true,
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
        $this->crud->removeFields(['image', 'user_id'], 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        $this->crud->addColumn([
            'name' => 'url',
            'label' => 'Ссылка'
        ]);
        $this->crud->addColumn([
            'label' => 'Категория',
            'name' => 'video_category_id',
            'type' => "select",
            'entity' => 'category', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\Models\Admin\VideoCategory", // foreign key model
        ]);
        $this->crud->setColumnDetails('name', ['label' => 'Имя для администратора']); // adjusts the properties of the passed in column (by name)
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
        $this->crud->setColumnDetails('user_id', [
            'label' => 'Кто добавил',
            'type' => "select",
            'name' => 'parent_id', // the column that contains the ID of that connected entity;
            'entity' => 'whoAdd', // the method that defines the relationship in your Model
            'attribute' => "name", // foreign key attribute that is shown to user
            'model' => "App\User", // foreign key model
        ]);
        $this->crud->removeColumns(['h1', 'text', 'meta_title', 'description', 'alt_image', 'meta_description', 'code']); // remove an array of columns from the stack

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
        $this->crud->orderBy('sort', 'desc');
        // $this->crud->groupBy();
        // $this->crud->limit();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        // get the info for that entry
        $entry = $this->crud->getEntry($id);
        $this->data['entry'] = $entry;
        $this->data['parent_id'] = $entry->video_category_id;
        $this->data['parent_category'] = $this->crud->getEntry($id);
        $this->data['relationsModels'] = VideoHasVideoCategory::getRelationsModel($id,'video_id','video_category_id');
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit') . ' ' . $this->crud->entity_name;

        $this->data['id'] = $id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }


    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $request->merge(['url' => is_null($request->url) ? \Slug::make($request->name) : \Slug::make($request->url)]);
//        BaseModel::checkUrl($request->all());

        $request->merge(['h1' => is_null($request->h1) ? $request->name : $request->h1]);
        $request->merge(['meta_title' => is_null($request->meta_title) ? $request->name : $request->meta_title]);
        $request->merge(['image' => $this->crud->getModel()->getUrlImage($request->code)]);
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['alt_image' => is_null($request->alt_image) ? $request->name : $request->alt_image]);

        $item = Video::create($request->except(['video_has_video_caterogy', 'save_action', '_token', '_method']));

        if ($request->has('video_has_video_caterogy')) {
            $array = request('video_category_id');
            if(request()->has('video_category_id')){
                $array = array_where($request->video_has_video_caterogy, function ($value, $key) {
                    return request('video_category_id') != $value;
                });
            }
            VideoHasVideoCategory::storeInsert([
                'parent_key' => 'video_id',
                'second_key' => 'video_category_id',
                'key' => $item->getKey()
            ], $array);
        }

        \Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    /**
     * @param UpdateRequest $request
     * @return mixed
     */
    public function update(UpdateRequest $request)
    {
        $request->merge(['url' => is_null($request->url) ? \Slug::make($request->name) : \Slug::make($request->url)]);
        $request->merge(['h1' => is_null($request->h1) ? $request->name : $request->h1]);
        $request->merge(['meta_title' => is_null($request->meta_title) ? $request->name : $request->meta_title]);
        $request->merge(['image' => $this->crud->getModel()->getUrlImage($request->code)]);
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['alt_image' => is_null($request->alt_image) ? $request->name : $request->alt_image]);

        $arrayUpdate =  $request->except('save_action', '_token', '_method','video_has_video_caterogy');

        $this->crud->getModel()->where('id', $request->id)->update($arrayUpdate);

        VideoHasVideoCategory::removeByFieldAndValue('video_id', $request->id);

        if ($request->has('video_has_video_caterogy')) {
            $array = request('video_category_id');
            if(request()->has('video_category_id')){
                $array = array_where($request->video_has_video_caterogy, function ($value, $key) {
                    return request('video_category_id') != $value;
                });
            }
            VideoHasVideoCategory::storeInsert([
                'parent_key' => 'video_id',
                'second_key' => 'video_category_id',
                'key' => $request->id
            ], $array);
        }
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry

        \Alert::success(trans('backpack::crud.update_success'))->flash();

        $this->setSaveAction();

        return $this->performSaveAction($request->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return string
     */
    public function destroy($id)
    {
        $this->crud->hasAccessOrFail('delete');

        if (VideoHasVideoCategory::getExistsModel('video_id', $id)) {
            VideoHasVideoCategory::removeByFieldAndValue('video_id', $id);
        }

        return $this->crud->delete($id);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Article;
use App\Models\Admin\ArticleHasArticleCategory;
use App\Models\Admin\ArticleHasArticles;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\ArticleRequest as StoreRequest;
use App\Http\Requests\ArticleRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\CoreClasses\Models\BaseModel;

class ArticleCrudController extends CrudController
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
        $this->crud->setModel('App\Models\Admin\Article');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/article');
        $this->crud->setEntityNameStrings('статью', 'Статьи');

        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */

        $this->crud->setFromDb();

        // ------ CRUD FIELDS

        $this->crud->addField(
            [
                'label' => 'Категории',
                'type' => 'checklist_create',
                'name' => 'article_has_article_caterogy',
                'attribute' => 'name',
                'model' => "App\Models\Admin\ArticleCategory",
                'pivot' => true,
                'tab' => 'Категории'
            ], 'create');


        $this->crud->addField(
            [
                'label' => 'Категории',
                'type' => 'checklist_update',
                'name' => 'article_has_article_caterogy',
                'attribute' => 'name',
                'model' => "App\Models\Admin\ArticleCategory",
                'pivot' => true,
                'tab' => 'Категории'
            ], 'update');






        $this->crud->addField(
            [
                'label' => 'Список статей',
                'type' => 'checklist_create',
                'name' => 'article_has_articles',
                'attribute' => 'name',
                'model' => "App\Models\Admin\Article",
                'pivot' => true,
                'tab' => 'Прикрепить статью'
            ], 'create');
        $this->crud->addField(
            [
                'label' => 'Список статей',
                'type' => 'checklist_update',
                'name' => 'article_has_articles',
                'attribute' => 'name',
                'model' => "App\Models\Admin\Article",
                'pivot' => true,
                'tab' => 'Прикрепить статью'
            ], 'update');
        $this->crud->addField(
            [
                'name' => 'alt_image',
                'label' => 'Alt изображение',
                'hint' => 'Если оставить незаполненым возьмет Имя для админки',
                'tab' => 'Главное'
            ], 'update/create/both')->afterField('image');


        $this->crud->addField(
            [
                'name' => 'category_article_id',
                'label' => 'Категория',
                'type' => 'select2_custom',
                'entity' => 'category', // the method that defines the relationship in your Model
                'attribute' => 'name', // foreign key attribute that is shown to user
                'allows_null' => true,
                'model' => "App\Models\Admin\ArticleCategory", // foreign key model
                'pivot' => true,
                'tab' => 'Главное'
            ], 'update/create/both')->afterField('url');
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
        $this->crud->removeField('user_id', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        $this->crud->removeColumns(['h1', 'text', 'meta_title', 'meta_description', 'text', 'alt_image']); // remove an array of columns from the stack
        $this->crud->setColumnDetails('url', ['label' => 'Ссылка']); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('name', ['label' => 'Имя для администратора']); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('user_id', [
            'label' => 'Кто добавил',
            'type' => "select",
            'name' => 'parent_id',
            'entity' => 'whoAdd',
            'attribute' => "name",
            'model' => "App\User",
        ]);
        $this->crud->setColumnDetails('category_article_id', [
            'label' => 'Категория',
            'type' => "select",
            'entity' => 'category',
            'attribute' => "name",
            'model' => "App\Models\Admin\ArticleCategory",
        ]);
        $this->crud->setColumnDetails('image', [
            'label' => 'Превью',
            'type' => 'model_function',
            'function_name' => 'getImage'
        ]); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('sort', ['label' => 'Сортировка']); // adjusts the properties of the passed in column (by name)
        $this->crud->setColumnDetails('active', [
            'label' => 'Публикация',
            'type' => 'model_function',
            'function_name' => 'getStatus'
        ]);
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
        $this->crud->orderBy('active', 'desc');
        $this->crud->orderBy('sort', 'desc');
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    /**
     * Show the form for creating inserting a new row.
     *
     * @return Response
     */
    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add') . ' ' . $this->crud->entity_name;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getCreateView(), $this->data);
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
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['articleHasArticles'] = ArticleHasArticles::getArticleByParentId($id);
        $this->data['relationsModels'] = ArticleHasArticleCategory::getRelationsModel($id, 'article_id', 'article_category_id');
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit') . ' ' . $this->crud->entity_name;

        $this->data['id'] = $id;
        $this->data['parent_id'] = $this->crud->getEntry($id)->category_article_id;

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view($this->crud->getEditView(), $this->data);
    }


    /**
     * @param UpdateRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request)
    {
        $this->crud->hasAccessOrFail('create');

        $request->merge(['url' => is_null($request->url) ? \Slug::make($request->name) : \Slug::make($request->url)]);
        BaseModel::checkUrl($request->all());

        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['meta_title' => is_null($request->meta_title) ? $request->name : $request->meta_title]);
        $request->merge(['h1' => is_null($request->h1) ? $request->name : $request->h1]);
        $request->merge(['alt_image' => is_null($request->alt_image) ? $request->name : $request->alt_image]);

        $item = Article::create($request->except(['article_has_articles', 'save_action', '_token', '_method']));

        if ($request->has('article_has_articles')) {
            ArticleHasArticles::storeInsert([
                'parent_key' => 'parent_article_id',
                'second_key' => 'article_id',
                'key' => $item->getKey()
            ], $request->article_has_articles);
        }

        \Alert::success(trans('backpack::crud.insert_success'))->flash();
        $this->setSaveAction();

        return $this->performSaveAction($item->getKey());
    }

    /**
     * @param UpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request)
    {
        $attribute_name = "image";
        $disk = "uploads";
        $destination_path = "articles";

//        // if the image was erased
//        if ($value == null || $value == 'http://dotan.ru') {
//            // delete the image from disk
//            \Storage::disk($disk)->delete($this->{$attribute_name});
//
//            // set null in the database column
//            $this->attributes[$attribute_name] = null;
//        }

        $request->merge(['image' => $request->image]);
        // if a base64 was sent, store it in the db
        if (starts_with($request->image, 'data:image')) {
            // 0. Make the image
            $image = \Image::make($request->image);
            // 1. Generate a filename.
            $filename = md5($request->image . time()) . '.jpg';
            // 2. Store the image on disk.
            \Storage::disk($disk)->put($destination_path . '/' . $filename, $image->stream());
            // 3. Save the path to the database
            $request->merge(['image' => "/uploads/$destination_path/$filename"]);
        }
        $request->merge(['url' => is_null($request->url) ? \Slug::make($request->name) : \Slug::make($request->url)]);

        $this->crud->getModel()->checkUrl($request->all());
        $request->merge(['user_id' => Auth::id()]);
        $request->merge(['meta_title' => is_null($request->meta_title) ? $request->name : $request->meta_title]);
        $request->merge(['h1' => is_null($request->h1) ? $request->name : $request->h1]);
        $request->merge(['alt_image' => is_null($request->alt_image) ? $request->name : $request->alt_image]);

        $this->crud->model->where('id', $request->id)
            ->update($request->except('article_has_articles', 'article_has_article_caterogy', 'save_action', '_token', '_method'));
        \Alert::success(trans('backpack::crud.update_success'))->flash();
        $this->setSaveAction();
        ArticleHasArticles::removeRecords('parent_article_id', $request->id);

        if ($request->has('article_has_articles')) {
            ArticleHasArticles::storeInsert([
                'parent_key' => 'parent_article_id',
                'second_key' => 'article_id',
                'key' => $request->id
            ], $request->article_has_articles);
        }

        if ($request->has('category_article_id')) {
            if (request()->has('article_has_article_caterogy')) {
                $array = array_where($request->article_has_article_caterogy, function ($value, $key) {
                    return request('category_article_id') != $value;
                });
            }
        }
        $array[] = request('category_article_id');
        ArticleHasArticleCategory::removeByFieldAndValue('article_id',$request->id);
        ArticleHasArticleCategory::storeInsert([
            'parent_key' => 'article_id',
            'second_key' => 'article_category_id',
            'key' => $request->id
        ], $array);

        return $this->performSaveAction($request->id);
    }
}

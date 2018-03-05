<?php

namespace App\Http\Controllers\Admin;

use App\CoreClasses\Models\BaseModel;
use App\PageTemplates;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\PageRequest as StoreRequest;
use App\Http\Requests\PageRequest as UpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PageCrudController extends CrudController
{
    use PageTemplates;

    public function __construct($template_name = false)
    {
        parent::__construct();
        /*
        |--------------------------------------------------------------------------
        | BASIC CRUD INFORMATION
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Admin\Page');
        $this->crud->setRoute(config('backpack.base.route_prefix').'/page');
        $this->crud->setEntityNameStrings('Страницу','Страницы');

        /*
        |--------------------------------------------------------------------------
        | COLUMNS
        |--------------------------------------------------------------------------
        */

        $this->crud->addColumn([
                                'name' => 'name',
                                'label' => 'Название страницы',
                                ]);
        $this->crud->addColumn([
                                'name' => 'template',
                                'label' => 'Шаблон',
                                'type' => 'model_function',
                                'function_name' => 'getTemplateName',
                                ]);
        $this->crud->addColumn([
                                'name' => 'slug',
                                'label' => 'Ссылка',
                                ]);

        /*
        |--------------------------------------------------------------------------
        | FIELDS
        |--------------------------------------------------------------------------
        */

        // In PageManager,
        // - default fields, that all templates are using, are set using $this->addDefaultPageFields();
        // - template-specific fields are set per-template, in the PageTemplates trait;

        /*
        |--------------------------------------------------------------------------
        | BUTTONS
        |--------------------------------------------------------------------------
        */
        $this->crud->addButtonFromModelFunction('line', 'open', 'getOpenButton', 'beginning');
    }

    // -----------------------------------------------
    // Overwrites of CrudController
    // -----------------------------------------------

    // Overwrites the CrudController create() method to add template usage.
    public function create($template = false)
    {
        $this->addDefaultPageFields($template);
        $this->useTemplate($template);

//        dd($template);
        return parent::create();
    }

    // Overwrites the CrudController store() method to add template usage.
    public function store(StoreRequest $request)
    {
        $this->addDefaultPageFields(\Request::input('template'));
        $this->useTemplate(\Request::input('template'));


        if (is_null($request->url)) {
            $request->merge(['url' => \Slug::make($request->name)]);
        } else {
            $request->merge(['url' => \Slug::make($request->url)]);
        }

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

        if (is_null($request->h1)) {
            $request->merge(['h1' => $request->name]);
        }
        if (is_null($request->meta_title)) {
            $request->merge(['meta_title' => $request->name]);
        }
        $request->merge(['user_id' => Auth::id()]);

        return parent::storeCrud($request);
    }

    // Overwrites the CrudController edit() method to add template usage.
    public function edit($id, $template = false)
    {
        // if the template in the GET parameter is missing, figure it out from the db
        if ($template == false) {
            $model = $this->crud->model;
            $this->data['entry'] = $model::findOrFail($id);
            $template = $this->data['entry']->template;
        }

        $this->addDefaultPageFields($template);
        $this->useTemplate($template);

        return parent::edit($id);
    }

    // Overwrites the CrudController update() method to add template usage.
    public function update(UpdateRequest $request)
    {
        $this->addDefaultPageFields(\Request::input('template'));
        $this->useTemplate(\Request::input('template'));

        return parent::updateCrud();
    }

    // -----------------------------------------------
    // Methods that are particular to the PageManager.
    // -----------------------------------------------

    /**
     * Populate the create/update forms with basic fields, that all pages need.
     *
     * @param string $template The name of the template that should be used in the current form.
     */
    public function addDefaultPageFields($template = false)
    {
        $this->crud->addField([
                                'name' => 'template',
                                'label' => 'Шаблон',
                                'type' => 'select_page_template',
                                'options' => $this->getTemplatesArray(),
                                'value' => $template,
                                'allows_null' => false,
                                'wrapperAttributes' => [
                                    'class' => 'form-group col-md-6',
                                ],
                            ]);
        $this->crud->addField([
                                'name' => 'name',
                                'label' => 'Имя для админки',
                                'type' => 'text',
                                'wrapperAttributes' => [
                                    'class' => 'form-group col-md-6',
                                ],
                                // 'disabled' => 'disabled'
                            ]);
        $this->crud->addField([
                                'name' => 'h1',
                                'label' => 'H1',
                                'type' => 'text',
                                // 'disabled' => 'disabled'
                            ]);
        $this->crud->addField([
                                'name' => 'url',
                                'label' => 'Ссылка',
                                'type' => 'text',
                                // 'disabled' => 'disabled'
                            ]);
    }

    /**
     * Add the fields defined for a specific template.
     *
     * @param  string $template_name The name of the template that should be used in the current form.
     */
    public function useTemplate($template_name = false)
    {
        $templates = $this->getTemplates();

        // set the default template
        if ($template_name == false) {
            $template_name = $templates[0]->name;
        }

        // actually use the template
        if ($template_name) {
            $this->{$template_name}();
        }
    }

    /**
     * Get all defined templates.
     */
    public function getTemplates($template_name = false)
    {
        $templates_array = [];

        $templates_trait = new \ReflectionClass('App\PageTemplates');
        $templates = $templates_trait->getMethods(\ReflectionMethod::IS_PRIVATE);

        if (! count($templates)) {
            abort(503, trans('backpack::pagemanager.template_not_found'));
        }

        return $templates;
    }

    /**
     * Get all defined template as an array.
     *
     * Used to populate the template dropdown in the create/update forms.
     */
    public function getTemplatesArray()
    {
        $templates = $this->getTemplates();

        foreach ($templates as $template) {
            $templates_array[$template->name] = $this->crud->makeLabel($template->name);
        }

        return $templates_array;
    }
}

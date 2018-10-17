<?php

namespace App\Http\Controllers\CRUD;

use App\Form\NameForm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\Form;
use Kris\LaravelFormBuilder\FormBuilder;

class CRUDBase extends Controller
{
    protected $name;
    protected $formClass = NameForm::class;
    protected $oneToManyRelationships = [];
    protected $manyToManyRelationships = [];
    protected $modelClass;
    protected $view = "crud.form.generic";
    protected $fields = ["name"];


    public function __construct()
    {
        $this->name = str_replace("Controller","",substr(strrchr(get_class($this), "\\"), 1));
    }

    public function get(FormBuilder $formBuilder)
    {
        $id = request()->id;
        $modal = is_null($id) ? new $this->modelClass() : $this->modelClass::findOrFail($id);

        $form = $formBuilder->create($this->formClass, [
            'method' => 'POST',
            'model' => $modal,
            'url' => route('admin.get.post',["model"])
        ]);

        $form = $form->add(is_null($id) ? "Create" : "Update", "submit", ["attr" => ["class" => "btn btn-primary btn-block"]]);
        return view($this->view, ["form" => $form, "title" => is_null($id) ? "Create " : "Update ". $this->name]);
    }


    public function saveModel(Form $form)
    {
        $id = request()->id;
        $model = is_null($id) ? new $this->modelClass() : $this->modelClass::findOrFail($id);
        $model->fill($form->getFieldValues());
        $model->save();
        foreach ($this->manyToManyRelationships as $manyRelationship) {
            $model->$manyRelationship()->detach();
            if (isset($form->getFieldValues()[$manyRelationship])) {
                $model->$manyRelationship()->attach(($form->getFieldValues()[$manyRelationship]));
            }
        }
        return $model;
    }

    public function store(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create($this->formClass);
        if (!$form->isValid()) {
            return redirect()->back()->withErrors($form->getErrors())->withInput();
        }

        $this->saveModel($form);
        return route("auth.$this->name.list");
    }


    public function list(Request $request)
    {
        $search = $request->search;

        $filter = $request->filter;

        if (is_null($search))
            $data = $this->modelClass::query();
        else
            $data = $this->modelClass::where("name", "like", "%$search%");

        if(isset($filter)){
            foreach ($filter as $relation=> $values){
                $data->where(function ($query) use ($relation, $values){
                    if(isset($values["data"])){
                foreach ($values["data"] as $value) {
                    $query = $query->orWhereHas($relation, function ($query) use ($relation, $value) {
                        $query->where(str_plural(snake_case($relation)) . ".id", "=", $value);
                    });
                }
                }
                if(isset($values["null"]))
                    $query->doesntHave($relation, 'or');
                });
            }
        }

        $multiSelect = collect($this->oneToManyRelationships)->mapWithKeys(function ($item) {
            return [$item => filterByLocationQuery(("\App\\".ucfirst($item))::query())->get()];
        });

        $singleSelect = collect($this->manyToManyRelationships)->mapWithKeys(function ($item) {
            return [$item => filterByLocationQuery(("\App\\".ucfirst($item))::query())->get()];
        });


        $data = $data->paginate(15)->appends(['search' => $search,'filter'=>$filter]);
        return view("crud.list.generic", [
            "multiSelect" => $multiSelect,
            "singleSelect" => $singleSelect,
            "data" => $data,
            "search" => $search,
            "name" => $this->name,
            "fields" => $this->fields]);
    }

    public function delete(Request $request)
    {
        $model = $this->modelClass::findOrFail($request->id);
        $model->delete();
        return redirect()->back();
    }
}
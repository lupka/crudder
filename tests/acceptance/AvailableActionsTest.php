<?php

use Lupka\Crudder\CrudderModel;

class AvailableActionsTest extends CrudderTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);

        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->model = $crudderModel->dispenseModel();
        $this->model->fill(['name' => 'MODEL_NAME']);
        $this->model->save();

        $this->model2 = $crudderModel->dispenseModel();
        $this->model2->fill(['name' => 'MODEL_NAME']);
        $this->model2->save();
    }

    /** @test */
    public function create_action_only_available_if_in_config()
    {
        // has 'create' in config
        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['create','update','delete']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->createUrl());
        $this->see('Add Model A');

        // no 'create' in config
        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['update','delete']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->createUrl());
        $this->dontSee('Add Model A');

        $this->call('POST', $crudderModel->createUrl());
        $this->assertRedirectedTo($crudderModel->indexUrl());
    }

    /** @test */
    public function update_action_only_available_if_in_config()
    {
        // has 'create' in config
        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['create','update','delete']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->editUrl($this->model));
        $this->see('Edit Model A');

        // no 'create' in config
        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['create','delete']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->editUrl($this->model));
        $this->dontSee('Edit Model A');

        $this->call('POST', $crudderModel->editUrl($this->model));
        $this->assertRedirectedTo($crudderModel->indexUrl());
    }

    /** @test */
    public function delete_action_only_available_if_in_config()
    {
        // has 'create' in config
        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['create','update','delete']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->deleteUrl($this->model));
        $this->see('Model A deleted.');

        // no 'create' in config
        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['create','update']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->deleteUrl($this->model2));
        $this->dontSee('Model A deleted.');
    }

    /** @test */
    public function correct_model_action_links_are_shown()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['create','update','delete']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->indexUrl());
        $this->see('Edit');
        $this->see('Delete');

        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['create']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->indexUrl());
        $this->dontSee('Edit');
        $this->dontSee('Delete');

        app('config')->set('crudder.models', ['Models\ModelA' => ['available_actions' => ['view']]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->visit($crudderModel->indexUrl());
        $this->see('View');
        $this->dontSee('Edit');
        $this->dontSee('Delete');
    }

}

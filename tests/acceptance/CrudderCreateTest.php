<?php

use Lupka\Crudder\CrudderModel;

class CrudderCreateTest extends CrudderTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
    }

    /** @test */
    public function a_model_row_can_be_created()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $model = new CrudderModel('Models\ModelA');

        $this->visit($model->createUrl());
        $this->type('MODEL_NAME', 'name');
        $this->press('Submit');

        $this->seeInDatabase('model_as', ['name' => 'MODEL_NAME']);
    }

    /** @test */
    public function non_hidden_default_fields_are_shown_on_form()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => ['hidden_fields' => ['id']]]);
        $model = new CrudderModel('Models\ModelA');

        $this->visit($model->createUrl());

        $this->see('created_at');
        $this->see('updated_at');
    }

    /** @test */
    public function additional_fields_can_be_hidden_from_form()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => ['hidden_fields' => ['another_text_field']]]);
        $model = new CrudderModel('Models\ModelA');

        $this->visit($model->createUrl());

        $this->dontSee('another_text_field');
    }
}

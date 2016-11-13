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

}

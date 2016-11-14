<?php

use Lupka\Crudder\CrudderModel;

class CrudderEditTest extends CrudderTestCase
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
    public function a_model_row_can_be_edited()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'MODEL_NAME']);
        $model->save();

        $this->visit($crudderModel->editUrl($model));
        $this->see('MODEL_NAME');
        $this->type('NEW_MODEL_NAME', 'name');
        $this->press('Submit');

        $this->seeInDatabase('model_as', ['id' => $model->id, 'name' => 'NEW_MODEL_NAME']);
    }

}

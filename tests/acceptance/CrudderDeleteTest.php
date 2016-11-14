<?php

use Lupka\Crudder\CrudderModel;

class CrudderDeleteTest extends CrudderTestCase
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
    public function a_model_row_can_be_deleted()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $crudderModel = new CrudderModel('Models\ModelA');

        // TODO: factories?
        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'MODEL_NAME']);
        $model->save();

        $this->visit($crudderModel->deleteUrl($model));
        $this->seePageIs($crudderModel->indexUrl());
        $this->dontSeeInDatabase('model_as', ['id' => $model->id]);
    }

}

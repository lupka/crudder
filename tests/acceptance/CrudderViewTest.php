<?php

use Lupka\Crudder\CrudderModel;

class CrudderViewTest extends CrudderTestCase
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
    public function a_model_row_can_be_viewed()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'ASDFASDF']);
        $model->save();

        $this->visit($crudderModel->viewUrl($model));
        $this->see('Name'); // label
        $this->see('ASDFASDF'); // value

    }

}

<?php

use Lupka\Crudder\CrudderModel;

class CrudderIndexTest extends CrudderTestCase
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
    public function model_index_shows_rows()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $crudderModel = new CrudderModel('Models\ModelA');

        // TODO: factories for these???
        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'ENTRY_1']);
        $model->save();

        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'ENTRY_2']);
        $model->save();

        $this->visit($crudderModel->indexUrl());
        $this->see('ENTRY_1');
        $this->see('ENTRY_2');
    }

}

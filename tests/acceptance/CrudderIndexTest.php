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

    /** @test */
    public function model_index_shows_correct_index_display_fields()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'index_display_fields' => ['name', 'textarea_field']
        ]]);

        $crudderModel = new CrudderModel('Models\ModelA');

        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'ENTRY_1', 'another_text_field' => 'NOPE', 'textarea_field' => 'Some longer sentence.']);
        $model->save();

        $this->visit($crudderModel->indexUrl());
        $this->see('ENTRY_1');
        $this->see('Some longer sentence.');
        $this->dontSee('NOPE');
        $this->see('Name');
        $this->see('Textarea Field');
        $this->dontSee('Another Text Field');
    }

}

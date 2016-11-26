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

    /** @test */
    public function registered_scripts_are_seen_on_edit_page()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'fields' => [
                'textarea_field' => [
                    'type' => 'wysiwyg'
                ]
            ]
        ]]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'MODEL_NAME']);
        $model->save();

        $this->visit($crudderModel->editUrl($model));
        $this->see('cdn.tinymce.com/4/tinymce.min.js');
    }

    /** @test */
    public function form_attributes_are_displayed_on_edit_page()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'fields' => [
                'name' => [
                    'type' => 'file_upload'
                ]
            ]
        ]]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $model = $crudderModel->dispenseModel();
        $model->fill(['name' => 'MODEL_NAME']);
        $model->save();

        $this->visit($crudderModel->editUrl($model));
        $this->see('enctype="multipart/form-data"');
    }

}

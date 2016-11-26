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
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->visit($crudderModel->createUrl());
        $this->type('MODEL_NAME', 'name');
        $this->press('Submit');

        $this->seeInDatabase('model_as', ['name' => 'MODEL_NAME']);
    }

    /** @test */
    public function non_hidden_default_fields_are_shown_on_form()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => ['hidden_fields' => ['id']]]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->visit($crudderModel->createUrl());

        $this->see('created_at');
        $this->see('updated_at');
    }

    /** @test */
    public function additional_fields_can_be_hidden_from_form()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => ['hidden_fields' => ['another_text_field']]]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->visit($crudderModel->createUrl());

        $this->dontSee('another_text_field');
    }

    /** @test */
    public function registered_scripts_are_seen_on_create_page()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'fields' => [
                'textarea_field' => [
                    'type' => 'wysiwyg'
                ]
            ]
        ]]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->visit($crudderModel->createUrl());
        $this->see('cdn.tinymce.com/4/tinymce.min.js');
    }

    /** @test */
    public function form_attributes_are_displayed_on_create_page()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'fields' => [
                'name' => [
                    'type' => 'file_upload'
                ]
            ]
        ]]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->visit($crudderModel->createUrl());
        $this->see('enctype="multipart/form-data"');
    }
}

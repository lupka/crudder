<?php

use Lupka\Crudder\CrudderModel;

class CrudderModelFormAttributeTest extends CrudderTestCase
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
    public function field_can_regsiter_form_attribute_with_model()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'fields' => [
                'name' => [
                    'type' => 'file_upload'
                ]
            ]
        ]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->assertEquals(['enctype' => 'multipart/form-data'], $crudderModel->formAttributes);
    }

    /** @test */
    public function form_attribute_array_can_be_converted_to_html_string()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $crudderModel->formAttributes = ['enctype' => 'multipart/form-data', 'another-attr' => 'ASDF'];

        $this->assertEquals('enctype="multipart/form-data" another-attr="ASDF"', $crudderModel->formAttributeString());
    }

}

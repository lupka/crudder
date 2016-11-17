<?php

use Lupka\Crudder\CrudderModel;

class CrudderFieldConfigTest extends CrudderTestCase
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
    public function fields_are_generated_as_correct_type_based_on_config()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'fields' => [
                'select_option_field' => [
                    'type' => 'select'
                ]
            ]
        ]]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->assertInstanceOf('Lupka\Crudder\Fields\Select', $crudderModel->fields->where('fieldName', 'select_option_field')->first());
    }

}

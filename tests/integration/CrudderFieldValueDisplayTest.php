<?php

use Lupka\Crudder\CrudderModel;

class CrudderFieldValueDisplayTest extends CrudderTestCase
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
    public function basic_field_output_function_returns_unfiltered_value()
    {
        $field = new Lupka\Crudder\Fields\Field('Models\ModelA', 'test');
        $model = new Models\ModelA(['test' => 'The Value']);

        $this->assertEquals('The Value', $field->displayValue($model));
    }

    /** @test */
    public function non_default_field_output_modifies_result()
    {
        // using image_upload type as an example
        $field = new Lupka\Crudder\Fields\ImageUpload('Models\ModelA', 'test');
        $model = new Models\ModelA(['test' => 'test.jpg']);

        $this->assertContains('<img', $field->displayValue($model));
    }
}

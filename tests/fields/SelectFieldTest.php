<?php

use Lupka\Crudder\CrudderModel;

class SelectFieldTest extends CrudderTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);

        app('config')->set('crudder.models', [
            'Models\ModelA' => [
                'fields' => [
                    'test_select_field' => [
                        'options' => [
                            1 => 'Option 1',
                            2 => 'Another Option',
                        ]
                    ]
                ]
            ]
        ]);
        $this->crudderModel = new CrudderModel('Models\ModelA');
        $this->field = $this->crudderModel->addField('select', 'Models\ModelA', 'test_select_field');
    }

    /** @test */
    public function select_field_form_field_renders_without_value()
    {
        $fieldString = (string)$this->field->renderFormField();

        $this->assertContains('test_select_field', $fieldString);
        $this->assertContains('Test Select Field', $fieldString);
        $this->assertContains('select', $fieldString);
        $this->assertContains('<option value="1">Option 1</option>', $fieldString);
    }

    /** @test */
    public function select_field_form_field_renders_with_value()
    {
        $model = $this->crudderModel->dispenseModel();
        $model->test_select_field = 2;
        $fieldString = (string)$this->field->renderFormField($model);

        $this->assertContains('test_select_field', $fieldString);
        $this->assertContains('Test Select Field', $fieldString);
        $this->assertContains('select', $fieldString);
        $this->assertContains('<option value="1">Option 1</option>', $fieldString);
        $this->assertContains('selected="selected"', $fieldString);
    }

}

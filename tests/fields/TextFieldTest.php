<?php

use Lupka\Crudder\CrudderModel;

class TextFieldTest extends CrudderTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);

        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $this->crudderModel = new CrudderModel('Models\ModelA');
        $this->field = $this->crudderModel->addField('text', 'Models\ModelA', 'test_text_field');
    }

    /** @test */
    public function text_field_form_field_renders_without_value()
    {
        $fieldString = (string)$this->field->renderFormField();

        $this->assertContains('test_text_field', $fieldString);
        $this->assertContains('Test Text Field', $fieldString);
        $this->assertContains('input', $fieldString);
    }

    /** @test */
    public function text_field_form_field_renders_with_value()
    {
        $model = $this->crudderModel->dispenseModel();
        $model->test_text_field = 'VALUE_HERE';
        $fieldString = (string)$this->field->renderFormField($model);

        $this->assertContains('test_text_field', $fieldString);
        $this->assertContains('Test Text Field', $fieldString);
        $this->assertContains('input', $fieldString);
        $this->assertContains('VALUE_HERE', $fieldString);
    }

}

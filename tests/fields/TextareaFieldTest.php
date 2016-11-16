<?php

use Lupka\Crudder\CrudderModel;

class TextareaFieldTest extends CrudderTestCase
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
        $this->field = $this->crudderModel->addField('textarea', 'Models\ModelA', 'textarea_field');
    }

    /** @test */
    public function textarea_field_form_field_renders_without_value()
    {
        $fieldString = (string)$this->field->renderFormField();

        $this->assertContains('textarea_field', $fieldString);
        $this->assertContains('Textarea Field', $fieldString);
        $this->assertContains('<textarea', $fieldString);
    }

    /** @test */
    public function textarea_field_form_field_renders_with_value()
    {
        $model = $this->crudderModel->dispenseModel();
        $model->textarea_field = 'This is some longer text.';
        $fieldString = (string)$this->field->renderFormField($model);

        $this->assertContains('textarea_field', $fieldString);
        $this->assertContains('Textarea Field', $fieldString);
        $this->assertContains('<textarea', $fieldString);
        $this->assertContains('This is some longer text.', $fieldString);
    }

}

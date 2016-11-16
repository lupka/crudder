<?php

use Lupka\Crudder\CrudderModel;

class CheckboxFieldTest extends CrudderTestCase
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
        $this->field = $this->crudderModel->addField('checkbox', 'Models\ModelA', 'checkbox_field');
    }

    /** @test */
    public function checkbox_field_form_field_renders_without_value()
    {
        $fieldString = (string)$this->field->renderFormField();

        $this->assertContains('checkbox_field', $fieldString);
        $this->assertContains('Checkbox Field', $fieldString);
        $this->assertContains('type="checkbox"', $fieldString);
    }

    /** @test */
    public function checkbox_field_form_field_renders_with_value()
    {
        $model = $this->crudderModel->dispenseModel();
        $model->checkbox_field = true;
        $fieldString = (string)$this->field->renderFormField($model);

        $this->assertContains('checkbox_field', $fieldString);
        $this->assertContains('Checkbox Field', $fieldString);
        $this->assertContains('type="checkbox"', $fieldString);
        $this->assertContains('checked="checked"', $fieldString);
    }

}

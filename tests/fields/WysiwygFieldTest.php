<?php

use Lupka\Crudder\CrudderModel;

class WysiwygFieldTest extends CrudderTestCase
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
        $this->field = $this->crudderModel->addField('wysiwyg', 'Models\ModelA', 'wysiwyg_field');
    }

    /** @test */
    public function wysiwyg_field_form_field_renders_without_value()
    {
        $fieldString = (string)$this->field->renderFormField();

        $this->assertContains('wysiwyg_field', $fieldString);
        $this->assertContains('Wysiwyg Field', $fieldString);
        $this->assertContains('<textarea', $fieldString);
        $this->assertContains('wysiwyg-textarea', $fieldString);
    }

    /** @test */
    public function wysiwyg_field_form_field_renders_with_value()
    {
        $model = $this->crudderModel->dispenseModel();
        $model->wysiwyg_field = 'String <a href="#">with some</a> extra <strong>HTML</strong>.';
        $fieldString = (string)$this->field->renderFormField($model);

        $this->assertContains('wysiwyg_field', $fieldString);
        $this->assertContains('Wysiwyg Field', $fieldString);
        $this->assertContains('<textarea', $fieldString);
        $this->assertContains('wysiwyg-textarea', $fieldString);
        $this->assertContains('String <a href="#">with some</a> extra <strong>HTML</strong>.', $fieldString);
    }

}

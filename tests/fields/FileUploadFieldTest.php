<?php

use Lupka\Crudder\CrudderModel;

class FileUploadFieldTest extends CrudderTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadMigrationsFrom([
            '--database' => 'testing',
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);

        app('config')->set('crudder.models.Models\\ModelA', []);
        app('config')->set('crudder.models.Models\\ModelB', [
            'fields' => [
                'file_upload_field' => [
                    'type' => 'file_upload',
                    'upload_directory' => 'public/uploads',
                ]
            ]
        ]);
        $this->crudderModel = new CrudderModel('Models\ModelA');
        $this->field = $this->crudderModel->addField('file_upload', 'Models\ModelA', 'test_file_upload_field');
    }

    /** @test */
    public function file_upload_field_form_field_renders_without_value()
    {
        $fieldString = (string)$this->field->renderFormField();

        $this->assertContains('test_file_upload_field', $fieldString);
        $this->assertContains('Test File Upload Field', $fieldString);
        $this->assertContains('input', $fieldString);
        $this->assertContains('type="file"', $fieldString);
    }

    /** @test */
    public function file_upload_field_form_field_renders_with_value()
    {
        $model = $this->crudderModel->dispenseModel();
        $model->test_file_upload_field = 'http://test.com/full/file/location/jpg.jpg';
        $fieldString = (string)$this->field->renderFormField($model);

        $this->assertContains('test_file_upload_field', $fieldString);
        $this->assertContains('Test File Upload Field', $fieldString);
        $this->assertContains('input', $fieldString);
        $this->assertContains('type="file"', $fieldString);
        $this->assertContains('jpg.jpg', $fieldString);
    }

    /** @test */
    public function file_upload_field_upload_can_be_performed()
    {
        $crudderModel = new CrudderModel('Models\ModelB');
        $this->visit($crudderModel->createUrl())
             ->attach('tests/files/jpg.jpg', 'file_upload_field')
             ->press('Submit');
        $this->seeInDatabase('model_bs', ['file_upload_field' => 'jpg.jpg']);
    }

    /** @test */
    public function file_upload_field_can_be_left_blank_on_edit()
    {
        $crudderModel = new CrudderModel('Models\ModelB');
        $model = Models\ModelB::create(['title' => 'test', 'file_upload_field' => 'jpg.jpg', 'published' => false]);
        $this->visit($crudderModel->editUrl($model))
             ->press('Submit');
        $this->seeInDatabase('model_bs', ['file_upload_field' => 'jpg.jpg']);
    }

}

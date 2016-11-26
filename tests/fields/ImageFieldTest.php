<?php

use Lupka\Crudder\CrudderModel;

class ImageFieldTest extends CrudderTestCase
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
                    'type' => 'image_upload',
                    'upload_directory' => 'public/uploads',
                    'public_path' => '/storage',
                ]
            ]
        ]);
        $this->crudderModel = new CrudderModel('Models\ModelA');
        $this->field = $this->crudderModel->addField('image_upload', 'Models\ModelA', 'test_image_field');
    }

    /** @test */
    public function image_field_in_config_dispenses_correct_field_type()
    {
        $this->assertInstanceOf('Lupka\Crudder\Fields\ImageUpload', $this->field);
    }

    /** @test */
    public function image_field_form_field_renders_without_value()
    {
        $fieldString = (string)$this->field->renderFormField();

        $this->assertContains('test_image_field', $fieldString);
        $this->assertContains('Test Image Field', $fieldString);
        $this->assertContains('input', $fieldString);
        $this->assertContains('type="file"', $fieldString);
    }

    /** @test */
    public function image_field_form_field_renders_with_value()
    {
        $model = $this->crudderModel->dispenseModel();
        $model->test_image_field = 'http://test.com/full/file/location/jpg.jpg';
        $fieldString = (string)$this->field->renderFormField($model);

        $this->assertContains('test_image_field', $fieldString);
        $this->assertContains('Test Image Field', $fieldString);
        $this->assertContains('input', $fieldString);
        $this->assertContains('type="file"', $fieldString);
        $this->assertContains('<img ', $fieldString); // show actual image now
    }

    /** @test */
    public function image_field_upload_can_be_performed()
    {
        $crudderModel = new CrudderModel('Models\ModelB');
        $this->visit($crudderModel->createUrl())
             ->attach('tests/files/jpg.jpg', 'file_upload_field')
             ->press('Submit');
        $this->seeInDatabase('model_bs', ['file_upload_field' => 'jpg.jpg']);
    }

    /** @test */
    public function image_field_display_value_outputs_img_tag()
    {
        $this->field->config['public_path'] = '/storage';
        $model = $this->crudderModel->dispenseModel();
        $model->test_image_field = 'jpg.jpg';

        $this->assertContains('<img src="/storage/jpg.jpg"', $this->field->displayValue($model));
    }
}

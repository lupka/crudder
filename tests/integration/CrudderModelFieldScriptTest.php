<?php

use Lupka\Crudder\CrudderModel;

class CrudderModelFieldScriptTest extends CrudderTestCase
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
    public function field_script_can_be_registered_with_model()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [
            'fields' => [
                'textarea_field' => [
                    'type' => 'wysiwyg'
                ]
            ]
        ]]);
        $crudderModel = new CrudderModel('Models\ModelA');
        $this->assertArrayHasKey('wysiwyg', $crudderModel->scripts);
    }
}

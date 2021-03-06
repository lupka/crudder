<?php

use Lupka\Crudder\CrudderModel;

class CrudderModelConfigTest extends CrudderTestCase
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
    public function crudder_model_basic_config_test()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => []]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->assertArraySubset([
            'name' => 'Model A',
            'name_plural' => 'Model As',
            'dashboard' => true,
        ], $crudderModel->config);
    }

    /** @test */
    public function crudder_model_basic_config_inheritance_test()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => ['dashboard' => false, 'name' => 'Some Cool Model']]);
        $crudderModel = new CrudderModel('Models\ModelA');

        $this->assertArraySubset([
            'name' => 'Some Cool Model',
            'name_plural' => 'Some Cool Models',
            'dashboard' => false,
        ], $crudderModel->config);
    }

}

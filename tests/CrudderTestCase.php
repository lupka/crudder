<?php

class CrudderTestCase extends Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return ['Lupka\Crudder\CrudderServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Crudder' => 'Lupka\Crudder\CrudderFacade'
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function setUp()
    {
        parent::setUp();

        // add crudder routes
        app('router')->group(['prefix' => 'crudder'], function(){
            Crudder::routes();
        });

        // add default config
        app('config')->set('crudder', [
            'models' => [],
        ]);
    }

}

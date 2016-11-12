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

<?php

class CrudderDashboardTest extends CrudderTestCase
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
    public function crudder_dashboard_can_be_viewed()
    {
        // set config with basic models
        app('config')->set('crudder.models', ['Models\ModelA' => []]);

        $this->visit('/crudder/dashboard');
        $this->see('Model As');
    }

}

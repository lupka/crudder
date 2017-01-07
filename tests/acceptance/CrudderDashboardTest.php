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
        app('config')->set('crudder.models', ['Models\ModelA' => [], 'Models\ModelB' => []]);

        // add one row to test display
        Models\ModelA::create(['name' => 'Test Model A']);

        $this->visit('/crudder/dashboard');
        $this->see('Model As');
        $this->see('Model Bs');
        $this->see('Test Model A');
    }

    /** @test */
    public function root_url_redirects_to_dashboard()
    {
        $this->visit('/crudder');
        $this->seePageIs('/crudder/dashboard');
    }

    /** @test */
    public function models_can_be_hidden_from_dashboard()
    {
        // set config with basic models
        app('config')->set('crudder.models', ['Models\ModelA' => [], 'Models\ModelB' => ['dashboard' => false]]);

        $this->visit('/crudder/dashboard');
        $this->see('Model As');
        $this->dontSee('Model Bs');
    }

    /** @test */
    public function dashboard_label_field_can_be_changed()
    {
        // set config with basic models
        app('config')->set('crudder.models', ['Models\ModelA' => ['dashboard_listing_field' => 'another_text_field']]);

        // add one row to test display
        Models\ModelA::create(['name' => 'Test Model A', 'another_text_field' => 'Alternate Name']);

        $this->visit('/crudder/dashboard');
        $this->see('Model As');
        $this->dontSee('Test Model A');
        $this->see('Alternate Name');
        $this->see('Another Text Field'); // field label (from another_text_field)
    }

}

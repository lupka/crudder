<?php

class CrudderLayoutTest extends CrudderTestCase
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
    public function crudder_page_title_test()
    {
        $this->visit('/crudder/dashboard');
        $this->see('<title>Crudder</title>');

        app('config')->set('crudder.title', 'Admin');

        $this->visit('/crudder/dashboard');
        $this->see('<title>Admin</title>');
    }

    /** @test */
    public function crudder_navbar_title_test()
    {
        app('config')->set('crudder.navbar.title', 'A DIFFERENT TITLE');

        $this->visit('/crudder/dashboard');
        $this->see('A DIFFERENT TITLE');
    }

}

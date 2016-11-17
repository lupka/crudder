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

}

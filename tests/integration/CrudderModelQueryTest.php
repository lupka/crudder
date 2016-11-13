<?php

use Lupka\Crudder\CrudderModel;

class CrudderModelQueryTest extends CrudderTestCase
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
    public function crudder_model_get_returns_all_models_in_collection()
    {
        app('config')->set('crudder.models', ['Models\ModelA' => [], 'Models\ModelB' => []]);

        $models = CrudderModel::get();

        $this->assertInstanceOf('Illuminate\Support\Collection', $models);
        $this->assertInstanceOf('Lupka\Crudder\CrudderModel', $models->first());
        $this->assertEquals(['Models\ModelA', 'Models\ModelB'], $models->map(function($item){ return $item->className; })->values()->toArray());
    }

}

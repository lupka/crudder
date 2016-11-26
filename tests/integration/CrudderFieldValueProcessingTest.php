<?php

use Lupka\Crudder\CrudderModel;

class CrudderFieldValueProcessingTest extends CrudderTestCase
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
    public function basic_field_process_function_returns_unfiltered_value()
    {
        $field = new Lupka\Crudder\Fields\Field('TestModel', 'test');

        $request = Mockery::mock('Illuminate\Http\Request');
        $request->shouldReceive('get')
            ->once()
            ->with('test')
            ->andReturn('The Value');

        $this->assertEquals('The Value', $field->processInputValue($request, 'test'));
    }

}

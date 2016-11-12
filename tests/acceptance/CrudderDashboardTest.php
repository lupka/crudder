<?php

class CrudderDashboardTest extends CrudderTestCase
{

    /** @test */
    public function crudder_dashboard_can_be_viewed()
    {
        $this->visit('/crudder/dashboard');

    }

}

<?php

namespace Lupka\Crudder;

use Illuminate\Support\Facades\Facade;

class CrudderFacade extends Facade{

    protected static function getFacadeAccessor()
    {
        return 'crudder';
    }

}

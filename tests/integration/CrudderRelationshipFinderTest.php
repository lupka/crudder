<?php

use Lupka\Crudder\RelationshipFinder;

class CrudderRelationshipFinderTest extends CrudderTestCase
{

    /** @test */
    public function relationship_finder_can_detect_all_relationship()
    {
        $finder = new RelationshipFinder();
        $relationships = $finder->getPropertiesFromMethods(new Models\RelationshipModel());

        $this->assertArraySubset([
            'relatedModel' =>
            [
                'fieldName' => 'relatedModel',
                'type' => 'belongsTo',
                'model' => '\Models\RelatedModel',
            ]
        ], $relationships);
    }

}

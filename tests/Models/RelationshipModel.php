<?php

namespace Models;

use Illuminate\Database\Eloquent\Model;

class RelationshipModel extends Model
{
    protected $guarded = ['id'];

    public function relatedModel()
    {
        return $this->belongsTo('Models\RelatedModel');
    }
}

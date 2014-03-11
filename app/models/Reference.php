<?php
class Reference extends Eloquent
{
    public $table="references";
    /**
     * One to many relationship
     * @return Object [description]
     */
    public function category(){
    	return $this->belongsTo("Category","category_id");
    }

    public function attribute(){
    	return $this->belongsTo('Attribute', 'attribute_id');
    }
    
}
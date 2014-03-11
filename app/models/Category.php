<?php
class Category extends Eloquent
{
    public $table="categories";
    
    public function reference(){
    	return $this->hasMany("Reference","category_id");
    }
}
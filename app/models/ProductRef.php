<?php
class ProductRef extends Eloquent
{
    public $table="product_refs";

    public function product(){
    	return $this->belongsTo("Product","product_id");
    }

    public function productAtt(){
    	return $this->belongsTo("ProductAtt","product_id");
    }

    public function toolRef(){
    	return $this->hasOne('ToolRef','product_ref_id');
    }


}
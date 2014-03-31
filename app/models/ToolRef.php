<?php
class ToolRef extends Eloquent
{
    public $table="tool_refs";

    public function product(){
    	return $this->belongsTo("ProductRef","product_ref_id");
    }

    public function equipment(){
    	return $this->belongsTo("Equipment","equipment_id");
    }


}
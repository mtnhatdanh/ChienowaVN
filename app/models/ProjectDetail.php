<?php
use LaravelBook\Ardent\Ardent;
class ProjectDetail extends Ardent
{
    public $table="project_details";

    public static $rules = array(
        'project_id'       =>'required|integer',
        'order_product_id' =>'required|integer'
        );

    public static $relationsData = array(
		'project'      => array(self::BELONGS_TO, 'Project', 'project_id'),
		'orderProduct' => array(self::BELONGS_TO, 'OrderProduct', 'order_product_id')
        ); 

}

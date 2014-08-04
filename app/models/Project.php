<?php
use LaravelBook\Ardent\Ardent;
class Project extends Ardent
{
    public $table="projects";

    public static $rules = array(
        'name'     =>'required'
        );

    public static $relationsData = array(
		'projectDetails' => array(self::HAS_MANY, 'ProjectDetail', 'project_id'),
		'quotations'     => array(self::HAS_MANY, 'Quotation', 'project_id')
        ); 

}

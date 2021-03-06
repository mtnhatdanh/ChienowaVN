<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

// Model Event validation create new Transacton
Transaction::creating(function($transaction)
{
    if ( ! $transaction->isValid()) {
    	$notification = new Notification;
    	$notification->set('danger', 'Can not create!!');
    	Cache::put('notification', $notification, 10);
    	return false;
    }
});

Transaction::updating(function($transaction)
{
    if ( ! $transaction->isValid()) return false;
}); 

// Model Event validation Calibration
Calibration::creating(function($calibration){
	if (!$calibration->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not create!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});

Calibration::updating(function($calibration){
	if (!$calibration->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not update!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});

// Model Event validation Report
Report::creating(function($report){
	if (!$report->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not create!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});

Report::updating(function($report){
	if (!$report->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not update!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});

// Model Event prevent delete Report while still have link
// Report::deleting(function($report){
// 	if (count($report->calibration)||count($report->inspection)) {
// 		$notification = new Notification;
// 		$notification->set('danger', count($report->calibration).'-'.count($report->inspection));
// 		Cache::put('notification', $notification, 10);
// 		return false;
// 	}
// });


// Model Event prevent delete object while still have link

User::deleting(function($user){
	if (count($user->expense)) {
		$notification = new Notification;
		$notification->type = "danger";
		$notification->value = "Can not delete user ".$user->name;
		Cache::put('notification', $notification, 10);
		return false;
	}
});

Category::deleting(function($category){
	if (count($category->reference) || count($category->item)) {
		return false;
	}
});

Item::deleting(function($item){
	if (count($item->itematt) || count($item->transaction)) {
		return false;
	}
});

// Model Event validation Product
Product::creating(function($product){
	if (!$product->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not create!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});
Product::updating(function($Product){
	if (!$product->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not update!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});


// Model Event validation ProductAtt
ProductAtt::creating(function($ProductAtt){
	if (!$ProductAtt->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not create!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});
ProductAtt::updating(function($ProductAtt){
	if (!$ProductAtt->isValid()) {
		$notification = new Notification;
    	$notification->set('danger', 'Can not update!!');
    	Cache::put('notification', $notification, 10);
    	return false;
	}
});

// Delete InspectionDetail when delete Inspection
Inspection::deleting(function($inspection){
	if (count($inspection->inspectionDetail)) {
		foreach ($inspection->inspectionDetail as $inspectionDetail) {
			$del = InspectionDetail::find($inspectionDetail->id);
			$del->delete();
		}
	}
});

// Model Supplier prevent delete Supplier when still have link
Supplier::deleting(function($supplier){
	if (count($supplier->quotations) || count($supplier->orders)) {
		return false;
	}
});

// Model OrderProduct prevent delete OrderProduct when still have link
OrderProduct::deleting(function($orderProduct){
	if (count($orderProduct->quotationDetails) || count($orderProduct->orderDetails)) {
		return false;
	}
});


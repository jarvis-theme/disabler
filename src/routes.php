<?php
Route::group(array('before' => 'subdomain'), function() {
	Route::controller('disabler','Yusidabcs\Disabler\DisablerHomeController');
});

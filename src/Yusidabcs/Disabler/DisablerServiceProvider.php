<?php namespace Yusidabcs\Disabler;

use Illuminate\Support\ServiceProvider;

class DisablerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;
	public function boot()
    {
        $this->package('Yusidabcs/disabler');
        include __DIR__.'/../../routes.php';
    }
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['disabler'] = $this->app->share(function($app)
        {
            return new Disabler;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('disabler');
	}

}
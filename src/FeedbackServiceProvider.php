<?php

namespace Clevyr\FeedbackForm;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class FeedbackServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish routes
        $this->loadRoutesFrom(__DIR__ . '/routes/feedback.php');

        // Publish config
        $this->publishes([
            __DIR__ . '/config/feedback.php' => config_path('feedback.php'),
        ], 'config');

        // Publish notifications
        $this->publishes([
            __DIR__ . '/app/Notifications/Feedback.php' => app_path('Notifications/Feedback.php'),
        ], 'notifications');

        // Publish resources
        $this->publishes([
            __DIR__ . '/js/FeedbackForm.vue' => resource_path('js/components/FeedbackForm.vue'),
        ], 'resources');
    }
}

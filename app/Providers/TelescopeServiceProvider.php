<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();
        Telescope::filter(function (IncomingEntry $entry) {
            if ($this->allowedEnv()) {
                return true;
            }

            return $entry->isReportableException() ||
                   $entry->isFailedRequest() ||
                   $entry->isFailedJob() ||
                   $entry->isScheduledTask() ||
                   $entry->hasMonitoredTag() ||
                   $entry->isQuery() ||
                   $entry->type === EntryType::COMMAND ||
                   $entry->type === EntryType::LOG;
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     *
     * @return void
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->allowedEnv()) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [
                'chisom@homer.com'
            ]);
        });
    }

    /**
     * Configure the Telescope authorization services.
     *
     * @return void
     */
    protected function authorization() :void
    {
        $this->gate();

        Telescope::auth(function ($request) {
            return $this->allowedEnv() ||
                   Gate::check('viewTelescope', [$request->user()]);
        });
    }

    public function allowedEnv(): bool
    {
        return $this->app->environment('local') ||
                    $this->app->environment('development');
    }
}

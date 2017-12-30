<?php

namespace App\Providers;

use Laravel\Spark\Spark;
use Laravel\Spark\Providers\AppServiceProvider as ServiceProvider;

class SparkServiceProvider extends ServiceProvider
{
    /**
     * Your application and company details.
     *
     * @var array
     */
    protected $details = [
        'vendor' => 'Your Company',
        'product' => 'Your Product',
        'street' => 'PO Box 111',
        'location' => 'Your Town, NY 12345',
        'phone' => '555-555-5555',
    ];

    /**
     * The address where customer support e-mails should be sent.
     *
     * @var string
     */
    protected $sendSupportEmailsTo = null;

    /**
     * All of the application developer e-mail addresses.
     *
     * @var array
     */
    protected $developers = [
        //
    ];

    /**
     * Indicates if the application will expose an API.
     *
     * @var bool
     */
    protected $usesApi = false;

    /**
     * Finish configuring Spark for the application.
     *
     * @return void
     */
    public function booted()
    {
        Spark::useStripe()->noCardUpFront()->trialDays(10);

        Spark::freePlan()
            ->features([
                '3 Public Repositories',
                'Base Theme',
                'Version Control on Releases'
            ]);
        
        Spark::plan('Private Plan', 'private')
            ->price(9)
            ->features([
                'Unlimited Private And Public Repositories',
                'All Themes',
                'Version Control On Releases'
            ]);
        
        Spark::plan('Organization Plan', 'organization')
            ->price(12)
            ->features([
                'Unlimited Private, Public, and Organization Repositories',
                'All Themes',
                'Version Control On Releases'
            ]);
        
        

        // Spark::plan('Basic', 'provider-id-1')
        //     ->price(10)
        //     ->features([
        //         'First', 'Second', 'Third'
        //     ]);
    }
}

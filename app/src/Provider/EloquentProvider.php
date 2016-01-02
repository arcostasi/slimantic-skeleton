<?php

namespace App\Provider;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Eloquent Provider.
 *
 * @package App\Provider
 */
class EloquentProvider extends Capsule
{
    /**
     * Database manager constructor.
     *
     * @param array $settings
     */
    public function __construct($settings = [])
    {
        parent::__construct();

        $this->addConnection($settings);

        // Make this Capsule instance available globally via static methods
        $this->setAsGlobal();

        // Setup the Eloquent ORM
        $this->bootEloquent();
    }
}
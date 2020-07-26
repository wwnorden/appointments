<?php

namespace WWN\Appointments\Extensions;

use SilverStripe\ORM\DataExtension;
use WWN\Appointments\Appointment;

/**
 * VehicleExtension
 *
 * @package wwn-appointments
 */
class VehicleExtension extends DataExtension
{
    /**
     * @var array
     */
    private static $belongs_many_many = [
        'Appointment' => Appointment::class,
    ];
}

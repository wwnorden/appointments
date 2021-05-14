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
    private static array $belongs_many_many = [
        'Appointment' => Appointment::class,
    ];
}

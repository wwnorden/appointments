<?php

namespace WWN\Appointments;

use DateTime;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;
use WWN\Vehicles\Vehicle;

/**
 * AppointmentList
 *
 * @package wwn-appointments
 */
class AppointmentList extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'WWNAppointmentLists';

    /**
     * @var string[]
     */
    private static $db = [
        'Title' => 'Varchar(255)',
    ];

    /**
     * @var string[]
     */
    private static $belongs_many_many = [
        'Appointments' => Appointment::class,
    ];
}

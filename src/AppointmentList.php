<?php

namespace WWN\Appointments;

use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;

/**
 * AppointmentList
 *
 * @package wwn-appointments
 * @property string $Title
 * @method ManyManyList Appointments()
 * @method ManyManyList Pages()
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
        'Pages' => SiteTree::class,
    ];
}

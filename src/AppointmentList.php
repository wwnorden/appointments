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
    private static string $table_name = 'WWNAppointmentLists';

    /**
     * @var string[]
     */
    private static array $db = [
        'Title' => 'Varchar(255)',
    ];

    /**
     * @var string[]
     */
    private static array $belongs_many_many = [
        'Appointments' => Appointment::class,
        'Pages' => SiteTree::class,
    ];
}

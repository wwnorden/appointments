<?php

namespace WWN\Appointments;

use PageController;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;

/**
 * AppointmentsPageController
 *
 * @package wwn-appointments
 */
class AppointmentsPageController extends PageController
{
    /**
     * get appointments sorted by date
     *
     * @return DataList
     */
    public function Appointments(): DataList
    {
        return DataObject::get(
            Appointment::class,
            '',
            'Date ASC'
        );
    }
}

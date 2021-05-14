<?php

namespace WWN\Appointments\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use WWN\Appointments\Appointment;

/**
 * PageControllerExtension
 *
 * @package wwn-appointments
 */
class PageControllerExtension extends Extension
{
    /**
     * @param int $limit
     *
     * @return DataList
     */
    public function GetNextAppointment(int $limit = 2): DataList
    {
        return DataObject::get(Appointment::class)
            ->where("Date >= NOW()")
            ->sort('Date ASC')
            ->limit($limit);
    }
}

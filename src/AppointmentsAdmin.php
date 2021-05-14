<?php

namespace WWN\Appointments;

use SilverStripe\Admin\ModelAdmin;

/**
 * AppointmentsAdmin
 *
 * @package wwn-appointments
 */
class AppointmentsAdmin extends ModelAdmin
{
    /**
     * @var string
     */
    private static string $menu_icon_class = 'font-icon-calendar';

    /**
     * @var string
     */
    private static string $menu_title = 'Termine';

    /**
     * @var string
     */
    private static string $url_segment = 'termine';

    /**
     * @var string[]
     */
    private static array $managed_models = [
        'WWN\Appointments\AppointmentList',
        'WWN\Appointments\Appointment',
    ];
}

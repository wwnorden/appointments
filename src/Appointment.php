<?php

namespace WWN\Appointments;

use DateTime;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;
use WWN\Vehicles\Vehicle;

/**
 * Appointment
 *
 * @package wwn-appointments
 */
class Appointment extends DataObject
{
    /**
     * @var string
     */
    private static $table_name = 'WWNAppointments';

    /**
     * @var string[]
     */
    private static $db = [
        'Date' => 'DBDatetime',
        'Unity' => 'Varchar(100)',
        'Subject' => 'Varchar(300)',
        'Location' => 'Varchar(100)',
        'Leadership' => 'Varchar(100)',
        'Clothing' => 'Varchar(100)',
    ];

    /**
     * @var string[]
     */
    private static $many_many = [
        'Vehicles' => Vehicle::class,
    ];

    /**
     * @var array[]
     */
    private static $indexes = [
        'SearchFields' => [
            'type' => 'fulltext',
            'columns' => ['Subject', 'Location'],
        ],
    ];

    /**
     * @var string[]
     */
    private static $default_sort = [
        'Date' => 'DESC',
        'ID' => 'DESC',
    ];

    /**
     * @var string[]
     */
    private static $summary_fields = [
        'DateFormatted',
        'Unity',
        'Subject',
        'Location',
        'Leadership',
        'Clothing',
    ];

    /**
     * @param bool $includerelations
     *
     * @return array
     */
    public function fieldLabels($includerelations = true): array
    {
        $labels = parent::fieldLabels(true);
        $labels['DateFormatted'] =
            _t('WWN\Appointments\Appointment.db_Date', 'Date');

        return $labels;
    }

    /**
     * format date
     *
     * @return false|string
     */
    public function getDateFormatted(): ?string
    {
        $format = 'Y-m-d H:i:s';
        $date = DateTime::createFromFormat(
            $format,
            $this->dbObject('Date')->getValue()
        );

        return $this->replaceDay($date->format('l, d.m.Y H:i'));
    }

    /**
     * @var string[]
     */
    private static $searchable_fields = [
        'Subject',
        'Location',
    ];

    public function populateDefaults()
    {
        parent::populateDefaults();
        $this->Date = date('d.m.Y h:m');
    }

    /**
     * @return RequiredFields
     */
    public function getCMSValidator(): RequiredFields
    {
        return RequiredFields::create('Date');
    }

    /**
     * translate weekdays
     *
     * @param string
     *
     * @return string|string[]
     */
    private function replaceDay($date): string
    {
        switch ($date) {
            case strpos($date, 'Monday'):
                return str_replace(
                    'Monday',
                    _t(
                        'WWN\Appointments\Appointment.Monday',
                        'Monday'
                    ),
                    $date
                );
            case strpos($date, 'Tuesday'):
                return str_replace(
                    'Tuesday',
                    _t(
                        'WWN\Appointments\Appointment.Tuesday',
                        'Tuesday'
                    ),
                    $date
                );
            case strpos($date, 'Wednesday'):
                return str_replace(
                    'Wednesday',
                    _t(
                        'WWN\Appointments\Appointment.Wednesday',
                        'Wednesday'
                    ),
                    $date
                );
            case strpos($date, 'Thursday'):
                return str_replace(
                    'Thursday',
                    _t(
                        'WWN\Appointments\Appointment.Thursday',
                        'Thursday'
                    ),
                    $date
                );
            case strpos($date, 'Friday'):
                return str_replace(
                    'Friday',
                    _t(
                        'WWN\Appointments\Appointment.Friday',
                        'Friday'
                    ),
                    $date
                );
            case strpos($date, 'Saturday'):
                return str_replace(
                    'Saturday',
                    _t(
                        'WWN\Appointments\Appointment.Saturday',
                        'Saturday'
                    ),
                    $date
                );
            case strpos($date, 'Sunday'):
                return str_replace(
                    'Sunday',
                    _t(
                        'WWN\Appointments\Appointment.Sunday',
                        'Sunday'
                    ),
                    $date
                );
        }
    }

    /**
     * @return FieldList $fields
     */
    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        // Main tab
        $mainFields = [
            'Date' => $this->configDatetime('Date'),
        ];
        $fields->addFieldsToTab('Root.Main', $mainFields);

        return $fields;
    }

    /**
     * @param $field
     *
     * @return DatetimeField
     */
    private function configDatetime($field): DatetimeField
    {
        $dateTimefield = DatetimeField::create(
            $field,
            _t('WWN\Appointments\Appointment.db_'.$field, $field)
        )
            ->setHTML5(false)
            ->setDateTimeFormat(
                _t(
                    'WWN\Appointments\Appointment.DateTimeFormat',
                    'MM/dd/yyyy HH:mm'
                )
            );
        $dateTimefield->setDescription(
            _t(
                'WWN\Appointments\Appointment.DateTimeDescription',
                'e.g. {format}',
                ['format' => $dateTimefield->getDateTimeFormat()]
            )
        );
        $dateTimefield->setAttribute(
            'placeholder',
            $dateTimefield->getDateTimeFormat()
        );

        return $dateTimefield;
    }
}

<?php

namespace WWN\Appointments;

use DateTime;
use SilverStripe\Forms\DatetimeField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ManyManyList;
use WWN\Vehicles\Vehicle;

/**
 * Appointment
 *
 * @package wwn-appointments
 * @property string $Date
 * @property string $Unity
 * @property string $Subject
 * @property string $Location
 * @property string $Leadership
 * @property string $Clothing
 * @property string $CustomVehicleInfo
 * @method ManyManyList Vehicles()
 * @method ManyManyList Lists()
 */
class Appointment extends DataObject
{
    private static string $table_name = 'WWNAppointments';

    private static array $db = [
        'Date' => 'DBDatetime',
        'Unity' => 'Varchar(100)',
        'Subject' => 'Varchar(300)',
        'Location' => 'Varchar(100)',
        'Leadership' => 'Varchar(100)',
        'Clothing' => 'Varchar(100)',
        'CustomVehicleInfo' => 'Varchar(255)',
    ];

    private static array $many_many = [
        'Vehicles' => Vehicle::class,
        'Lists' => AppointmentList::class,
    ];

    private static array $indexes = [
        'SearchFields' => [
            'type' => 'fulltext',
            'columns' => ['Subject', 'Location'],
        ],
    ];

    private static array $default_sort = [
        'Date' => 'ASC',
        'ID' => 'ASC',
    ];

    private static array $summary_fields = [
        'DateFormatted',
        'Unity',
        'Subject',
        'Location',
        'Leadership',
        'Clothing',
    ];

    private static array $searchable_fields = [
        'Subject',
        'Location',
    ];

    public function fieldLabels($includerelations = true): array
    {
        $labels = parent::fieldLabels(true);
        $labels['DateFormatted'] =
            _t('WWN\Appointments\Appointment.db_Date', 'Date');

        return $labels;
    }

    /**
     * format date
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

    public function populateDefaults(): void
    {
        parent::populateDefaults();
        $this->Date = date('d.m.Y h:m');
        $this->CustomVehicleInfo = null;
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
     */
    private function replaceDay($date): string
    {
        switch ($date) {
            case str_contains($date, 'Monday'):
                return str_replace(
                    'Monday',
                    _t(
                        'WWN\Appointments\Appointment.Monday',
                        'Monday'
                    ),
                    $date
                );
            case str_contains($date, 'Tuesday'):
                return str_replace(
                    'Tuesday',
                    _t(
                        'WWN\Appointments\Appointment.Tuesday',
                        'Tuesday'
                    ),
                    $date
                );
            case str_contains($date, 'Wednesday'):
                return str_replace(
                    'Wednesday',
                    _t(
                        'WWN\Appointments\Appointment.Wednesday',
                        'Wednesday'
                    ),
                    $date
                );
            case str_contains($date, 'Thursday'):
                return str_replace(
                    'Thursday',
                    _t(
                        'WWN\Appointments\Appointment.Thursday',
                        'Thursday'
                    ),
                    $date
                );
            case str_contains($date, 'Friday'):
                return str_replace(
                    'Friday',
                    _t(
                        'WWN\Appointments\Appointment.Friday',
                        'Friday'
                    ),
                    $date
                );
            case str_contains($date, 'Saturday'):
                return str_replace(
                    'Saturday',
                    _t(
                        'WWN\Appointments\Appointment.Saturday',
                        'Saturday'
                    ),
                    $date
                );
            case str_contains($date, 'Sunday'):
                return str_replace(
                    'Sunday',
                    _t(
                        'WWN\Appointments\Appointment.Sunday',
                        'Sunday'
                    ),
                    $date
                );
            default:
                return '';
        }
    }

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();
        $fields->dataFields()['CustomVehicleInfo']->setDescription(
            _t('WWN\Appointments\Appointment.CustomVehicleInfoDescription',
                'Select if no vehicles are chosen')
        );
        return $fields;
    }

    private function configDatetime(): DatetimeField
    {
        $dateTimeField = DatetimeField::create(
            'Date',
            _t('WWN\Appointments\Appointment.db_' . 'Date', 'Date')
        )
            ->setHTML5(false)
            ->setDateTimeFormat(
                _t(
                    'WWN\Appointments\Appointment.DateTimeFormat',
                    'MM/dd/yyyy HH:mm'
                )
            );
        $dateTimeField->setDescription(
            _t(
                'WWN\Appointments\Appointment.DateTimeDescription',
                'e.g. {format}',
                ['format' => $dateTimeField->getDateTimeFormat()]
            )
        );
        $dateTimeField->setAttribute(
            'placeholder',
            $dateTimeField->getDateTimeFormat()
        );

        return $dateTimeField;
    }

    public function translateEnum(string $class, string $field): array
    {
        $enumArr = $this->dbObject($field)->enumValues();

        // Enum translations
        $translatedField = [];
        foreach ($enumArr as $key => $value) {
            $translatedField[$key] = _t($class . '.' . $key, $class . '.' . $key);
        }

        return $translatedField;
    }

    public function CustomVehicleInfoTranslation($CustomVehicleInfo): string
    {
        if (empty($CustomVehicleInfo)) {
            return '';
        } else {
            return _t('WWN\Appointments\Appointment.' . $CustomVehicleInfo,
                $CustomVehicleInfo);
        }
    }
}

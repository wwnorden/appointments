<?php

namespace WWN\Appointments\Extensions;

use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FieldGroup;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\ManyManyList;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use WWN\Appointments\AppointmentList;

/**
 * AppointmentListPageExtension
 *
 * @package wwn-appointments
 * @property bool $EnableAppointmentListExtension
 * @method ManyManyList AppointmentList()
 */
class AppointmentListPageExtension extends DataExtension
{
    /**
     * @var string[]
     */
    private static array $db = [
        'EnableAppointmentListExtension' => 'Boolean',
    ];

    /**
     * @var string[]
     */
    private static array $many_many = [
        'AppointmentLists' => AppointmentList::class,
    ];

    /**
     * @var string[][]
     */
    private static array $many_many_extraFields = [
        'AppointmentLists' => [
            'Sort' => 'Int',
        ],
    ];

    /**
     * @var false[]
     */
    private static array $defaults = [
        'EnableAppointmentListExtension' => false,
    ];

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        if ($this->owner->ID && $this->owner->EnableAppointmentListExtension) {
            $grid = GridField::create(
                'AppointmentLists',
                _t('WWN\Appointments\Extensions\AppointmentListPageExtension.many_many_AppointmentLists', 'Lists'),
                $this->owner->AppointmentLists(),
                GridFieldConfig::create()->addComponents(
                    new GridFieldToolbarHeader(),
                    new GridFieldAddNewButton('toolbar-header-right'),
                    new GridFieldDetailForm(),
                    new GridFieldDataColumns(),
                    new GridFieldEditButton(),
                    new GridFieldDeleteAction('unlinkrelation'),
                    new GridFieldDeleteAction(),
                    new GridFieldOrderableRows('Sort'),
                    new GridFieldTitleHeader(),
                    new GridFieldAddExistingAutocompleter('before', ['Title'])
                )
            );

            $fields->findOrMakeTab('Root.AppointmentLists', _t(
                    'WWN\Appointments\Extensions\AppointmentListPageExtension.many_many_AppointmentLists',
                    'Lists'
                )
            );
            $fields->addFieldToTab(
                'Root.AppointmentLists',
                $grid
            );
        } else {
            $fields->removeByName('AppointmentList');
        }
        parent::updateCMSFields($fields);
    }

    /**
     * @param FieldList $fields
     */
    public function updateSettingsFields(FieldList $fields)
    {
        $fields->addFieldsToTab(
            'Root.Settings',
            [
                $group = FieldGroup::create(
                    CheckboxField::create(
                        'EnableAppointmentListExtension',
                        _t(
                            'WWN\Appointments\Extensions\AppointmentListPageExtension.db_EnableAppointmentListExtension',
                            'Enable appointment lists on page'
                        )
                    )
                ),
                $group->setTitle(_t(
                    'WWN\Appointments\Extensions\AppointmentListPageExtension.PLURALNAME',
                    'Appointment lists'
                )),
            ]
        );
    }

    /**
     * @return DataList|ManyManyList
     */
    public function getSortedAppointmentLists()
    {
        return $this->owner->AppointmentLists()->sort('Sort ASC');
    }
}
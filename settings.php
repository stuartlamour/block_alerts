<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * alerts block settings.
 *
 * @package    block_alerts
 * @copyright  2023 Stuart Lamour
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

use block_alerts\admin_setting_date;

if ($hassiteconfig) {
    if ($ADMIN->fulltree) {

        $default = '';

        // Add 3 slots for alerts.
        for ($i = 1; $i < 4; $i++) {
            // Heading.
            $setting = new admin_setting_heading('h'.$i,
                get_string('alertsitem', 'block_alerts'),
                ''
            );
            $settings->add($setting);

            // Date.
            $setting = new admin_setting_date('block_alerts/date'.$i,
                get_string('date', 'block_alerts'),
                get_string('date_help', 'block_alerts'),
                $default
            );
            $settings->add($setting);

            // Title.
            $setting = new admin_setting_configtext('block_alerts/title'.$i,
                get_string('title', 'block_alerts'),
                '',
                $default,
                PARAM_RAW
            );
            $settings->add($setting);

            // Description.
            $setting = new admin_setting_configtext('block_alerts/description'.$i,
                get_string('description', 'block_alerts'),
                get_string('description_help', 'block_alerts'),
                $default,
                PARAM_RAW
            );
            $settings->add($setting);
        }
    }
}



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

if ($hassiteconfig) {
    if ($ADMIN->fulltree) {

        $default = '';

        // Staff only.
        $setting = new admin_setting_configcheckbox('block_alerts/staffonly',
            get_string('staffonly', 'block_alerts'), '', 0);
        $settings->add($setting);

        // Title.
        $setting = new admin_setting_configtext('block_alerts/title',
            get_string('title', 'block_alerts'),
            '',
            $default,
            PARAM_RAW,
            '60'
        );
        $settings->add($setting);

        // Description.
        $setting = new admin_setting_configtext('block_alerts/description',
            get_string('description', 'block_alerts'),
            get_string('description_help', 'block_alerts'),
            $default,
            PARAM_RAW,
            '60'
        );
        $settings->add($setting);

        // Link.
        $setting = new admin_setting_configtext('block_alerts/link',
            get_string('link', 'block_alerts'),
            get_string('link_help', 'block_alerts'),
            $default,
            PARAM_RAW,
            '60'
        );
        $settings->add($setting);

        // Link text.
        $setting = new admin_setting_configtext('block_alerts/linktext',
            get_string('linktext', 'block_alerts'),
            get_string('linktext_help', 'block_alerts'),
            $default,
            PARAM_RAW,
            '60'
        );
        $settings->add($setting);

    }
}

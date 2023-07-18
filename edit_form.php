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
 * Block definition class for the block_alerts plugin.
 *
 * @package   block_alerts
 * @copyright 2023 Stuart Lamour
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_alerts_edit_form extends block_edit_form {

    /**
     * Edit form.
     *
     * @param \MoodleQuickForm $mform the form being built.
     */
    protected function specific_definition($mform) {

        // Fieldset.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Block title.
        $mform->addElement('text', 'config_title', get_string('blocktitle', 'block_alerts'));
        $mform->setType('config_title', PARAM_TEXT);

        // Link to config.
        $href = new moodle_url('/admin/settings.php?section=blocksettingalerts');
        $text = get_string('configurealerts', 'block_alerts');
        $mform->addElement('html', '<p><a href="'.$href.'" >'.$text.'</a></p>');
    }

}

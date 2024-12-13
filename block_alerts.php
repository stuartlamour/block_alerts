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
class block_alerts extends block_base {

    /**
     * Initialises the block.
     *
     * @return void
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_alerts');
    }

    /**
     * Gets the block settings.
     *
     * @return void
     */
    public function specialization() {
        // Check if the title is empty.
        if (!empty($this->config->title)) {
            $this->title = format_string($this->config->title, true, ['context' => $this->context]);
        } else {
            // Don't show the block title, unless one is set.
            $this->title = '';
        }
    }

    /**
     * Gets the block contents.
     *
     * @return stdClass - the block content.
     */
    public function get_content(): stdClass {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        $template = new stdClass();
        $template->alert = $this->fetch_alert();
        $itemcount = count($template->alert);

        // Hide the block when no content.
        if (!$itemcount) {
            return $this->content;
        }

        // Render from template.
        $this->content->text = $OUTPUT->render_from_template('block_alerts/content', $template);

        return $this->content;
    }

    /**
     * Return if user has archetype editingteacher.
     *
     */
    public static function is_teacher(): bool {
        global $DB, $USER;
        // Get id's from role where archetype is editingteacher.
        $roles = $DB->get_fieldset('role', 'id', ['archetype' => 'editingteacher']);

        // Check if user has editingteacher role on any courses.
        list($roles, $params) = $DB->get_in_or_equal($roles, SQL_PARAMS_NAMED);
        $params['userid'] = $USER->id;
        $sql = "SELECT id
                FROM {role_assignments}
                WHERE userid = :userid
                AND roleid $roles";
        return  $DB->record_exists_sql($sql, $params);
    }

    /**
     *  Get the alerts.
     *
     * @return array alerts items.
     */
    public function fetch_alert(): array {
        // Staff only check.
        if (get_config('block_alerts', 'staffonly')) {
            if (!self::is_teacher()) {
                return []; // Don't ouput for learners.
            }
        }

        // Template data for mustache.
        $template = new stdClass();

        // Get alert content.
        $alert = new stdClass();
        $alert->staffonly = get_config('block_alerts', 'staffonly');
        $alert->title = get_config('block_alerts', 'title');
        $alert->description = get_config('block_alerts', 'description');
        $alert->link = get_config('block_alerts', 'link');
        $alert->linktext = get_config('block_alerts', 'linktext');

        // Check alerts is populated.
        if ($alert->title) {
            $template->alert[] = $alert;
            return $template->alert;
        }

        // Return if no alerts.
        if (!isset($template->alert)) {
            return [];
        }
    }

    /**
     * Defines on which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats(): array {
        return [
            'admin' => false,
            'site-index' => true,
            'course-view' => false,
            'mod' => false,
            'my' => true,
        ];
    }

    /**
     * Defines if the block can be added multiple times.
     *
     * @return bool.
     */
    public function instance_allow_multiple(): bool {
        return true;
    }

    /**
     * Defines if the has config.
     *
     * @return bool.
     */
    public function has_config(): bool {
        return true;
    }
}


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
        }
    }

    /**
     * Gets the block contents.
     *
     * @return stdClass - the block content.
     */
    public function get_content() : stdClass {
        global $OUTPUT;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass();
        $this->content->footer = '';

        $template = new stdClass();
        $template->alerts = $this->fetch_alerts();
        $itemcount = count($template->alerts);

        // Hide the block when no content.
        if (!$itemcount) {
            return $this->content;
        }

        // Set flag if we need to show navigation (when more than one alert).
        if ($itemcount > 1) {
            $template->nav = true;
        }

        // Render from template.
        $this->content->text = $OUTPUT->render_from_template('block_alerts/content', $template);

        return $this->content;
    }

    /**
     *  Get the alerts.
     *
     * @return array alerts items.
     */
    public function fetch_alerts() : array {
        // Template data for mustache.
        $template = new stdClass();

        // Get alerts items.
        for ($i = 1; $i < 4; $i++) {
            $alerts = new stdClass();
            $alerts->description = get_config('block_alerts', 'description'.$i);
            $alerts->title = get_config('block_alerts', 'title'.$i);
            $alerts->date = get_config('block_alerts', 'date'.$i);
            $alerts->link = get_config('block_alerts', 'link'.$i);
            $alerts->linktext = get_config('block_alerts', 'linktext'.$i);

            // Check alerts is populated.
            if ($alerts->title) {
                // Format the date for display.
                if ($alerts->date) {
                    $alerts->displaydate = date_format(date_create($alerts->date), "jS M Y");
                }

                // Make a temp key value array to sort.
                // NOTE - index added to make keys unique.
                $template->tempalerts[$alerts->date.'-'.$i] = $alerts;
            }
        }

        // Return if no alerts.
        if (!isset($template->tempalerts)) {
            return array();
        }

        // Sort alerts items by date for output.
        krsort($template->tempalerts);

        // Add sorted array to template.
        foreach ($template->tempalerts as $alerts) {
            $template->alerts[] = $alerts;
        }

        // Set first element as active for carousel version.
        $template->alerts[0]->active = true;

        return $template->alerts;
    }

    /**
     * Defines on which pages this block can be added.
     *
     * @return array of the pages where the block can be added.
     */
    public function applicable_formats() : array {
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
    public function instance_allow_multiple() : bool {
        return true;
    }

    /**
     * Defines if the has config.
     *
     * @return bool.
     */
    public function has_config() : bool {
        return true;
    }
}


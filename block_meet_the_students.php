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
 * Meet the Students block
 *
 * @package    block_meet_the_students
 * @copyright  2014 GetSmarter {@link http://www.getsmarter.co.za}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This class overrides some block properties and generates the block content
 *
 * @package    block_meet_the_students
 * @copyright  2014 GetSmarter {@link http://www.getsmarter.co.za}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_meet_the_students extends block_base {

    /**
     * Initialize the block
     */
    public function init() {
        $this->title = get_string('pluginname', 'block_meet_the_students');
    }

    /**
     * Check if block has config
     */
    public function has_config() {
        return true;
    }

    /**
     * Check block formats
     */
    public function applicable_formats() {
        return array('course' => true);
    }

    /**
     * Block title
     */
    public function specialization() {
        if (isset($this->config->title)) {
            $this->title = format_string($this->config->title);
        } else {
            $this->title = format_string(get_string('pluginname', 'block_meet_the_students'));
        }
    }

    /**
     * Allow multiple blocks
     */
    public function instance_allow_multiple() {
        return true;
    }

    /**
     * Generate block content
     */
    public function get_content() {
        global $OUTPUT, $PAGE, $CFG;

        require_once($CFG->libdir . '/filelib.php');

        if ($this->content !== null) {
            return $this->content;
        }

        $context = context_course::instance($PAGE->course->id);
        $canviewuserdetails = has_capability('moodle/user:viewdetails', $context);

        // Render block contents.
        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->text .= html_writer::start_tag('div', array('class' => 'meet_the_students'));

        if ($canviewuserdetails) {
            $this->content->text .= $this->render_user_pictures($context);
        } else {
            $this->content->text .= html_writer::tag('p', get_string('cannotviewuserdetails', 'block_meet_the_students'));
        }

        $this->content->text .= html_writer::end_tag('div');

        if ($canviewuserdetails) {
            $meetallstudentsurl = new moodle_url('/user/index.php', array('contextid' => $context->id));
            $text = get_string('meetall', 'block_meet_the_students');
            $meetallstudentsanchor = html_writer::empty_tag('img', array('src' => $OUTPUT->pix_url('i/users'), 'alt' => $text));
            $meetallstudentsanchor .= ' ' . $text;
            $this->content->footer = html_writer::link($meetallstudentsurl, $meetallstudentsanchor);
        }

        return $this->content;
    }

    /**
     * Render user profile pictures
     * @param object $context the context
     */
    protected function render_user_pictures($context) {
        global $OUTPUT, $USER;

        // Get block settings or defaults.
        $config = get_config('block_meet_the_students'); // Defaults.
        $onlywithrole = isset($this->config->onlywithrole) ? $this->config->onlywithrole : $config->onlywithrole;
        $onlywithpic = isset($this->config->onlywithpic) ? $this->config->onlywithpic : $config->onlywithpic;
        $numcolumns = (isset($this->config->numcolumns) ? $this->config->numcolumns : $config->numcolumns) + 1;
        $numrows = (isset($this->config->numrows) ? $this->config->numrows : $config->numrows) + 1;
        $maxusers = $numcolumns * $numrows;
        $style = 'width: ' . round(100 / $numcolumns, 2) . '%;';

        // Get the users to display.
        // Only users with specific role.
        if ($onlywithrole > 0) {
            $users = get_role_users($onlywithrole, $context);
        } else {
            $users = get_enrolled_users($context);
        }

        // Remove own profile.
        unset($users[$USER->id]);

        // Only users with profile pictures.
        if ($onlywithpic) {
            $tempusers = array();
            foreach ($users as $value) {
                if ($value->picture != '0') {
                    $tempusers[] = $value;
                }
            }
            $users = $tempusers;
        }

        // Order by last access.
        usort($users, function ($a, $b) {
            if ($a->lastaccess == $b->lastaccess) {
                return 0;
            } else {
                return ($a->lastaccess < $b->lastaccess) ? 1 : -1;
            }
        });

        // Render profiles.
        $html = '';
        $numusers = count($users);
        for ($i = 0; $i < $maxusers && $i < $numusers; $i++) {

            $html .= html_writer::start_tag('div', array('class' => 'user_icon', 'style' => $style));
            $html .= $OUTPUT->user_picture($users[$i], array('size' => 100, 'class' => 'user_picture'));
            $html .= html_writer::end_tag('div');
        }
        return $html;
    }
}

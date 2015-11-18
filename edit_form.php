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
 * Edit block page
 *
 * @package    block_meet_the_students
 * @copyright  2014 GetSmarter {@link http://www.getsmarter.co.za}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * This class adds custom form fields
 *
 * @package    block_meet_the_students
 * @copyright  2014 GetSmarter {@link http://www.getsmarter.co.za}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class block_meet_the_students_edit_form extends block_edit_form {

    /**
     * Add form fields specific to this block
     * @param object $mform the form being built
     */
    protected function specific_definition($mform) {
        global $DB;
        $config = get_config('block_meet_the_students');

        // Heading.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        // Title.
        $mform->addElement('text', 'config_title', get_string('name'));
        $mform->setType('config_title', PARAM_TEXT);
        $mform->setDefault('config_title', get_string('pluginname', 'block_meet_the_students'));

        // Columns.
        $options = array(1, 2, 3, 4, 5);
        $mform->addElement('select', 'config_numcolumns', get_string('numcolumns', 'block_meet_the_students'), $options);
        $mform->setDefault('config_numcolumns', $config->numcolumns);

        // Rows.
        $options = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
        $mform->addElement('select', 'config_numrows', get_string('numrows', 'block_meet_the_students'), $options);
        $mform->setDefault('config_numrows', $config->numcolumns);

        // Only with pic.
        $mform->addElement('advcheckbox', 'config_onlywithpic', get_string('onlywithpic', 'block_meet_the_students'));
        $mform->setDefault('config_onlywithpic', $config->onlywithpic);

        // Only with specific role.
        $roles = get_assignable_roles(context_course::instance(1));
        $roles[0] = 'All';
        $mform->addElement('select', 'config_onlywithrole', get_string('onlywithrole', 'block_meet_the_students'), $roles);
        $mform->setDefault('config_onlywithrole', $config->onlywithrole);
    }
}

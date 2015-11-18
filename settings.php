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
 * Default settings page
 *
 * @package    block_meet_the_students
 * @copyright  2014 GetSmarter {@link http://www.getsmarter.co.za}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $name = 'block_meet_the_students/numcolumns';
    $title = get_string('numcolumns', 'block_meet_the_students');
    $description = get_string('numcolumnsdesc', 'block_meet_the_students');
    $default = 2;
    $choices = array(1, 2, 3, 4, 5);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    $name = 'block_meet_the_students/numrows';
    $title = get_string('numrows', 'block_meet_the_students');
    $description = get_string('numrowsdesc', 'block_meet_the_students');
    $default = 3;
    $choices = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20);
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);

    $name = 'block_meet_the_students/onlywithpic';
    $title = get_string('onlywithpic', 'block_meet_the_students');
    $description = get_string('onlywithpicdesc', 'block_meet_the_students');
    $default = 1;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $settings->add($setting);

    $name = 'block_meet_the_students/onlywithrole';
    $title = get_string('onlywithrole', 'block_meet_the_students');
    $description = get_string('onlywithroledesc', 'block_meet_the_students');
    $default = '0';
    $choices = get_assignable_roles(context_course::instance(1));
    $choices[0] = 'All';
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $settings->add($setting);
}

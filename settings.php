<?php

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    $settings->add(new admin_setting_configselect('block_meet_the_students/numcolumns', get_string('numcolumns', 'block_meet_the_students'),
                    get_string('numcolumnsdesc', 'block_meet_the_students'), 2, array(1, 2, 3, 4, 5)));

    $settings->add(new admin_setting_configselect('block_meet_the_students/numrows', get_string('numrows', 'block_meet_the_students'),
                    get_string('numrowsdesc', 'block_meet_the_students'), 3, array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20)));
    
    $settings->add(new admin_setting_configcheckbox('block_meet_the_students/onlywithpic', get_string('onlywithpic', 'block_meet_the_students'),
                       get_string('onlywithpicdesc', 'block_meet_the_students'), 1));
    // get user roles
    $roles=$DB->get_records('role');
    $userroles = array();
    $default= "All";
    $userroles[0] = $default;
    // create an array of roles for select box
    foreach($roles as $r){
    	$userroles[$r->id] = $r->shortname;
    }
    $settings->add(new admin_setting_configselect('block_meet_the_students/onlywithrole', get_string('onlywithrole', 'block_meet_the_students'),
                    get_string('onlywithroledesc', 'block_meet_the_students'), '0',  $userroles));
}
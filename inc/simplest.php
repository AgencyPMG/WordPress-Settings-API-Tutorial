<?php
/**
 * The simplest example of the settings API
 *
 * @since       1.0
 * @author      Christopher Davis <http://pmg.co/people/chris>
 * @copyright   Performance Media Group 2012
 * @license     GPLv2
 */


// Hook into admin init to use all the settings API functions
add_action('admin_init', 'pmgtut_simple_settings_register');
/**
 * Hooked into `admin_init` this is the central function that takes care of 
 * registering the setting, addint sections and adding fields
 *
 * @since   1.0
 * @uses    register_setting
 * @uses    add_settings_section
 * @uses    add_settings_field
 */
function pmgtut_simple_settings_register()
{
    // our setting name
    $name = 'pmgtut_setting_simple';

    // our settings page, we're going to add options to the "general" page
    $page = 'general';

    // The section to which we'll add things
    $section = 'default';

    // `register_setting is the central call.  This Let's WP know about your
    // setting.  You **MUST** call this first
    register_setting($page, $name, 'pmgtut_simple_validator');

    // at this point WP knows about your setting.
    // Lets add a new field field to the default section
    add_settings_field(
        'pmg-example-simple', // field ID not used for much
        __('Simple Field', 'pmg'), // the label for our field
        'pmgtut_simple_field_cb', // this is the callback function
        $page, // page to place our field on
        $section // section to place our field in
    );
}


/**
 * Validation callback function.  Makes sure we have an email address or adds
 * a settings error to give the user feedback.
 *
 * @since   1.0
 * @uses    add_settings_error
 * @uses    is_email
 * @return  string The email or an empty string
 */
function pmgtut_simple_validator($value)
{
    if(is_email($value))
    {
        // we have a valid email, return it
        return $value;
    }

    // not a valid email.  Add a settings error.
    add_settings_error(
        'pmgtut_setting_simple', // setting name
        'pmgtut-no-email', // Code, used int he ID att of the error
        __('Please enter a valid email', 'pmg'), // error message
        'error' // type of error: updated?  error, in this case
    );

    // return an empty string
    return '';
}


/**
 * the settings callback function.  This spits out the form field
 *
 * @since   1.0
 * @uses    get_option
 */
function pmgtut_simple_field_cb()
{
    // Name of our setting, same as we registered
    $setting = 'pmgtut_setting_simple';

    // step one: get the value in our option with get_option
    $val = get_option($setting, '');

    // spit out the form field
    printf(
        '<input type="text" class="regular-text" name="%1$s" id="%1$s" value="%2$s" />',
        esc_attr($setting),
        esc_attr($val)
    );
}

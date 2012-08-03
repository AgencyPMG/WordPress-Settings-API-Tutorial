<?php
/**
 * An example of using the settings API with only functions
 *
 * @since       1.0
 * @author      Christopher Davis <http://pmg.co/people/chris>
 * @copyright   Performance Media Group 2012
 * @license     GPLv2
 */

// Hook into admin init to use all the settings API functions
add_action('admin_init', 'pmgtut_settings_register');
/**
 * Hooked into `admin_init` this is the central function that takes care of 
 * registering the setting, adding sections, and adding fields
 *
 * @since   1.0
 * @uses    register_setting
 * @uses    add_settings_section
 * @uses    add_settings_field
 */
function pmgtut_settings_register()
{
    // our setting name
    $name = 'pmgtut_setting';

    // our settings page, we're going to add options to the "general" page
    $page = 'general';

    // The name of our section
    $section = 'example-section';

    // `register_setting is the central call.  This Let's WP know about your
    // setting.  You **MUST** call this first
    register_setting($page, $name, 'pmgtut_validator');

    // at this point WP knows about your setting.
    // Lets add a new section
    add_settings_section(
        $section, // our section id
        __('Example Section', 'pmg'), // the title.  Gets put in an <h3> in the admin area
        'pmgtut_section_cb', // name of our callback function.
        $page // what page the section lives on
    );

    // We've now registered our setting and section.  Add the fields!
    
    /* Example of adding fields with separate callbacks
    add_settings_field(
        'email-field', // field id
        __('Your Email', 'pmg'), // field label
        'pmgtut_email_field_cb', // field callback
        $page, // option page/group
        $section // settings section
    );

    add_settings_field(
        'normal-text-field',
        __('Some Text', 'pmg'),
        'pmgtut_normal_field_cb',
        $page,
        $section
    );
     */

    // unified callback
    $fields = array(
        'email'  => __('Your Email', 'pmg'),
        'normal' => __('Some Text', 'pmg')
    );

    foreach($fields as $key => $label)
    {
        add_settings_field(
            $key,
            $label,
            'pmgtut_field_cb',
            $page,
            $section,
            array('key' => $key) // option args
        );
    }
}


/**
 * settings validation callback
 *
 * @since   1.0
 * @uses    add_settings_error
 * @uses    esc_attr
 * @uses    is_email
 * @return  array The cleaned options
 */
function pmgtut_validator($dirty)
{
    $clean = array();

    if(isset($dirty['email']) && is_email($dirty['email']))
    {
        // hooray email!
        $clean['email'] = $dirty['email'];
    }
    else
    {
        add_settings_error(
            'pmgtut_setting',
            'pmg-invalid-email',
            __('Please enter a valid email', 'pmg'),
            'error'
        );
    }

    $clean['normal'] = isset($dirty['normal']) ? esc_attr($dirty['normal']) : '';

    return $clean;
}


/**
 * Section callback function.  Can be used to spit out some help text or
 * whatever you like.
 *
 * @since   1.0
 * @uses    esc_html__
 * @return  null
 */
function pmgtut_section_cb()
{
    echo '<p class="description">' . esc_html__('Help text here', 'pmg') . '</p>';
}


/**
 * Callback function for our email field
 *
 * @since   1.0
 * @uses    get_option
 */
function pmgtut_email_field_cb()
{
    // variable to use later
    $setting = 'pmgtut_setting';
    $field = 'email';

    // get our options
    $opts = get_option($setting, array());

    // Set up the value with a ternary statment
    $val = isset($opts[$field]) ? $opts[$field] : '';

    // actually print the field
    printf(
        '<input type="text" class="regular-text" id="%1$s[%2$s]" name="%1$s[%2$s]" value="%3$s" />',
        esc_attr($setting),
        esc_attr($field),
        esc_attr($val)
    );
}


/**
 * Callback function for our normal text field
 *
 * @since   1.0
 * @uses    get_option
 */
function pmgtut_normal_field_cb()
{
    $setting = 'pmgtut_setting';
    $field = 'normal';

    // get our options
    $opts = get_option($setting, array());

    // Set up the value with a ternary statment
    $val = isset($opts[$field]) ? $opts[$field] : '';

    // actually print the field
    printf(
        '<input type="text" class="regular-text" id="%1$s[%2$s]" name="%1$s[%2$s]" value="%3$s" />',
        esc_attr($setting),
        esc_attr($field),
        esc_attr($val)
    );
}


/**
 * Example of a unified callback
 *
 * @since   1.0
 * @uses    get_option
 */
function pmgtut_field_cb($args)
{
    // settings name
    $setting = 'pmgtut_setting';

    // get our options
    $opts = get_option($setting, array());

    // Set up the value with a ternary statment
    $val = isset($opts[$args['key']]) ? $opts[$args['key']] : '';

    // actually print the field
    printf(
        '<input type="text" class="regular-text" id="%1$s[%2$s]" name="%1$s[%2$s]" value="%3$s" />',
        esc_attr($setting),
        esc_attr($args['key']),
        esc_attr($val)
    );
}

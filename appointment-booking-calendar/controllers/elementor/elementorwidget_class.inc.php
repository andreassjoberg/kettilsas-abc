<?php
/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Elementor_CPABC_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'Appointment Booking Calendar';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return 'Appointment Booking Calendar';
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-calendar';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'codepeople-widgets' ];
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

        global $wpdb;
        
		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Insert Appointment Booking Calendar', 'appointment-booking-calendar' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

        
        $forms = array();
        $rows = $wpdb->get_results("SELECT id,uname FROM ".CPABC_APPOINTMENTS_CONFIG_TABLE_NAME." ORDER BY uname");
        foreach ($rows as $item)
           $forms[$item->id] = $item->uname;
                
		$this->add_control(
			'formid',
			[
				'label' => __( 'Select Appointment Calendar', 'appointment-booking-calendar' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
				'options' => $forms,
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        global $cp_cfte_plugin;

        
        $settings = $this->get_settings_for_display();
        $id = $settings["formid"];       
        
        if ( ! \Elementor\Plugin::instance()->editor->is_edit_mode() ) 
        {
            echo cpabc_appointments_filter_content( array("calendar" => $id) );
            return;
        } 
        else
        {
            define('ABC_ELEMENTOR_EDIT_MODE', true);
            echo '<fieldset class="ahbgutenberg_editor" disabled>';
            echo cpabc_appointments_filter_content( array("calendar" => $id) );
            echo '</fieldset>';
        }

	}

}

\Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Elementor_CPABC_Widget());
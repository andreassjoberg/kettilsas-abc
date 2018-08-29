( function( blocks, element ) {
    var el = wp.element.createElement,
    source 		= blocks.source,
	InspectorControls = blocks.InspectorControls,
	category 	= {slug:'appointment-booking-calendar', title : 'Appointment Booking Calendar'};
    
    /* Plugin Category */
    blocks.getCategories().push({slug: 'cpabc', title: 'Appointment Booking Calendar'})    
    
    blocks.registerBlockType( 'cpabc/appointment-booking-calendar', {
        title: 'Appointment Booking Calendar', 
        icon: 'calendar-alt',    
        category: 'cpabc',
        supports: {
			customClassName: false,
			className: false
		},
		attributes: {
			shortcode : {
				type : 'string',
				source : 'text',
				default: '[CPABC_APPOINTMENT_CALENDAR]'
			}
		},        
    
		edit: function( props ) {
			var focus = props.focus;
			return [
				!!focus && el(
					InspectorControls,
					{
						key: 'cpabc_inspector'
					},
					[
						el(
							'span',
							{
								key: 'cpabc_inspector_help',
								style:{fontStyle: 'italic'}
							},
							'If you need help: '
						),
						el(
							'a',
							{
								key		: 'cpabc_inspector_help_link',
								href	: 'https://abc.dwbooster.com/contact-us',
								target	: '_blank'
							},
							'CLICK HERE'
						),
					]
				),
				el('textarea',
					{
						key: 'cpabc_form_shortcode',
						value: props.attributes.shortcode,
						onChange: function(evt){
							props.setAttributes({shortcode: evt.target.value});
						},
						style: {width:"100%", resize: "vertical"}
					}
				)
			];
		},
    
		save: function( props ) {
			return props.attributes.shortcode;
		},
    } );

} )(
	window.wp.blocks,
	window.wp.element
);
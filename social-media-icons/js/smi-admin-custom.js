/* In settings preview, remove min width when border or background removed */
function preview_change() {
	setTimeout( function() {
		var border_width = jQuery( ".smi-metabox #smi_border_width" ).val();
		var icon_bg_color = jQuery( '.smi-metabox #smi_icons_bg_color' ).val();
		var icons_bg_hover_color = jQuery( '.smi-metabox #smi_icons_bg_hover_color' ).val();
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-width', jQuery( '.smi-metabox #smi_font_size' ).val() + 'px' );
		if ( '0' === border_width  && ( '' === icon_bg_color || 'transparent' === icon_bg_color ) && ( '' === icons_bg_hover_color || 'transparent' === icons_bg_hover_color ) ) {
			jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-width', 'unset' );
		}
	}, 100 );
}

jQuery( document ).ready( function() {

	/* For add multiple icons */
	jQuery( document ).on( 'click', '.smi-metabox .smi-add-icon', function() {
		var nonce = jQuery( this ).attr( "data-nonce" );
		var icon_ids_arr = [];
		var last_added_id = 0;

		/* Get latest added count number (higest count number) of icon */
		if ( jQuery( '.smi-metabox .multi-field-container .multi-field-group' ).length ) {
			jQuery( '.smi-metabox .multi-field-container .multi-field-group' ).each( function() {
			    var id = jQuery( this ).attr( 'data-count' );
			    icon_ids_arr.push( id );
			  } );
		    icon_ids_arr = icon_ids_arr.sort();
		    last_added_id = Math.max.apply( Math, icon_ids_arr );
		}

		var counter = parseInt( last_added_id ) + 1;

		jQuery.ajax( {
	        url: smi_admin_custom.ajaxurl,
	        type: 'POST',
	        data: {
	            action: 'smi_add_icon',
	            nonce: nonce,
	            counter: counter
	        }
	    } )
	    .done( function( response_str ) {
	        jQuery( '.smi-metabox .multi-field-container' ).append( response_str );
	        jQuery( '.smi-preview .smi-preview-wrapper ul' ).append( '<li data-id="'+ counter +'"></li>' );
	    } );
	} );

	/* Close icon's popup */
	jQuery( document ).on( 'click', '.smi-icon-list .close-icon', function( e ) {
		jQuery( '.smi-icon-list' ).hide();
	} );
		
	/* Open icon's popup box to select icon */
	jQuery( document ).on( 'click', '.smi-metabox .smi-select-icon', function( e ) {
		e.preventDefault();
		var count = jQuery( this ).parents( '.multi-field-group' ).attr( 'data-count' );
		jQuery( '.smi-icon-list' ).attr( 'data-smi', count );
		jQuery( '.smi-icon-list' ).toggle();
	} );

	/* Select icon from list */
	jQuery( document ).on( 'click', '.smi-icon-list ul li', function( e ) {
		e.preventDefault();
		var icon_label = jQuery( this ).text();
		var icon = jQuery( this ).find( 'i' ).attr( 'class' );
		var icon_num = jQuery( this ).parents( '.smi-icon-list' ).attr( 'data-smi' );

		var icon_element = jQuery( '.smi-metabox .multi-field-group[data-count='+ icon_num +']' );
		jQuery( '.smi-icon-list' ).hide();

		icon_element.find( 'input.smi-icon' ).val( icon );
		icon_element.find( "input[type=text]" ).val( icon_label );
		icon_element.find( ".icon-preview" ).html( "<i class='" + icon + "'></i>" );
		icon_element.find( ".icon-type" ).val( "icon" );

		/* For icons preview */
		if ( jQuery( '.smi-preview .smi-preview-wrapper ul li[data-id='+ icon_num +']' ).length ) {
			jQuery( '.smi-preview .smi-preview-wrapper ul li[data-id='+ icon_num +']' ).html( '<i class="' + icon + '"></i>' );
		} else {
			jQuery( '.smi-preview .smi-preview-wrapper ul' ).append( '<li data-id="'+ parseInt( icon_num ) +'"><i class="' + icon + '"></i></li>' );
		}
	} );

	/* Search icon from icon list */
	jQuery( document ).on( "keyup", ".smi-icon-list .smi-icon-search input", function() {
	  var value = this.value.toLowerCase().trim();
	  jQuery( ".smi-icon-list ul li" ).show().filter( function() {
	    return jQuery( this ).text().toLowerCase().trim().indexOf( value ) == -1;
	  } ).hide();
	} );

	/* Remove icon fields group */
	jQuery( document ).on( "click", ".smi-metabox .multi-field-group .smi-remove-icon", function() {
		var icon_num = jQuery( this ).parent().attr( "data-count" );
		jQuery( this ).parent().remove();
		jQuery( '.smi-preview .smi-preview-wrapper ul li[data-id='+ icon_num +']' ).remove();
	} );

	/* Upload social media icon image */
    jQuery( document ).on( 'click', '.smi-upload-icon-img', function( e ) {
        e.preventDefault();
        var _this = jQuery( this );
        var smi_uploader = wp.media( {
            title: 'Icon Image',
            button: {
                text: 'Use this icon image'
            },
            multiple: false
        } ).on( 'select', function() {
            var attachment = smi_uploader.state().get( 'selection' ).first().toJSON();
            if ( null !== attachment.url && undefined !== attachment.url && '' !== attachment.url ) {
	            _this.parent().find( 'input' ).val( attachment.url );
	            _this.parents( '.icon-selection-field' ).find( ".icon-preview" ).html( "<img src='" + attachment.url + "'>" );
	            _this.parents( '.icon-selection-field' ).find( ".icon-type" ).val( "image" );

	            /* For icons preview */
	            var icon_num = _this.parents( '.multi-field-group' ).attr( "data-count" );
				if ( jQuery( '.smi-preview .smi-preview-wrapper ul li[data-id=' + icon_num + ']' ).length ) {

					if ( ! jQuery( '.smi-preview .smi-preview-wrapper ul li[data-id=' + icon_num + ']' ).hasClass( 'icon-image' ) ) {
						jQuery( '.smi-preview .smi-preview-wrapper ul li[data-id=' + icon_num + ']' ).addClass( 'icon-image' );
					}
					jQuery( '.smi-preview .smi-preview-wrapper ul li[data-id=' + icon_num + ']' ).html( '<img src="' + attachment.url + '">' );
				} else {
					jQuery( '.smi-preview .smi-preview-wrapper ul' ).append( '<li class="icon-image" data-id="' + parseInt( icon_num ) + '"><img src="' + attachment.url + '"></li>' );
				}
            }
        } )
        .open();
    } );

    /* Color picker in metafield */
    jQuery( '.smi-color-field' ).each( function() {
		jQuery( this ).wpColorPicker( {
	   		change: function( event, ui ) {
	   			/* Apply color to all icons in preview */
	   			if ( undefined !== ui.color && undefined !== ui.color.toString() ) {
	   				var _element = jQuery( this ).attr( 'id' );
	   				if ( 'smi_icons_color' === _element ) {
	   					jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-color', ui.color.toString() );
		   			} else if ( 'smi_hover_color' === _element ) {
	   					jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-hover-color', ui.color.toString() );
		   			} else if ( 'smi_icons_bg_color' === _element ) {
	   					jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-bg-color', ui.color.toString() );
	   					preview_change();
		   			} else if ( 'smi_icons_bg_hover_color' === _element ) {
		   				preview_change();
	   					jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-bg-hover-color', ui.color.toString() );
		   			} else if ( 'smi_border_color' === _element ) {
		   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-border-color', ui.color.toString() );
		   			} else if ( 'smi_border_hover_color' === _element ) {
		   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-border-hover-color', ui.color.toString() );
		   			}
	   			}
	   		},
	   		clear: function( _event ) {
	   			/* Apply clear event to all icons in preview */
	   			var _element = ( undefined !== event.target.parentNode ) ? jQuery( event.target.parentNode ).find( '.smi-color-field' ).attr( 'id' ) : '';
	   			if ( 'smi_icons_color' === _element ) {
	   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-color', 'unset' );
	   			} else if ( 'smi_hover_color' === _element ) {
	   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-hover-color', 'unset' );
	   			} else if ( 'smi_icons_bg_color' === _element ) {
	   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-bg-color', 'unset' );
	   				preview_change();
	   			} else if ( 'smi_icons_bg_hover_color' === _element ) {
	   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-bg-hover-color', 'unset' );
	   				preview_change();
	   			} else if ( 'smi_border_color' === _element ) {
	   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-border-color', 'unset' );
	   			} else if ( 'smi_border_hover_color' === _element ) {
	   				jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-border-hover-color', 'unset' );
	   			}
	   		},
	   	} );
	} );

	/* Apply icon size to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_font_size", function() {
		var font_size = jQuery( this ).val();
		font_size = ( '' !== font_size ) ? font_size : 0;
		jQuery( this ).val( font_size );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-font-size', font_size + 'px' );
		if ( 0 !== jQuery( '.smi-metabox #smi_border_width' ).val() ) {
			jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-width', font_size + 'px' );
		}
	} );

	/* Apply column gap to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_column_gap", function() {
		var column_gap = jQuery( this ).val();
		column_gap = ( '' !== column_gap ) ? column_gap : 0;
		jQuery( this ).val( column_gap );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-column-gap', column_gap + 'px' );
	} );

	/* Apply row gap to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_row_gap", function() {
		var row_gap = jQuery( this ).val();
		row_gap = ( '' !== row_gap ) ? row_gap : 0;
		jQuery( this ).val( row_gap );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-row-gap', row_gap + 'px' );
	} );

	/* Apply border width to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_border_width", function() {
		var border_width = jQuery( this ).val();
		border_width = ( '' !== border_width ) ? border_width : 0;
		jQuery( this ).val( border_width );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-border-width', border_width + 'px' );
		preview_change();
	} );

	/* Apply border radius to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_border_radius", function() {
		var border_radius = jQuery( this ).val();
		border_radius = ( '' !== border_radius ) ? border_radius : 0;
		jQuery( this ).val( border_radius );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-border-radius', border_radius + '%' );
	} );

	/* Apply padding top to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_padding_top", function() {
		var padding_top = jQuery( this ).val();
		padding_top = ( '' !== padding_top ) ? padding_top : 0;
		jQuery( this ).val( padding_top );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-padding-top', padding_top + 'px' );
	} );

	/* Apply padding right to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_padding_right", function() {
		var padding_right = jQuery( this ).val();
		padding_right = ( '' !== padding_right ) ? padding_right : 0;
		jQuery( this ).val( padding_right );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-padding-right', padding_right + 'px' );
	} );

	/* Apply padding bottom to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_padding_bottom", function() {
		var padding_bottom = jQuery( this ).val();
		padding_bottom = ( '' !== padding_bottom ) ? padding_bottom : 0;
		jQuery( this ).val( padding_bottom );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-padding-bottom', padding_bottom + 'px' );
	} );

	/* Apply padding left to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_padding_left", function() {
		var padding_left = jQuery( this ).val();
		padding_left = ( '' !== padding_left ) ? padding_left : 0;
		jQuery( this ).val( padding_left );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-padding-left', padding_left + 'px' );
	} );

	/* Apply alignment to icons preview */
	jQuery( document ).on( "change", ".smi-metabox .smi_horizontal_alignment", function() {
		var alignment = jQuery( this ).val();
		var vertical_layout = jQuery( '.smi-metabox #smi_vertical_layout' ).is(':checked');
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-horizontal-alignment', ( true === vertical_layout ) ? 'unset' : alignment );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-vertical-alignment', ( true === vertical_layout ) ? alignment : 'unset' );
	} );

	/* Apply hover transition time to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_hover_transition_time", function() {
		var hover_transition_time = jQuery( this ).val();
		hover_transition_time = ( '' !== hover_transition_time ) ? hover_transition_time : 0;
		jQuery( this ).val( hover_transition_time );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-hover-transition-time', hover_transition_time + 's' );
	} );

	/* Apply vertical layout to icons preview */
	jQuery( document ).on( "change", ".smi-metabox #smi_vertical_layout", function() {
		var vertical_layout = jQuery( this ).is(':checked');
		var alignment = jQuery( '.smi-metabox .smi_horizontal_alignment:checked' ).val();
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-layout', ( true === vertical_layout ) ? 'column' : 'row' );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-icons-wrap', ( true === vertical_layout ) ? 'no-wrap' : 'wrap' );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-vertical-alignment', ( true === vertical_layout ) ? alignment : 'unset' );
		jQuery( '.smi-preview .smi-preview-wrapper' )[0].style.setProperty( '--smi-horizontal-alignment', ( true === vertical_layout ) ? 'unset' : alignment );
	} );

	/* Drag and drop icon to change order of icons. */
	jQuery( ".smi-metabox .multi-field-container" ).sortable( {
        change: function( event, ui ) {
            var icon_num = ui.item.data( 'count' );
            var index = ui.placeholder.index();
        	if ( 0 === index ) {
            	jQuery( '.smi-preview .smi-preview-wrapper ul' ).prepend( jQuery( ".smi-preview .smi-preview-wrapper ul li[data-id=" + icon_num + "]" ) );
        	} else {
            	jQuery( ".smi-preview .smi-preview-wrapper ul li[data-id=" + icon_num + "]" ).insertAfter( ".smi-preview .smi-preview-wrapper ul li:nth-child(" + index + ")" );
        	}
        }
    } );

} );



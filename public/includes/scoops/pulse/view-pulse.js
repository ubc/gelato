var Gelato_Pulse = {
	form : null,
	init: function() {
		Gelato_Pulse.form = jQuery( '.pulse-form' );
		
		jQuery('<input />')
			.attr( 'type', 'hidden' )
			.attr( 'class', 'ss_synctime' )
			.attr( 'name', 'ss_synctime' )
			.appendTo( Gelato_Pulse.form );
		
		
		Gelato_Pulse.form.find( 'textarea').keyup( function() {
			
			Gelato_Media.pauseForModule();
		} );
		
		Gelato_Pulse.form.submit( function( e ) {
			console.log( Gelato_Media.media.roundTime());
			jQuery('.ss_synctime').val( Gelato_Media.media.roundTime() );
			Gelato_Media.playForModule();
		} );
	},
	
	onContentLoad: function() {
		if ( typeof CTLT_Stream != 'undefined' ) { // Check for stream activity
            CTLT_Stream.on( 'server-push', Gelato_Pulse.listen );
		}
		
		Gelato_Media.media.on( 'loadedmetadata', Gelato_Pulse.loadPulses );
		Gelato_Media.media.on( 'loadedmetadata', Gelato_Pulse.loadMarkers );
	},
    
    listen: function( data ) {
		if ( data.type == 'pulse' ) { // We are interested
			var pulse_data = jQuery.parseJSON(data.data);
			Gelato_Pulse.addPulse( pulse_data, pulse_data.synctime, true );
		}
    },
	
	loadMarkers: function() {
		
		if( typeof gelatoScoop.bookmarks != 'undefined') {
			for ( index in gelatoScoop.bookmarks.list ) {
				var bookmark = gelatoScoop.bookmarks.list[index];
				
				Gelato_Media.media.pulse( {
					start: bookmark.synctime,
					end: Gelato_Media.media.duration(),
					text: '<a class="bookmark" onclick="Gelato_Media.skipTo('+bookmark.synctime+');">'+bookmark.title+'<span class="time">'+bookmark.time+'</span></a>',
					sort: true,
					target: "pulse-list",
				} );
			}
		}
	},
	
	loadPulses: function() {
		var list = gelatoScoop.pulse;
		console.log(list);
		for ( index in list ) {
			Gelato_Pulse.addPulse( list[index], list[index].synctime, false );
		}
	},
	
	addPulse: function( data, start, sort ) {
		var new_pulse = Pulse_CPT_Form.single_pulse_template( data );
		
		Gelato_Media.media.pulse( {
			start: start,
			end: Gelato_Media.media.duration(),
			text: new_pulse,
			sort: sort,
			target: "pulse-list",
		} );
	},
}

Gelato_Pulse.init();
document.addEventListener( "DOMContentLoaded", Gelato_Pulse.onContentLoad, false );
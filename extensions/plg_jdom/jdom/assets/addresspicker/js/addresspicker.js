/*
* @name			Address Picker ByGiro jQuery plugin
* @version		0.0.1
* @package		jForms
* @copyright	G. Tomaselli
* @author		Girolamo Tomaselli - http://bygiro.com - girotomaselli@gmail.com
* @license		GNU GPL v3 or later
*/

// the semi-colon before function invocation is a safety net against concatenated
// scripts and/or other plugins which may not be closed properly.
;(function ( $, window, document, undefined ) {
	"use strict";
	
    var pluginName = "addressPickerByGiro",
    // the name of using in .data()
	dataPlugin = "plugin_" + pluginName,
	defaults = {				
		latitude: -17.75,
                longitude: 168.3,
                zoom: 6,
		mode: 'modal', /* modal or plain */
		map_options: {
			mapTypeId: google.maps.MapTypeId.ROADMAP
		},
		maxResultShow: 10,		
		labeledMarker: true, // utility library needed, see: http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerwithlabel
		markerLabelClass: "youarehere",
		
		// update input fields if CLASS provided
		targets_prefix: null,
		
		// internationalization
		language: 'en',
		text: {
			genericerror: "Sorry, something went wrong. Try again!",
			cancel: "Cancel",
			ok: "Ok",
			edit: "Edit",
			search: "Search",
			you_are_here: "You are here!",
			noresults: "Sorry! We couldn't find the address for the specified terms. Try a different search term, or click the map.",
			toofar: "Woah... that's pretty remote! You're going to have to manually enter a place name.",
			set_your_address: "Set your address",
			set_your_address_info: "You can search for an address or click on the map and drag the marker."
		},
		
		// callbacks
		onInit: false,
		onOpenModal: false,
		onCancelModal: false,
		onSuccess: false
	};

	var generateRandom = function(){
		var randomId ='',alfabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for (var i = 0; i < 7; i++){
			randomId += alfabet.charAt(Math.floor(Math.random() * alfabet.length));
		}

		return randomId;
	},
	
	addHTML = function () {
		switch(this.options.mode){
			case 'modal':
			var html = '';

				if(!this.options.isElementInput){
					// add an input text
					html += '<a id="'+ this.options.userInputId +'_edit" href="#" onclick="return false;" style="margin-left: 5px;" class="btn btn-primary btn-mini">'+ this.options.text.edit +'</a>';
				}
	
				html += '<div id="'+ this.options.userInputId +'_modal" style="width: 90%;left: 5%;margin-left:auto;margin-right:auto;height: 80%;" class="modal addresspicker hide fade '+ this.options.aPicker +'" tabindex="-1" role="dialog" aria-labelledby="'+ this.options.userInputId +'Label" aria-hidden="true">';
				html += '	<div class="modal-header">';
				html += '		<a href="#" onclick="return false;" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>';
				html += '		<h3 id="'+ this.options.userInputId +'Label">'+ this.options.text.set_your_address +'</h3>';
				html += '		<span class="info">'+ this.options.text.set_your_address_info +'</span>';
				html += '	</div>';
				html += '	<div class="modal-body" style="height: 100%;">';
				html += '  		<input autocomplete="off" id="'+ this.options.pickerInputId +'" style="width: 80%;"/>';
				html += '		<a id="'+ this.options.userInputId +'_search" href="#" onclick="return false;" class="btn btn-small btn-success">'+ this.options.text.search +'</a>';
				html += '		<br /><span id="'+ this.options.userInputId +'_error"></span>';
				html += '		<div class="map_container">';
				html += '			<div id="'+ this.options.userInputId +'_map_canvas" style="width:100%; height:100%"></div>';
				html += '		</div>';
				html += '	</div>';
				html += '	<div class="modal-footer">';
				html += '		<a href="#" onclick="return false;" class="btn" data-dismiss="modal" aria-hidden="true">'+ this.options.text.cancel +'</a>';
				html += '		<a id="'+ this.options.userInputId +'_ok" href="#" onclick="return false;" data-dismiss="modal" aria-hidden="true" class="btn btn-primary">'+ this.options.text.ok +'</a>';
				html += '	</div>';
				html += '</div>';
				break;
				
			case 'plain':
			default:
				this.options.$related.css('margin-bottom','0');
				
				var html = '';
				
				if(!this.options.isElementInput){
					// add an input text
					html += '<input type="text" value="" id="'+ this.options.userInputId +'" />';
				}
				
				html += '<a id="'+ this.options.userInputId +'_search" href="#" onclick="return false;" style="margin-left: 5px;" class="btn btn-small btn-success '+ this.options.aPicker +'">'+ this.options.text.search +'</a><br />';
				html += '<span class="info">'+ this.options.text.set_your_address_info +'</span>';
				html += '<span id="'+ this.options.userInputId +'_error '+ this.options.aPicker +'"></span>';
				html += '<div class="map_container '+ this.options.aPicker +'">';
				html += '<div id="'+ this.options.userInputId +'_map_canvas" style="width:100%; height:100%; min-height: 300px;"></div>';
				html += '</div>';
				break;
		}

		$(html).insertAfter(this.options.$related);
	},
	
	checkMapVisibility = function(){
		if($('#'+ this.options.userInputId +'_map_canvas').is(':visible')){
			this.resizeMap();
			this.options.map_visible = window.clearInterval(this.options.map_visible);
		}
	},

	initGmap = function(){	
		if(this.options.map_rendered == true){
			this.resizeMap();
			return;
		}
		var that = this;
		
		this.options.map_options.zoom = this.options.zoom;
		this.options.map_options.center = new google.maps.LatLng(this.options.latitude, this.options.longitude);		
	
		// create our map object
		this.options.map = new google.maps.Map(jQuery('body').find('#'+ this.options.userInputId +'_map_canvas').get(0), this.options.map_options);

		// the geocoder object allows us to do latlng lookup based on address
		this.options.geocoder = new google.maps.Geocoder();
		
		// the marker shows us the position of the latest address		
		if(this.options.labeledMarker && typeof MarkerWithLabel == 'function'){
			this.options.marker = new MarkerWithLabel({
				position: this.options.map_options.center,
				draggable: true,
				raiseOnDrag: true,
				map: this.options.map,
				labelContent: this.options.text.you_are_here,
				labelAnchor: new google.maps.Point(0, 0),
				labelClass: this.options.markerLabelClass, // the CSS class for the label
				labelStyle: {opacity: 1}
			 });
		} else {
			this.options.marker = new google.maps.Marker({
				position: this.options.map_options.center,
				map: this.options.map,
				draggable: true
			});
		}
		
		var currentAddress = $('#'+ this.options.userInputId).text();
		if(this.options.isElementInput){
			currentAddress = $('#'+ this.options.userInputId).val();
		}
		if(currentAddress != ''){
			this.geocodeLookup( 'address', currentAddress, true);
		}
		
		// event triggered when marker is dragged and dropped
		google.maps.event.addListener(this.options.marker, 'dragend', function() {
			that.geocodeLookup( 'latLng', that.options.marker.getPosition());
		});

		// event triggered when map is clicked
		google.maps.event.addListener(this.options.map, 'click', function(event) {
			that.options.marker.setPosition(event.latLng);
			that.geocodeLookup( 'latLng', event.latLng);
		});
				
		this.options.map_rendered = true;
	},
	
	// move the marker to a new location, and center the map on it
	update_map = function( geometry, latLng) {		
		latLng = (latLng) ? latLng : geometry.location;
		
		this.options.marker.setPosition( latLng );
		geometry.viewport.extend(latLng);
		this.options.map.fitBounds( geometry.viewport );
	},
	
	// update the UI elements with new location data
	update_ui = function( address, latLng , components ) {		
		this.options.location_components = new Object();

		for (var i = 0; i < components.length; i++) {
			var addr = components[i];
				if (addr.types[0] == 'country')	{ this.options.location_components.country = addr.long_name; this.options.location_components.country_code = addr.short_name; }
				if (addr.types[0] == 'administrative_area_level_1')	{ this.options.location_components.region = addr.long_name; this.options.location_components.region_code = addr.short_name; }
				if (addr.types[0] == 'administrative_area_level_2')	{ this.options.location_components.county = addr.long_name; this.options.location_components.county_code = addr.short_name; }
				if (addr.types[0] == 'locality')	{ this.options.location_components.city = addr.long_name; }
				if (addr.types[0] == 'sublocality')	{ this.options.location_components.city_district = addr.long_name; }
				if (addr.types[0] == 'postal_code')	{ this.options.location_components.zip = addr.long_name; }
				if (addr.types[0] == 'route')	{ this.options.location_components.street = addr.long_name; }
				if (addr.types[0] == 'street_number')	{ this.options.location_components.street_number = addr.long_name; }
		}

		this.options.location_components.formatted_address = this.options.location_components.country;
		this.options.location_components.latitude = '';
		this.options.location_components.longitude = '';
		if(typeof latLng == 'object'){
			/* round decimal digits on lat lon */
			this.options.location_components.latitude = Math.round(latLng.lat() *10000000)/10000000;
			this.options.location_components.longitude = Math.round(latLng.lng() *10000000)/10000000;		
		}

		/* update addresspicker input */
		$('#'+ this.options.pickerInputId).val(this.options.location_components.formatted_address);

		/* triggered only if we are in PLAIN mode */
		if(this.options.mode != 'modal'){
			this.updateFields();
			var evt = $.Event(this.options.event_success);
			this.options.$related.trigger(evt, this.options.location_components);
			
			if(typeof this.options.onSuccess == 'function'){
				this.options.onSuccess.call(this,this.options.event_success);
			}
		}
	},

	typeaheadAddresses = function(){
		if($.fn.typeahead == 'undefined'){
			return;
		}
		var that = this;
		$('#'+ this.options.userInputId).attr('autocomplete', 'off');
		
		if(typeof jQuery.fn.typeahead != 'undefined'){
			$('#'+ this.options.pickerInputId).typeahead({
				source: function(query, process) {
					var request = {};
					request['address'] = query;
					request['language'] = that.options.language;

					that.options.geocoder.geocode(request, function(results, status){
						$('#'+ that.options.userInputId +'_error').html('');
						if (status == google.maps.GeocoderStatus.OK) {
							process($.map(results, function(item) {
							  return item.formatted_address;
							}));
						}
					});
				},
				updater: function (item) {
					that.geocodeLookup( 'address', item);
					return item;
				},
				minLength: 3,
				items: this.options.maxResultShow
			});
		};
	},
	
	// Add addressPickerByGiro's event bindings
	addBindings = function(){
		var that = this;
		
		/* add trigger on input focus for modal (twitter bootstrap required) */
		if(this.options.mode == 'modal'){
			this.options.$related.on('focus click',function(){
				$('#'+ that.options.userInputId +'_modal').modal('show');
			});
			
			$('#'+ this.options.userInputId +'_edit').on('click',function(){
				$('#'+ that.options.userInputId +'_modal').modal('show');
			});
			
			$('#'+ this.options.userInputId +'_modal').on("shown", function () {
				that.resizeMap();
				var evt = $.Event(that.options.event_open_modal);
				that.options.$related.trigger(evt, that.options.location_components);
				
				if(typeof that.options.onOpenModal == 'function'){
					that.options.onOpenModal.call(that,that.options.event_open_modal);
				}
			});
			
			// triggered when user click on OK button
			$('#'+ this.options.userInputId +'_ok').on('click', function() {
			
				if(that.options.isElementInput && typeof that.options.location_components == 'object'){
					that.options.$related.val(that.options.location_components.formatted_address);
				}
				
				that.updateFields();
				var evt = $.Event(that.options.event_success);
				that.options.$related.trigger(evt, that.options.location_components);
				
				if(typeof that.options.onSuccess == 'function'){
					that.options.onSuccess.call(that,that.options.event_success);
				}
			});
			
			// triggered when user click on CANCEL button
			$('#'+ this.options.userInputId +'_modal').on('click','[data-dismiss="modal"]', function() {
				var evt = $.Event(that.options.event_close_modal);
				that.options.$related.trigger(evt, that.options.location_components);
				
				if(typeof that.options.onCancelModal == 'function'){
					that.options.onCancelModal.call(that,that.options.event_close_modal);
				}
			});
		} else {
			this.options.map_visible = window.setInterval(checkMapVisibility.call(this), 300);
		}
			
		// triggered when user presses a key in the address box
		$('#'+ this.options.pickerInputId).on('keydown', function(event) {			
			if(event.keyCode == 13) {
				that.geocodeLookup( 'address', $('#'+ that.options.pickerInputId).val());
			}
		});

		// triggered when user click on GO button
		$('#'+ this.options.userInputId +'_search').on('click', function() {
			that.geocodeLookup( 'address', $('#'+ that.options.pickerInputId).val());
		});
		
	};

	
    // The actual plugin constructor
    var Plugin = function ( element ) {
        /*
         * Plugin instantiation
         */		
		
		this.others_opts = {			
			// Events
			event_initialized: pluginName +'_initialized',
			event_open_modal: pluginName + '_open_modal',
			event_close_modal: pluginName + '_close_modal',
			event_success: pluginName + '_success',
			
			// Cached jQuery Object Variables
			$events: $('<a/>'),
			$related: null,
			
			// Variables for cached values or use across multiple functions
			map_rendered: false,
			userInputId: null,
			aPicker: null,
			elementClass: null,
			isElementInput: true,
			pickerInputId: null,
			map: null,
			geocoder: null,
			marker: null,
			location_components: null,
			map_visible: null,
			element: null,
			initialized: false			
		}
		
		this.options = $.extend( {}, defaults);
    };

    Plugin.prototype = {
        init: function ( options ) {
			var that = this;
			if(this.options.initialized){
				return;
			}
		
			$.extend( this.options, options, this.others_opts);

			this.options.pickerInputId = this.options.userInputId = this.id = this.element.attr('id');
			
			this.options.$related = $(this.element);

			// generate a random id for this input
			if(this.options.userInputId == ''){
				this.options.userInputId = generateRandom();
			}
			
			if(!this.options.$related.is('input[type="text"],textarea')){
				this.options.isElementInput = false;
				this.options.pickerInputId = this.options.userInputId = generateRandom();
				
				// add an update text to this element
				if(!this.options.targets_prefix){
					this.options.targets_prefix = this.options.userInputId +'_location_';
				}
				
				elementClass = this.options.targets_prefix + 'formatted_address';
				this.options.$related.addClass(elementClass);
			}
			
			if(this.options.mode == 'modal'){
				this.options.pickerInputId = this.options.userInputId + '_addresspicker';
			}
		
			this.options.aPicker = this.options.userInputId + '_apicker';
			
			addHTML.call(this);
			
			/* add map to the document */
			initGmap.call(this);
			
			// typeahead autocomplete
			typeaheadAddresses.call(this);
			
			addBindings.call(this);
		
			// initialization completed
			this.options.initialized = true;
			var evt = $.Event(this.options.event_initialized);
			this.options.$related.trigger(evt, this.options.location_components);
			
			if(typeof this.options.onInit == 'function'){
				this.options.onInit.call(this,this.options.event_initialized);
			}
        },
		
		geocodeLookup: function( type, value, update ){
			var latLng = false;
			var that = this;
			if(typeof value == 'string' && type == 'latLng'){
				value = value.split(",");	
				value = new google.maps.LatLng(value[0], value[1]);
			}
			
			if(type == 'latLng'){
				latLng = value;
			}

			
			// default value: update = true
			update = typeof update !== 'undefined' ? update : true;

			var request = {};
			request[type] = value;		
			request['language'] = this.options.language;
			
			this.options.geocoder.geocode(request, function(results, status){
				$('#'+ that.options.userInputId +'_error').html('');
				if (status == google.maps.GeocoderStatus.OK) {
				
					// update the map (position marker and center map)
					update_map.call(that, results[0].geometry , latLng);

					// Google geocoding has succeeded!
					if( update ){
						if (results[0]) {
							var location = results[0].geometry.location;
							if(type == 'latLng'){
								location = latLng;
							}

							// update the UI elements with new location data
							update_ui.call(that, results[0].formatted_address,location, results[0].address_components);
						} else {
							// Geocoder status ok but no results!?
							$('#'+ that.options.userInputId +'_error').html(that.options.text.genericerror);
						}
					}
				} else {
					// Google Geocoding has failed. Two common reasons:
					//   * Address not recognised (e.g. search for 'kjdckjdnksjjdpwpid')
					//   * Location doesn't map to address (e.g. click in middle of the ocean)
					if( update ) {
						if( type == 'address' ) {
							// User has typed in an address which we can't geocode to a location
							$('#'+ that.options.userInputId +'_error').html(that.options.text.noresults);
						} else {
							// User has clicked or dragged marker to somewhere that Google can't do a reverse lookup for
							// In this case we display a warning, clear the address box, but fill in LatLng
							$('#'+ that.options.userInputId +'_error').html(that.options.text.toofar);
							update_ui.call(that,'', '', '');
						}
					}
				};
			});
			
		},		

		/* update input fields or DOM elements in the document */
		updateFields: function(){
			var that = this;
			if(this.options.targets_prefix != ''){
				/* set all elements values/text related to targets_prefix */			
				$('[class^="'+ this.options.targets_prefix +'"],[class*=" '+ this.options.targets_prefix +'"]').each(function(index,value){
					var ele = $(this);
					$.each(that.options.location_components, function(index, element){						
						if(!ele.hasClass(that.options.targets_prefix + index)){
							return true;
						}

						if(ele.is('input:not([type="radio"]), textarea')){
							ele.val(that.options.location_components[index]);
							
							/* check for validation engine and fire it on the element */
							if(jQuery.fn.validationEngine == 'function'){
								ele.validationEngine('validate');
							}
						} else {
							ele.text(that.options.location_components[index]);
						}
					});
				});
			}
		},
		
		getMap: function(){	
			return this.options.map;
		},
		
		getAddress: function(){	
			return this.options.location_components;
		},
			
		resizeMap: function(latitude, longitude){
			var lastCenter,map_cont = $('body').find('#'+ this.options.userInputId +'_map_canvas').closest('.map_container');
			var parent_map_cont = map_cont.parent();
			
			var h = parent_map_cont.height();
			var w = parent_map_cont.width();
			
			map_cont.css("height",h);
			map_cont.css("width",w);			
			
			if(typeof latitude != 'undefined' && typeof longitude != 'undefined'){
				lastCenter = new google.maps.LatLng(latitude, longitude);
			} else {
				lastCenter = this.options.map.getCenter();
			}
			google.maps.event.trigger(this.options.map, "resize");
			this.options.map.setCenter(lastCenter);
		},
		
        destroy: function () {
            // unset Plugin data instance
            this.element.data( dataPlugin, null );
        }
    }

    /*
     * Plugin wrapper, preventing against multiple instantiations and
     * allowing any public function to be called via the jQuery plugin,
     * e.g. $(element).pluginName('functionName', arg1, arg2, ...)
     */
    $.fn[ pluginName ] = function ( arg ) {

        var args, instance;

		// return if our jQuery obj doesn't have elements
		if(this.length <= 0){
			return this;
		}
		
        // only allow the plugin to be instantiated once
        if (!( this.data( dataPlugin ) instanceof Plugin )) {
            // if no instance, create one
            this.data( dataPlugin, new Plugin( this ));
        }

        instance = this.data( dataPlugin );
        instance.element = this;

        // Is the first parameter an object (arg), or was omitted,
        // call Plugin.init( arg )
        if (typeof arg === 'undefined' || typeof arg === 'object') {

            if ( typeof instance['init'] === 'function' ) {
                instance.init( arg );
            }

        // checks that the requested public method exists
        } else if ( typeof arg === 'string' && typeof instance[arg] === 'function' ) {

            // copy arguments & remove function name
            args = Array.prototype.slice.call( arguments, 1 );

            // call the method
            return instance[arg].apply( instance, args );

        } else {

            $.error('Method ' + arg + ' does not exist on jQuery.' + pluginName);

        }
    };

}(jQuery, window, document));

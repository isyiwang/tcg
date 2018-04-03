/**
 * @description custom checkboxes & radios with jQuery
 * @see http://liberalcho.github.com/jcheckboxes/
 * @package jquery.checkboxes
 * @version 2.0
 */
;(function( $, window, document, undefined ){

	// set defaults & other options once
	var pluginName = 'jCheckboxes',
		hiddenClass = 'hidden',
		checkedClass = 'checked',
		prefix = 'jcb-',
		hook_prefix = 'jcb',
		pluginDefaults = {
			on_init: null,
			on_change: null,
			on_destroy: null
		};

	// constructor
	function JCB( element, options ){

		// save element
		this.element = element;
		this.label = $('label[for="' + element.id +'"]');

		// extend defaults 
		this.options = $.extend( {}, pluginDefaults, options );

		// init plugin
		this.init();

	};

	// plugin methods
	JCB.prototype = {

		// init method
		init: function (){

			// prevent reinit
			if($.data(this.element, pluginName)) return false;


			// save reference to the constructor
			var Self = this,
				$element = $(Self.element),
				$label = Self.label,
				type = $element.attr('type');

			// add hidden class
			$element.addClass( prefix + hiddenClass );

			// add label HTML 
			$label.contents().wrap('<span class="label-text" />');
			$label.prepend('<span class="label-icon" />');
			$label.addClass( prefix + type );

			// check if input is checked
			if( $element.is(':checked') ) $label.addClass( prefix + checkedClass );

			// trigger on_init callback
			if($.isFunction( Self.options.on_init )){
				Self.options.on_init.apply(this, [ $element ]);
			};

			// trigger on_init hook
			$element.trigger( hook_prefix + '.on_init', $element );

			$label.on('click', function(){
				$label.hasClass( prefix + checkedClass ) ? Self.uncheck( $label, $element, type ) : Self.check( $label, $element, type );

				return false;
			});

		}

		// check method
		,check: function ( label, element, type ){
			var label = label,
				element = element,
				type = type,
				Self = this;

			if(label == undefined){
				label = Self.label;
				element = $(Self.element);
				type = element.attr('type');
			}

			// if radio
			if( type == 'radio' ){
				var input_name = element.attr('name');

				$('input[name="' + input_name + '"]').each(function(){
					var $this = $(this),
						id = this.id,
						label = $('label[for="' + this.id + '"]');

					$this.attr('checked', false);
					label.removeClass( prefix + checkedClass );
				});

			}

			label.addClass( prefix + checkedClass );
			element.attr('checked', true);

			// trigger on_change callback
			if($.isFunction( Self.options.on_change )){
				Self.options.on_change.apply(this, [element, true]);
			}

			// trigger on_change hook 
			element.trigger( hook_prefix + '.on_change', [element, true] );

		}

		// uncheck method
		,uncheck: function ( label, element, type ){

			var label = label,
				element = element,
				type = type,
				Self = this;

			if(label == undefined){
				label = Self.label;
				element = $(Self.element);
				type = element.attr('type');
			}

			// only if checkbox
			if( type == 'checkbox' ){
				label.removeClass( prefix + checkedClass );
				element.attr('checked', false);

				// trigger on_change callback
				if($.isFunction( Self.options.on_change )){
					Self.options.on_change.apply(this, [element, false]);
				}

				// trigger on_change hook 
				element.trigger( hook_prefix + '.on_change', [element, false] );
			}

		}

		// destroy method
		,destroy: function (){

			// vars 
			var Self = this,
				$element = $(Self.element),
				$label = Self.label;

			// get label classes
			var labelClasses = $label.attr('class').match(/jcb-\w+/gi);

			// remove label classes
			$.each(labelClasses, function(i){
				$label.removeClass(labelClasses[i]);
			});

			// remove plugin HTML 
			$label.children('.label-icon').remove();
			$label.children('.label-text').contents().unwrap();

			// remove click event
			$label.off('click');

			// show input
			$element.removeClass( prefix + hiddenClass );

			// trigger on_destroy callback
				if($.isFunction( Self.options.on_destroy )){
					Self.options.on_destroy.apply(this, [ $element ]);
				}

			// trigger on_destroy hook 
			$element.trigger( hook_prefix + '.on_destroy', [$element] );

			// remove plugin data
			$element.removeData('jCheckboxes');

		}

	};

	// pull plugin to jQuery 
	$.fn[pluginName] = function( options ){
		return this.each(function() {
			if(!$.data(this, pluginName)){
				$.data(this, pluginName, new JCB( this, options ));
			}
		});
	};

}( jQuery, window, document ));
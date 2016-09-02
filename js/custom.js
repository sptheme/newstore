( function( $ ) {
	'use strict';

	var wpspCustom = {
		
		/**
		 * Main init function
		 *
		 * @since 1.0.0
		 */
		init : function() {
			this.config();
			this.bindEvents();
		},

		/**
		 * Cache Elements
		 *
		 * @since 1.0.0
		 */
		config : function() {

			this.config = {
				// Main
				$window                 : $( window ),
				$document               : $( document ),
				$windowWidth            : $( window ).width(),
				$windowHeight           : $( window ).height(),
				$windowTop              : $( window ).scrollTop(),
				$body                   : $( 'body' ),
				$viewportWidth          : '',
				$is_rtl                 : false,
				$wpAdminBar             : null,

				// Mobile
				$isMobile               : false,
				$mobileMenuStyle        : null,
				$mobileMenuToggleStyle  : null,
				$mobileMenuBreakpoint   : 960,

				// Header
				$siteHeader             : null,
				$siteHeaderStyle        : null,
				$siteHeaderHeight       : 0,
				$siteHeaderTop          : 0,
				$siteHeaderBottom       : 0,
				$verticalHeaderActive   : false,
				$hasHeaderOverlay       : false,
				$hasStickyHeader        : false,
				$hasStickyMobileHeader  : false,
				$hasStickyNavbar        : false,

				// Logo
				$siteLogo               : null,
				$siteLogoHeight         : 0,
				$siteLogoSrc            : null,
				$siteNavWrap            : null,
				$siteNavDropdowns       : null,

				// Local Scroll
				$localScrollTargets     : 'li.local-scroll a, a.local-scroll, .local-scroll-link',
				$localScrollOffset      : 0,
				$localScrollSpeed       : 600,
				$localScrollSections    : [],	

				// Topbar
				$hasTopBar              : false,
				$hasStickyTopBar        : false,
				$stickyTopBar           : null,
				$hasStickyTopBarMobile  : false,

				// Footer
				$hasFixedFooter         : false,
				$hasFooterReveal        : false
			};

		},

		bindEvents: function() {
			var self = this;

			// Run on document ready
			self.config.$document.on( 'ready', function() {

				// Update vars on init
				self.initUpdateConfig();

				// Main nav dropdowns
				self.superFish();

				// Header 5 logo
				self.inlineHeaderLogo();

				// Menu search toggle,overlay,header replace
				self.menuSearch();

				// Custom menu widget accordion
				self.customMenuWidgetAccordion();
			} );

			// Run on Window Load
			self.config.$window.on( 'load', function() {
				var $headerStyle = self.config.$siteHeaderStyle;

				// Update config on window load
				self.windowLoadUpdateConfig();

				// Setup flush dropdowns
				self.flushDropdownsTop();

				// Sticky Header
				if ( self.config.$hasStickyHeader ) {
					var $stickyStyle = wpspLocalize.stickyHeaderStyle;
					if ( 'standard' == $stickyStyle
						|| 'shrink' == $stickyStyle
						|| 'shrink_animated' == $stickyStyle
					) {
						self.stickyHeader();
						self.shrinkStickyHeader();
					}
				}

			} );
		},

		/**
		 * Updates config on doc ready
		 *
		 * @since 1.0.0
		 */
		initUpdateConfig: function() {

			// Get Viewport width
			this.config.$viewportWidth = this.viewportWidth();

			// Define header
			var $siteHeader = $( '#site-header' );
			if ( $siteHeader.length ) {
				this.config.$siteHeaderStyle = wpspLocalize.siteHeaderStyle;
				this.config.$siteHeader = $( '#site-header' );
			}

			// Define logo
			var $siteLogo = $( '#site-logo img' );
			if ( $siteLogo.length ) {
				this.config.$siteLogo = $siteLogo;
				this.config.$siteLogoSrc = this.config.$siteLogo.attr( 'src' );
			}

			// Sticky Header => Mobile Check (must check first)
			if ( 'toggle' == this.config.$mobileMenuStyle ) {
				this.config.$hasStickyMobileHeader = false;
			} else {
				this.config.$hasStickyMobileHeader = wpspLocalize.hasStickyMobileHeader;
			}

			// Check if sticky header is enabled
			if ( this.config.$siteHeader && wpspLocalize.hasStickyHeader ) {
				this.config.$hasStickyHeader = true;
			}
		},

		/**
		 * Updates config on window load
		 *
		 * @since 1.0.0
		 */
		windowLoadUpdateConfig: function() {

			// Header bottom position
			if ( this.config.$siteHeader ) {
				var $siteHeaderTop = this.config.$siteHeader.offset().top;
				this.config.$windowHeight = this.config.$window.height();
				this.config.$siteHeaderHeight = this.config.$siteHeader.outerHeight();
				this.config.$siteHeaderBottom = $siteHeaderTop + this.config.$siteHeaderHeight;
				this.config.$siteHeaderTop = $siteHeaderTop;
				if ( this.config.$siteLogo ) {
					this.config.$siteLogoHeight = this.config.$siteLogo.height();
				}
			}

			// Set localScrollOffset after site is loaded to make sure it includes dynamic items
			this.config.$localScrollOffset = this.parseLocalScrollOffset();

		},

		/**
		 * Updates config whenever the window is resized
		 *
		 * @since 1.0.0
		 */
		resizeUpdateConfig: function() {

			// Update main configs
			this.config.$windowHeight  = this.config.$window.height();
			this.config.$windowWidth   = this.config.$window.width();
			this.config.$windowTop     = this.config.$window.scrollTop();
			this.config.$viewportWidth = this.viewportWidth();

			// Update header height
			if ( this.config.$siteHeader ) {
				this.config.$siteHeaderHeight = this.config.$siteHeader.outerHeight();
			}

			// Get logo height
			if ( this.config.$siteLogo ) {
				this.config.$siteLogoHeight = this.config.$siteLogo.height();
			}

			// Vertical Header
			if ( this.config.$windowWidth < 960 ) {
				this.config.$verticalHeaderActive = false;
			} else if ( this.config.$body.hasClass( 'wpsp-has-vertical-header' ) ) {
				this.config.$verticalHeaderActive = true;
			}

			// Local scroll offset => update last
			this.config.$localScrollOffset = this.parseLocalScrollOffset();

		},

		/**
		 * Superfish
		 *
		 * @since 1.0.0
		 */
		superFish: function() {
	        if ( ! $.fn.superfish ) {
				return;
			}

			$( '#site-navigation ul.sf-menu' ).superfish( {
				delay: wpspLocalize.superfishDelay,
				animation: {
					opacity: 'show'
				},
				animationOut: {
					opacity: 'hide'
				},
				speed: wpspLocalize.superfishSpeed,
				speedOut: wpspLocalize.superfishSpeedOut,
				cssArrows: false,
				disableHI: false
			} );
	    },

	    /**
		 * FlushDropdowns top positioning
		 *
		 * @since 1.0.0
		 */
		flushDropdownsTop: function() {

			if ( ! this.config.$siteHeaderHeight
				|| ! this.config.$siteNavWrap
				|| ! this.config.$siteNavWrap.hasClass( 'wpsp-flush-dropdowns' )
			) {
				return;
			}

			var $navHeight = this.config.$siteNavWrap.outerHeight(),
				$dropTop = this.config.$siteHeaderHeight - $navHeight;

			$( '#site-navigation-wrap .wpsp-dropdown-menu > .menu-item-has-children > ul' ).css( {
				'top': $dropTop/2 + $navHeight
			} );

		},

		/**
		 * Header 5 - Inline Logo
		 *
		 * @since 1.0.0
		 */
		inlineHeaderLogo: function() {

			// Only needed for header style 5
			if ( 'five' != wpspLocalize.siteHeaderStyle ) {
				return;
			}

			var $headerLogo        = $( '#site-header-inner > .header-five-logo' ),
				$headerNav         = $( '#site-header-inner .navbar-style-five' ),
				$navLiCount        = $headerNav.children( '#site-navigation' ).children( 'ul' ).children( 'li' ).size(),
				$navBeforeMiddleLi = Math.round( $navLiCount / 2 ) - parseInt( wpspLocalize.headerFiveSplitOffset ),
				$centeredLogo      = $( '.menu-item-logo .header-five-logo' );

				console.log($navBeforeMiddleLi);

				// Add logo into menu
				if ( this.config.$windowWidth >= this.config.$mobileMenuBreakpoint && $headerLogo.length && $headerNav.length ) {
					$('<li class="menu-item-logo"></li>').insertAfter( $headerNav.find( '#site-navigation > ul > li:nth( '+ $navBeforeMiddleLi +' )' ) );
						$headerLogo.appendTo( $headerNav.find( '.menu-item-logo' ) );
				}

				// Remove logo from menu and add to header
				if ( this.config.$windowWidth < this.config.$mobileMenuBreakpoint && $centeredLogo.length ) {
					$centeredLogo.prependTo( $( '#site-header-inner' ) );
					$( '.menu-item-logo' ).remove();
				}

			// Add display class to logo (hidden by default)
			$headerLogo.addClass( 'display' );

		},

		/**
		 * Custom menu widget toggles
		 *
		 * @since 1.0.0
		 */
		customMenuWidgetAccordion: function() {

			var self = this;

			$( '#wrapper-content .widget_nav_menu .current-menu-ancestor' ).addClass( 'active' ).children( 'ul' ).show();

			$( '#wrapper-content .widget_nav_menu' ).each( function() {
				var $widgetMenu  = $( this ),
					$hasChildren = $( this ).find( '.menu-item-has-children' ),
					$allSubs     = $hasChildren.children( '.sub-menu' );
				$hasChildren.each( function() {
					$( this ).addClass( 'parent' );
					var $links = $( this ).children( 'a' );
					$links.on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
						var $linkParent = $( this ).parent( 'li' ),
							$allParents = $linkParent.parents( 'li' );
						if ( ! $linkParent.hasClass( 'active' ) ) {
							$hasChildren.not( $allParents ).removeClass( 'active' ).children( '.sub-menu' ).slideUp( 'fast' );
							$linkParent.addClass( 'active' ).children( '.sub-menu' ).stop( true, true ).slideDown( 'fast' );
						} else {
							$linkParent.removeClass( 'active' ).children( '.sub-menu' ).stop( true, true ).slideUp( 'fast' );
						}
						return false;
					} );
				} );
			} );

		},

		/**
		 * Header Search
		 *
		 * @since 1.0.0
		 */
		menuSearch: function() {

			var self = this;

			/**** Menu Search > Dropdown ****/
			if ( 'drop_down' == wpspLocalize.menuSearchStyle ) {

				var $searchDropdownToggle = $( 'a.search-dropdown-toggle' );
				var $searchDropdownForm   = $( '#searchform-dropdown' );

				$searchDropdownToggle.click( function( event ) {
					// Display search form
					$searchDropdownForm.toggleClass( 'show' );
					// Active menu item
					$( this ).parent( 'li' ).toggleClass( 'active' );
					// Focus
					var $transitionDuration = $searchDropdownForm.css( 'transition-duration' );
					$transitionDuration = $transitionDuration.replace( 's', '' ) * 1000;
					if ( $transitionDuration ) {
						console.log('test');
						setTimeout( function() {
							$searchDropdownForm.find( 'input[type="search"]' ).focus();
						}, $transitionDuration );
					}
					// Hide other things
					$( 'div#current-shop-items-dropdown' ).removeClass( 'show' );
					$( 'li.wcmenucart-toggle-dropdown' ).removeClass( 'active' );
					// Return false
					return false;
				} );

				// Close on doc click
				self.config.$document.on( 'click', function( event ) {
					if ( ! $( event.target ).closest( '#searchform-dropdown.show' ).length ) {
						$searchDropdownToggle.parent( 'li' ).removeClass( 'active' );
						$searchDropdownForm.removeClass( 'show' );
					}
				} );

			}

			/**** Menu Search > Overlay Modal ****/
			else if ( 'overlay' == wpspLocalize.menuSearchStyle ) {

				if ( ! $.fn.leanerModal ) {
					return;
				}

				var $searchOverlayToggle = $( 'a.search-overlay-toggle' );

				$searchOverlayToggle.leanerModal( {
					'id'      : '#searchform-overlay',
					'top'     : 100,
					'overlay' : 0.8,
				} );

				$searchOverlayToggle.click( function() {
					$( '#site-searchform input' ).focus();
				} );

			}

			/**** Menu Search > Header Replace ****/
			else if ( 'header_replace' == wpspLocalize.menuSearchStyle ) {

				// Show
				var $headerReplace = $( '#searchform-header-replace' );
				$( 'a.search-header-replace-toggle' ).click( function( event ) {
					// Display search form
					$headerReplace.toggleClass( 'show' );
					// Focus
					var $transitionDuration =  $headerReplace.css( 'transition-duration' );
					$transitionDuration = $transitionDuration.replace( 's', '' ) * 1000;
					if ( $transitionDuration ) {
						setTimeout( function() {
							$headerReplace.find( 'input[type="search"]' ).focus();
						}, $transitionDuration );
					}
					// Return false
					return false;
				} );

				// Close on click
				$( '#searchform-header-replace-close' ).click( function() {
					$headerReplace.removeClass( 'show' );
					return false;
				} );

				// Close on doc click
				self.config.$document.on( 'click', function( event ) {
					if ( ! $( event.target ).closest( $( '#searchform-header-replace.show' ) ).length ) {
						$headerReplace.removeClass( 'show' );
					}
				} );
			}

		},

		/**
		 * New Sticky Header
		 *
		 * @since 3.4.0
		 */
		stickyHeader : function() {
			var $isSticky = false;
			var self      = this;

			// Return if sticky is disabled
			if ( ! self.config.$hasStickyHeader ) return;

			// Define header vars
			var $header      = self.config.$siteHeader;
			var $headerStyle = self.config.$siteHeaderStyle;

			// Add sticky wrap
			var $stickyWrap = $( '<div id="site-header-sticky-wrapper" class="wpsp-sticky-header-holder not-sticky"></div>' );
			$header.wrapAll( $stickyWrap );

			// Define main vars for sticky function
			var $window               = self.config.$window;
			var $brkPoint             = wpspLocalize.stickyHeaderBreakPoint;
			var $stickyWrap           = $( '#site-header-sticky-wrapper' );
			var $headerHeight         = self.config.$siteHeaderHeight;
			var $hasShrinkFixedHeader = $header.hasClass( 'shrink-sticky-header' );
			var $mobileSupport        = self.config.$hasStickyMobileHeader;

			// Custom shrink logo
			var $stickyLogo    = wpspLocalize.stickyheaderCustomLogo;
			var $headerLogo    = self.config.$siteLogo;
			var $headerLogoSrc = self.config.$siteLogoSrc;

		},

		/**
		 * Sticky Header
		 *
		 * @since 1.0.0
		 */
		shrinkStickyHeader: function( event ) {

			var $isShrunk = false;

			// Define header element
			var self     = this,
				$header  = self.config.$siteHeader,
				$enabled = $header.hasClass( 'shrink-sticky-header' );

		},
	}

	wpspCustom.init();

} ) ( jQuery );	
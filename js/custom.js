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
				$mobileMenuBreakpoint   : 992,

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
				$hasFixedFooter         : false
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

				// Mobile menu
				self.mobileMenu();

				// Prevent menu item click
				self.navNoClick();

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

				// Sticky Navbar
				if ( self.config.$hasStickyNavbar ) {
					self.stickyHeaderMenu();
				}

				// Fixed Footer
				self.fixedFooter();

				// Scroll to hash
				window.setTimeout( function() {
					self.scrollToHash( self )
				}, 500 );

			} );

			// Run on Window Resize
			self.config.$window.resize( function() {

				// Window width change
				if ( self.config.$window.width() != self.config.$windowWidth ) {
					self.resizeUpdateConfig(); // update vars
					self.inlineHeaderLogo();
					self.fixedFooter();
				}

				// Window height change
				if ( self.config.$window.height() != self.config.$windowHeight ) {
					self.fixedFooter();
				}

			} );

			// Run on Scroll
			self.config.$window.scroll( function() {
				self.config.$windowTop = self.config.$window.scrollTop();				
			} );

			// On orientation change
			self.config.$window.on( 'orientationchange',function() {
				self.resizeUpdateConfig();
				self.inlineHeaderLogo();
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

			// Mobile check & add mobile class to the header
			if ( this.mobileCheck() ) {
				this.config.$isMobile = true;
				this.config.$body.addClass( 'wpsp-is-mobile-device' );
			}

			// Define Wp admin bar
			var $wpAdminBar = $( '#wpadminbar' );
			if ( $wpAdminBar.length ) {
				this.config.$wpAdminBar = $wpAdminBar;
			}
			
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

			// RTL
			if ( wpspLocalize.isRTL ) {
				this.config.$isRTL = true;
			}

			// Menu Stuff
			var $siteNavWrap = $( '#site-navigation-wrap' );
			if ( $siteNavWrap.length ) {

				// Define menu
				this.config.$siteNavWrap = $siteNavWrap;

				// Check if sticky menu is enabled
				if ( wpspLocalize.hasStickyNavbar ) {
					this.config.$hasStickyNavbar = true;
				}

				// Store dropdowns
				var $siteNavDropdowns = $( '#site-navigation-wrap .dropdown-menu > .menu-item-has-children > ul' );
				if ( $siteNavWrap.length ) {
					this.config.$siteNavDropdowns = $siteNavDropdowns;
				}

				// Mobile menu Style
				this.config.$mobileMenuStyle       = wpspLocalize.mobileMenuStyle;
				this.config.$mobileMenuToggleStyle = wpspLocalize.mobileMenuToggleStyle;

				// Mobile menu breakpoint
				this.config.$mobileMenuBreakpoint   = wpspLocalize.mobileMenuBreakpoint;

			}

			// Check if fixed footer is enabled
			if ( this.config.$body.hasClass( 'wpsp-has-fixed-footer' ) ) {
				this.config.$hasFixedFooter = true;
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
		 * Mobile Check
		 *
		 * @since 1.0.0
		 */
		mobileCheck: function() {
			if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent ) ) {
				return true;
			}
		},

		/**
		 * Viewport width
		 *
		 * @since 1.0.0
		 */
		viewportWidth: function() {
			var e = window, a = 'inner';
			if ( !( 'innerWidth' in window ) ) {
				a = 'client';
				e = document.documentElement || document.body;
			}
			return e[ a+'Width' ];
		},

		/**
		 * Local Scroll Offset
		 *
		 * @since 1.0.0
		 */
		parseLocalScrollOffset: function() {
			var self    = this;
			var $offset = 0;

			// Return custom offset
			if ( wpspLocalize.localScrollOffset ) {
				return wpspLocalize.localScrollOffset;
			}

			// Fixed header
			if ( self.config.$hasStickyHeader ) {

				// Return 0 for small screens if mobile fixed header is disabled
				if ( ! self.config.$hasStickyMobileHeader && self.config.$windowWidth <= wpspLocalize.stickyHeaderBreakPoint ) {
					$offset = 0;
				}

				// Return header height
				else {

					// Shrink header
					if ( self.config.$siteHeader.hasClass( 'shrink-sticky-header' ) ) {
						$offset = wpspLocalize.shrinkHeaderHeight;
					}

					// Standard header
					else {
						$offset = self.config.$siteHeaderHeight;
					}

				}

			}

			// Fixed Nav
			if ( self.config.$hasStickyNavbar ) {
				if ( self.config.$windowWidth >= wpspLocalize.stickyHeaderBreakPoint ) {
					$offset = parseInt( $offset ) + parseInt( $( '#site-navigation-wrap' ).outerHeight() );
				}
			}

			// Add wp toolbar
			if ( $( '#wpadminbar' ).length ) {
				$offset = parseInt( $offset ) +  parseInt( $( '#wpadminbar' ).outerHeight() );
			}

			// Add 1 extra decimal to prevent cross browser rounding issues
			$offset = $offset ? $offset - 1 : 0;

			// Return offset
			return $offset;
		},

		/**
		 * Scroll to Hash
		 *
		 * @since 1.0.0
		 */
		scrollToHash: function( $this ) {

			// Declare function vars
			var self  = $this,
				$hash = location.hash;

			// Hash needed
			if ( ! $hash ) {
				return;
			}

			// Scroll to hash for localscroll links
			if ( $hash.indexOf( 'localscroll-' ) != -1 ) {
				self.scrollTo( $hash.replace( 'localscroll-', '' ) );
				return;
			}

			// Check elements with data attributes
			else if ( $( '[data-ls_id="'+ $hash +'"]' ).length ) {
				self.scrollTo( $hash );
			}

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
		 * Mobile Menu
		 *
		 * @since 1.0.0
		 */
		mobileMenu: function( event ) {

			var self = this;

			/***** Sidr Mobile Menu ****/
			if ( 'sidr' == this.config.$mobileMenuStyle && typeof wpspLocalize.sidrSource !== 'undefined' ) {

				var self = this;

				// Add sidr
				$( 'a.mobile-menu-toggle, li.mobile-menu-toggle > a' ).sidr( {
					name     : 'sidr-main',
					source   : wpspLocalize.sidrSource,
					side     : wpspLocalize.sidrSide,
					displace : wpspLocalize.sidrDisplace,
					speed    : parseInt( wpspLocalize.sidrSpeed ),
					renaming : true,
					onOpen   : function() {
						
						// Add extra classname
						$( '#sidr-main' ).addClass( 'wpsp-mobile-menu' );

						// Prevent body scroll
						self.config.$body.addClass( 'wpsp-noscroll' );

						// Declare useful vars
						var $hasChildren = $( '.sidr-class-menu-item-has-children' );

						// Add dropdown toggle (arrow)
						$hasChildren.children( 'a' ).append( '<span class="sidr-class-dropdown-toggle"></span>' );

						// Toggle dropdowns
						var $sidrDropdownTarget = $( '.sidr-class-dropdown-toggle' );

						// Check localization
						if ( wpspLocalize.sidrDropdownTarget == 'li' ) {
							$sidrDropdownTarget = $( '.sidr-class-sf-with-ul' );
						}

						// Add toggle click event
						$sidrDropdownTarget.on( 'click', function( event ) {

							// Define toggle vars
							if ( wpspLocalize.sidrDropdownTarget == 'li' ) {
								var $toggleParentLi = $( this ).parent( 'li' );
							} else {
								var $toggleParentLink = $( this ).parent( 'a' ),
									$toggleParentLi   = $toggleParentLink.parent( 'li' );
							}

							// Get parent items and dropdown
							var $allParentLis = $toggleParentLi.parents( 'li' ),
								$dropdown     = $toggleParentLi.children( 'ul' );

							// Toogle items
							if ( ! $toggleParentLi.hasClass( 'active' ) ) {
								$hasChildren.not( $allParentLis ).removeClass( 'active' ).children( 'ul' ).slideUp( 'fast' );
								$toggleParentLi.addClass( 'active' ).children( 'ul' ).slideDown( 'fast' );
							} else {
								$toggleParentLi.removeClass( 'active' ).children( 'ul' ).slideUp( 'fast' );
							}

							// Return false
							return false;

						} );

						// Add dark overlay to content
						self.config.$body.append( '<div class="wpsp-sidr-overlay wpsp-hidden"></div>' );
						$( '.wpsp-sidr-overlay' ).fadeIn( wpspLocalize.sidrSpeed );

						/* Bind scroll - buggy
						$( '#sidr-main' ).bind( 'mousewheel DOMMouseScroll', function ( e ) {
							var e0 = e.originalEvent,
								delta = e0.wheelDelta || -e0.detail;
							this.scrollTop += ( delta < 0 ? 1 : -1 ) * 30;
							e.preventDefault();
						} );*/

						// Close sidr when clicking toggle
						$( 'a.sidr-class-toggle-sidr-close' ).on( 'click', function( event ) {
							$.sidr( 'close', 'sidr-main' );
							return false;
						} );

						// Close sidr when clicking on overlay
						$( '.wpsp-sidr-overlay' ).on( 'click', function( event ) {
							$.sidr( 'close', 'sidr-main' );
							return false;
						} );

						// Close on resize
						self.config.$window.resize( function() {
							if ( self.config.$windowWidth >= self.config.$mobileMenuBreakpoint ) {
								$.sidr( 'close', 'sidr-main' );
							}
						} );

					},
					onClose : function() {

						// Allow body scroll
						self.config.$body.removeClass( 'wpsp-noscroll' );

						// Remove active dropdowns
						$( '.sidr-class-menu-item-has-children.active' ).removeClass( 'active' ).children( 'ul' ).hide();
						
						// FadeOut overlay
						$( '.wpsp-sidr-overlay' ).fadeOut( wpspLocalize.sidrSpeed, function() {
							$( this ).remove();
						} );
					}

				} );

				// Close when clicking local scroll link
				$( 'li.sidr-class-local-scroll > a' ).click( function() {
					var $hash = this.hash;
					if ( $.inArray( $hash, self.config.$localScrollSections ) > -1 ) {
						$.sidr( 'close', 'sidr-main' );
						self.scrollTo( $hash );
						return false;
					}
				} );

			}

			/***** Toggle Mobile Menu ****/
			else if ( 'toggle' == self.config.$mobileMenuStyle && self.config.$siteHeader ) {

				var $classes = 'mobile-toggle-nav wpsp-mobile-menu hidden-lg-up clearfix';

				// Insert nav
				if ( $( '#wpsp-mobile-menu-fixed-top' ).length ) {
					$( '#wpsp-mobile-menu-fixed-top' ).append( '<nav class="'+ $classes +'"></nav>' );
				}

				// Overlay header
				else if ( self.config.$hasHeaderOverlay && $( '#overlay-header-wrap' ).length ) {
					$( '<nav class="'+ $classes +'"></nav>' ).insertBefore( "#overlay-header-wrap" );
				}

				// Normal toggle insert
				else {
					$( '<nav class="'+ $classes +'"></nav>' ).insertAfter( self.config.$siteHeader );
				}

				// Grab all content from menu and add into mobile-toggle-nav element
				if ( $( '#mobile-menu-alternative' ).length ) {
					var mobileMenuContents = $( '#mobile-menu-alternative .wpsp-dropdown-menu' ).html();
				} else {
					var mobileMenuContents = $( '#site-navigation .wpsp-dropdown-menu' ).html();
				}
				$( '.mobile-toggle-nav' ).html( '<ul class="mobile-toggle-nav-ul">' + mobileMenuContents + '</ul>' );

				// Remove all styles
				$( '.mobile-toggle-nav-ul, .mobile-toggle-nav-ul *' ).children().each( function() {
					var attributes = this.attributes;
					$( this ).removeAttr( 'style' );
				} );

				// Add classes where needed
				$( '.mobile-toggle-nav-ul' ).addClass( 'container' );

				// Show/Hide
				$( '.mobile-menu-toggle' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
					if ( wpspLocalize.animateMobileToggle ) {
						$( '.mobile-toggle-nav' ).stop(true,true).slideToggle( 'fast' ).toggleClass( 'visible' );
					} else {
						$( '.mobile-toggle-nav' ).toggle().toggleClass( 'visible' );
					}
					return false;
				} );

				// Close on resize
				self.config.$window.resize( function() {
					if ( self.config.$windowWidth >= self.config.$mobileMenuBreakpoint && $( '.mobile-toggle-nav' ).length ) {
						//console.log(self.config.$windowWidth + ' : ' + self.config.$mobileMenuBreakpoint);
						$( '.mobile-toggle-nav' ).hide().removeClass( 'visible' );						
					}
				} );

				// Add search to toggle menu
				var $mobileSearch = $( '#mobile-menu-search' );
				if ( $mobileSearch.length ) {
					$( '.mobile-toggle-nav' ).append( '<div class="mobile-toggle-nav-search container"></div>' );
					$( '.mobile-toggle-nav-search' ).append( $mobileSearch );					
				}

			}

			/***** Full-Screen Overlay Mobile Menu ****/
			else if ( 'full_screen' == self.config.$mobileMenuStyle && self.config.$siteHeader ) {

				// Style
				var $style = wpspLocalize.fullScreenMobileMenuStyle ? wpspLocalize.fullScreenMobileMenuStyle : false;

				// Insert new nav
				self.config.$body.append( '<div class="full-screen-overlay-nav wpsp-mobile-menu clearfix '+ $style +'"><span class="full-screen-overlay-nav-close"></span><nav class="full-screen-overlay-nav-ul-wrapper"><ul class="full-screen-overlay-nav-ul"></ul></nav></div>' );

				// Grab all content from menu and add into mobile-toggle-nav element
				if ( $( '#mobile-menu-alternative' ).length ) {
					var mobileMenuContents = $( '#mobile-menu-alternative .wpsp-dropdown-menu' ).html();
				} else {
					var mobileMenuContents = $( '#site-navigation .wpsp-dropdown-menu' ).html();
				}
				$( '.full-screen-overlay-nav-ul' ).html( mobileMenuContents );

				// Remove all styles
				$( '.full-screen-overlay-nav, .full-screen-overlay-nav *' ).children().each( function() {
					var attributes = this.attributes;
					$( this ).removeAttr( 'style' );
				} );

				// Show
				$( '.mobile-menu-toggle' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
					$( '.full-screen-overlay-nav' ).addClass( 'visible' );
					self.config.$body.addClass( 'wpsp-noscroll' );
					return false;
				} );

				// Hide
				$( '.full-screen-overlay-nav-close' ).on( self.config.$isMobile ? 'touchstart' : 'click', function( event ) {
					$( '.full-screen-overlay-nav' ).removeClass( 'visible' );
					self.config.$body.removeClass( 'wpsp-noscroll' );
					return false;
				} );

			}

		},

		/**
		 * Prevent clickin on links
		 *
		 * @since 1.0.0
		 */
		navNoClick: function() {
			$( 'li.nav-no-click > a, li.sidr-class-nav-no-click > a' ).live( 'click', function() {
				return false;
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
		 * Get correct sticky header offset / Used for header and menu so keep outside
		 *
		 * @since 1.0.0
		 */
		stickyOffset: function() {
			var self          = this;
			var $offset       = 0;
			var $mobileMenu   = $( '#wpsp-mobile-menu-fixed-top' );

			// Offset mobile menu
			if ( $mobileMenu.is( ':visible' ) ) {
				$offset = $offset + $mobileMenu.outerHeight();
			}

			// Offset adminbar
			if ( this.config.$wpAdminBar ) {
				$offset = $offset + this.config.$wpAdminBar.outerHeight();
			}

			// Added offset via child theme
			if ( wpspLocalize.addStickyHeaderOffset ) {
				$offset = $offset + wpspLocalize.addStickyHeaderOffset;
			}

			// Return correct offset
			return $offset;

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

			// Add offsets
			var $stickyWrapTop = $stickyWrap.offset().top;
			var $stickyOffset  = self.stickyOffset();
			var $setStickyPos  = $stickyWrapTop - $stickyOffset;

			// Set sticky
			function setSticky() {

				// Already stuck
				if ( $isSticky ) return;

				// Custom Sticky logo
				if ( $stickyLogo && $headerLogo ) {
					$headerLogo.attr( 'src', $stickyLogo );
					self.config.$siteLogoHeight = self.config.$siteLogo.height();
				}

				// Add wrap class and toggle sticky class
				$stickyWrap
					.css( 'height', $headerHeight )
					.removeClass( 'not-sticky' )
					.addClass( 'is-sticky' );

				// Tweak header
				$header.removeClass( 'dyn-styles').css( {
					'top'   : self.stickyOffset(),
					'width' : $stickyWrap.width()
				} );

				// Set sticky to true
				$isSticky = true;

			}

			// Destroy sticky
			function destroySticky() {

				// Already unstuck
				if ( ! $isSticky ) return;

				// Reset logo
				if ( $stickyLogo && $headerLogo ) {
					$headerLogo.attr( 'src', $headerLogoSrc );
					self.config.$siteLogoHeight = self.config.$siteLogo.height();
				}

				// Remove sticky wrap height and toggle sticky class
				$stickyWrap.removeClass( 'is-sticky' ).addClass( 'not-sticky' );

				// Do not remove height on sticky header for shrink header incase animation isn't done yet
				if ( ! $header.hasClass( 'shrink-sticky-header' ) ) {
					$stickyWrap.css( 'height', '' );
				}

				// Reset header
				$header.addClass( 'dyn-styles').css( {
					'width' : '',
					'top'   : ''
				} );

				// Set sticky to false
				$isSticky = false;

			}

			// On scroll function
			function stickyCheck() {

				// Disable on mobile devices
				if ( ! $mobileSupport && ( self.config.$viewportWidth < $brkPoint ) ) {
					return;
				}

				// Add and remove sticky classes and sticky logo				
				if ( self.config.$windowTop >= $setStickyPos && 0 !== self.config.$windowTop ) {
				 	setSticky();
				} else {
					destroySticky();
				}

			}

			// On resize function
			function onResize() {

				// Check if header is disabled on mobile if not destroy on resize
				if ( ! $mobileSupport && ( self.config.$viewportWidth < $brkPoint ) ) {
					destroySticky();
				} else {

					// Update sticky
					if ( $isSticky ) {

						// Update Height
						if ( ! $header.hasClass( 'shrink-sticky-header' ) ) {
							$stickyWrap.css( 'height', self.config.$siteHeaderHeight );
						}

						// Update width and top
						$header.css( {
							'top'   : self.stickyOffset(),
							'width' : $stickyWrap.width()
						} );

					}

					// Add sticky
					else {
						stickyCheck();
					}

				}

			} // End onResize

			// Fire on init
			stickyCheck();

			// Fire onscroll event
			$window.scroll( function() {
				stickyCheck();
			} );

			// Fire onResize
			$window.resize( function() {
				onResize();
			} );

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

			// Return if shrink header disabled
			if ( ! $enabled ) return;

			// Define window and sticky wrap
			var $window     = self.config.$window,
				$brkPoint   = wpspLocalize.stickyHeaderBreakPoint,
				$stickyWrap = $( '#site-header-sticky-wrapper' );
			if ( ! $stickyWrap.length ) return;

			// Check if enabled on mobile
			var $mobileSupport = self.config.$hasStickyMobileHeader;

			// Get correct header offet
			var $headerHeight       = self.config.$siteHeaderHeight,
				$stickyWrapTop      = $stickyWrap.offset().top,
				$shrinkHeaderOffset = $stickyWrapTop + $headerHeight;

			// Mobile checks
			var $mtStyle = self.config.$mobileMenuToggleStyle;
			if ( $mobileSupport && ( 'icon_buttons' == $mtStyle || 'fixed_top' == $mtStyle ) ) {
				var $hasShrinkHeaderOnMobile = true;
			} else {
				var $hasShrinkHeaderOnMobile = false;
			}

			// Shrink header function
			function shrinkHeader() {

				// Already shrunk or not sticky
				if ( $isShrunk || ! $stickyWrap.hasClass( 'is-sticky' ) ) return;

				// Add shrunk class
				$header.addClass( 'sticky-header-shrunk' );

				// Update shrunk var
				$isShrunk = true;

			}

			// Un-Shrink header function
			function unShrinkHeader() {

				// Not shrunk
				if ( ! $isShrunk ) return;

				// Remove shrunk class
				$header.removeClass( 'sticky-header-shrunk' );

				// Update shrunk var
				$isShrunk = false;

			}

			// On scroll function
			function shrinkCheck() {

				// Disable on mobile devices
				if ( ! $hasShrinkHeaderOnMobile && ( self.config.$viewportWidth < $brkPoint ) ) {
					return;
				}

				// Shrink sticky header
				if ( self.config.$windowTop >= $shrinkHeaderOffset ) {
					shrinkHeader();
				} else {
					unShrinkHeader();
				}

			}

			// On resize function
			function onResize() {

				// Check if header is disabled on mobile if not destroy
				if ( ! $hasShrinkHeaderOnMobile && ( self.config.$viewportWidth < $brkPoint ) ) {
					unShrinkHeader();
				} else {
					shrinkCheck();
				}

			}

			// Fire on init
			shrinkCheck();

			// Fire onscroll event
			$window.scroll( function() {
				shrinkCheck();
			} );

			// Fire onResize
			$window.resize( function() {
				onResize();
			} );
		},

		/**
		 * Sticky Header Menu
		 *
		 * @since 1.0.0
		 */
		stickyHeaderMenu: function() {
			var self           = this;
			var $navWrap       = self.config.$siteNavWrap;
			var $isSticky      = false;
			var $window        = self.config.$window;
			var $mobileSupport = wpspLocalize.hasStickyNavbarMobile;

			// Add sticky wrap
			var $stickyWrap = $( '<div id="site-navigation-sticky-wrapper" class="wpsp-sticky-navigation-holder not-sticky"></div>' );
			$navWrap.wrapAll( $stickyWrap );
			$stickyWrap = $( '#site-navigation-sticky-wrapper' );

			// Add offsets
			var $stickyWrapTop = $stickyWrap.offset().top;
			var $stickyOffset  = self.stickyOffset();
			var $setStickyPos  = $stickyWrapTop - $stickyOffset;

			// Shrink header function
			function setSticky() {

				// Already sticky
				if ( $isSticky ) return;

				// Add wrap class and toggle sticky class
				$stickyWrap
					.css( 'height', self.config.$siteNavWrap.outerHeight() )
					.removeClass( 'not-sticky' )
					.addClass( 'is-sticky' );

				// Add CSS to topbar
				$navWrap.css( {
					'top'   : self.stickyOffset(),
					'width' : $stickyWrap.width()
				} );
				
				// Update shrunk var
				$isSticky = true;

			}

			// Un-Shrink header function
			function destroySticky() {

				// Not shrunk
				if ( ! $isSticky ) return;

				// Remove sticky wrap height and toggle sticky class
				$stickyWrap
					.css( 'height', '' )
					.removeClass( 'is-sticky' )
					.addClass( 'not-sticky' );

				// Remove navbar width
				$navWrap.css( {
					'width' : '',
					'top'   : ''
				} );

				// Update shrunk var
				$isSticky = false;

			}

			// Sticky check / enable-disable
			function stickyCheck() {

				// Disable on mobile devices
				if ( self.config.$viewportWidth <= wpspLocalize.stickyNavbarBreakPoint ) {
					return;
				}

				// Sticky menu
				if ( self.config.$windowTop >= $setStickyPos && 0 !== self.config.$windowTop ) {
					setSticky();
				} else {
					destroySticky();
				}

			}

			// On resize function
			function onResize() {

				// Check if sticky is disabled on mobile if not destroy on resize
				if ( self.config.$viewportWidth <= wpspLocalize.stickyNavbarBreakPoint ) {
					destroySticky();
				}

				// Update width
				if ( $isSticky ) {
					$navWrap.css( 'width', $stickyWrap.width() );
				} else {
					stickyCheck();
				}

			}

			// Fire on init
			stickyCheck();

			// Fire onscroll event
			$window.scroll( function() {
				stickyCheck();
			} );

			// Fire onResize
			$window.resize( function() {
				onResize();
			} );

		},

		/**
		 * Set min height on main container to prevent issue with extra space below footer
		 *
		 * @since 1.0.0
		 */
		fixedFooter: function() {

			// Return if disabled
			if ( ! this.config.$hasFixedFooter ) {
				return;
			}

			// Get main wrapper
			var $main = $( '#page-wrapper' );

			// Make sure main exists
			if ( $main.length ) {

				// Set main vars
				var $mainHeight = $( '#page-wrapper' ).outerHeight(),
					$htmlHeight = $( 'html' ).height();
					//$adminHeight = $().height();

				// Check for footerReveal and add min height
				var $minHeight = $mainHeight + ( this.config.$window.height() - $htmlHeight );

				if ( this.config.$wpAdminBar ) {
					$minHeight = $minHeight - this.config.$wpAdminBar.outerHeight();
				}

				// Add min height
				$main.css( 'min-height', $minHeight );

			}
		},
	}

	wpspCustom.init();

} ) ( jQuery );	
/**
 * NFT Marketplace — frontend interactivity.
 */
( function () {
	'use strict';

	var data = window.nftsiteData || {};
	var i18n = data.i18n || {};
	var STORAGE_KEY = 'nftsite_session';
	var FOLLOWS_KEY = 'nftsite_follows';
	var LOADER_KEY = 'nftsite_loader_done';

	function prefersReducedMotion() {
		return window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	}

	/* ------------------------------------------------------------------ */
	/* Session                                                            */
	/* ------------------------------------------------------------------ */
	function getSession() {
		try {
			return JSON.parse( localStorage.getItem( STORAGE_KEY ) || '{}' ) || {};
		} catch ( e ) {
			return {};
		}
	}

	function setSession( next ) {
		localStorage.setItem( STORAGE_KEY, JSON.stringify( next ) );
		renderSessionChrome();
	}

	function getFollows() {
		try {
			return JSON.parse( localStorage.getItem( FOLLOWS_KEY ) || '[]' ) || [];
		} catch ( e ) {
			return [];
		}
	}

	function setFollows( list ) {
		localStorage.setItem( FOLLOWS_KEY, JSON.stringify( list ) );
	}

	function renderSessionChrome() {
		var core = window.nftsiteCore && window.nftsiteCore.currentUser;
		var walletEl = document.querySelector( '[data-session-wallet]' );
		var userEl = document.querySelector( '[data-session-user]' );
		var signupLabel = document.querySelector( '[data-signup-label]' );

		// SIWE / plugin session is the only real auth when nftsite-core is active.
		if ( window.nftsiteCore ) {
			if ( core && core.wallet ) {
				if ( walletEl ) {
					walletEl.hidden = false;
					walletEl.textContent = core.wallet.slice( 0, 6 ) + '…' + core.wallet.slice( -4 );
				}
				if ( userEl ) {
					userEl.hidden = false;
					userEl.textContent = core.name || 'Artist';
				}
				if ( signupLabel ) {
					signupLabel.textContent = core.name || 'Profile';
				}
			} else {
				if ( walletEl ) {
					walletEl.hidden = true;
					walletEl.textContent = '';
				}
				if ( userEl ) {
					userEl.hidden = true;
					userEl.textContent = '';
				}
			}
			return;
		}

		var session = getSession();
		if ( walletEl ) {
			walletEl.hidden = true;
			walletEl.textContent = '';
		}
		if ( userEl ) {
			if ( session.username ) {
				userEl.hidden = false;
				userEl.textContent = session.username;
			} else {
				userEl.hidden = true;
				userEl.textContent = '';
			}
		}
		if ( signupLabel && session.username ) {
			signupLabel.textContent = session.username;
		}
	}

	/* ------------------------------------------------------------------ */
	/* Toasts                                                             */
	/* ------------------------------------------------------------------ */
	function toast( message, type ) {
		var stack = document.getElementById( 'nftsite-toasts' );
		if ( ! stack || ! message ) {
			return;
		}
		var el = document.createElement( 'div' );
		el.className = 'toast' + ( type ? ' toast--' + type : '' );
		el.textContent = message;
		stack.appendChild( el );
		requestAnimationFrame( function () {
			el.classList.add( 'is-visible' );
		} );
		window.setTimeout( function () {
			el.classList.remove( 'is-visible' );
			window.setTimeout( function () {
				el.remove();
			}, 280 );
		}, 2800 );
	}

	/* ------------------------------------------------------------------ */
	/* Loader                                                             */
	/* ------------------------------------------------------------------ */
	function initLoader() {
		var loader = document.getElementById( 'nftsite-loader' );
		if ( ! loader ) {
			return;
		}

		try {
			var navEntry = performance.getEntriesByType && performance.getEntriesByType( 'navigation' )[0];
			if ( navEntry && navEntry.type === 'reload' ) {
				sessionStorage.removeItem( LOADER_KEY );
			}
		} catch ( e ) {}

		var skip = false;
		try {
			skip = sessionStorage.getItem( LOADER_KEY ) === '1';
		} catch ( e ) {}

		if ( skip || prefersReducedMotion() ) {
			loader.classList.add( 'is-done' );
			document.body.classList.add( 'is-loaded' );
			return;
		}

		var started = Date.now();
		var minMs = 700;

		function hide() {
			var wait = Math.max( 0, minMs - ( Date.now() - started ) );
			window.setTimeout( function () {
				loader.classList.add( 'is-done' );
				document.body.classList.add( 'is-loaded' );
				try {
					sessionStorage.setItem( LOADER_KEY, '1' );
				} catch ( e ) {}
			}, wait );
		}

		if ( document.readyState === 'complete' ) {
			hide();
		} else {
			window.addEventListener( 'load', hide );
		}
	}

	/* ------------------------------------------------------------------ */
	/* Reveal on scroll                                                   */
	/* ------------------------------------------------------------------ */
	function initReveals() {
		var items = document.querySelectorAll( '.reveal' );
		if ( ! items.length ) {
			return;
		}
		if ( prefersReducedMotion() || ! ( 'IntersectionObserver' in window ) ) {
			items.forEach( function ( el ) {
				el.classList.add( 'is-revealed' );
			} );
			return;
		}
		var io = new IntersectionObserver(
			function ( entries ) {
				entries.forEach( function ( entry ) {
					if ( entry.isIntersecting ) {
						entry.target.classList.add( 'is-revealed' );
						io.unobserve( entry.target );
					}
				} );
			},
			{ rootMargin: '0px 0px -40px 0px', threshold: 0.08 }
		);
		items.forEach( function ( el, index ) {
			el.style.transitionDelay = Math.min( index % 6, 5 ) * 60 + 'ms';
			io.observe( el );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Nav                                                                */
	/* ------------------------------------------------------------------ */
	function initNav() {
		var navToggle = document.querySelector( '.nav-toggle' );
		var siteNav = document.querySelector( '.site-nav' );
		if ( ! navToggle || ! siteNav ) {
			return;
		}

		function closeNav() {
			siteNav.classList.remove( 'is-open' );
			navToggle.setAttribute( 'aria-expanded', 'false' );
			document.body.classList.remove( 'nav-open' );
		}

		function openNav() {
			siteNav.classList.add( 'is-open' );
			navToggle.setAttribute( 'aria-expanded', 'true' );
			document.body.classList.add( 'nav-open' );
		}

		navToggle.addEventListener( 'click', function () {
			if ( siteNav.classList.contains( 'is-open' ) ) {
				closeNav();
			} else {
				openNav();
			}
		} );

		document.addEventListener( 'click', function ( event ) {
			if (
				siteNav.classList.contains( 'is-open' ) &&
				! siteNav.contains( event.target ) &&
				! navToggle.contains( event.target )
			) {
				closeNav();
			}
		} );

		siteNav.querySelectorAll( 'a' ).forEach( function ( link ) {
			link.addEventListener( 'click', closeNav );
		} );

		document.addEventListener( 'keydown', function ( event ) {
			if ( event.key === 'Escape' ) {
				closeNav();
			}
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Countdown                                                          */
	/* ------------------------------------------------------------------ */
	function initCountdowns() {
		document.querySelectorAll( '[data-countdown]' ).forEach( function ( timer ) {
			var raw = ( timer.getAttribute( 'data-countdown' ) || '' ).trim();
			if ( ! raw || raw === '0:0:0' ) {
				return;
			}
			var hoursEl = timer.querySelector( '[data-unit="hours"]' );
			var minutesEl = timer.querySelector( '[data-unit="minutes"]' );
			var secondsEl = timer.querySelector( '[data-unit="seconds"]' );
			var parts = raw.split( ':' ).map( Number );
			var total =
				( ( parts[0] || 0 ) * 3600 ) +
				( ( parts[1] || 0 ) * 60 ) +
				( parts[2] || 0 );
			if ( total <= 0 ) {
				return;
			}

			function pad( value ) {
				return String( value ).padStart( 2, '0' );
			}

			function render() {
				var hours = Math.floor( total / 3600 );
				var minutes = Math.floor( ( total % 3600 ) / 60 );
				var seconds = total % 60;
				if ( hoursEl ) {
					hoursEl.textContent = pad( hours );
				}
				if ( minutesEl ) {
					minutesEl.textContent = pad( minutes );
				}
				if ( secondsEl ) {
					secondsEl.textContent = pad( seconds );
				}
			}

			render();
			window.setInterval( function () {
				if ( total <= 0 ) {
					return;
				}
				total -= 1;
				render();
			}, 1000 );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Marketplace                                                        */
	/* ------------------------------------------------------------------ */
	function initMarketplace() {
		var marketplace = document.querySelector( '.marketplace-page' );
		if ( ! marketplace ) {
			return;
		}

		var tabButtons = marketplace.querySelectorAll( '[data-tab]' );
		var panels = marketplace.querySelectorAll( '[data-panel]' );
		var searchInput = marketplace.querySelector( '#marketplace-search-input' );
		var searchForm = marketplace.querySelector( '.marketplace-search' );

		function filterCards() {
			var query = ( searchInput ? searchInput.value : '' ).trim().toLowerCase();
			var activePanel = marketplace.querySelector( '.marketplace-panel.is-active' );
			if ( ! activePanel ) {
				return;
			}
			var cards = activePanel.querySelectorAll( '.marketplace-card' );
			var empty = activePanel.querySelector( '.marketplace-empty' );
			var visible = 0;
			cards.forEach( function ( card ) {
				var haystack = card.getAttribute( 'data-search' ) || '';
				var match = ! query || haystack.indexOf( query ) !== -1;
				card.classList.toggle( 'is-hidden', ! match );
				if ( match ) {
					visible += 1;
				}
			} );
			if ( empty ) {
				empty.hidden = visible > 0;
			}
		}

		function activateTab( tabName ) {
			tabButtons.forEach( function ( button ) {
				var isActive = button.getAttribute( 'data-tab' ) === tabName;
				button.classList.toggle( 'is-active', isActive );
				button.setAttribute( 'aria-selected', isActive ? 'true' : 'false' );
			} );
			panels.forEach( function ( panel ) {
				var isActive = panel.getAttribute( 'data-panel' ) === tabName;
				panel.classList.toggle( 'is-active', isActive );
				if ( isActive ) {
					panel.removeAttribute( 'hidden' );
				} else {
					panel.setAttribute( 'hidden', 'hidden' );
				}
			} );
			filterCards();
		}

		tabButtons.forEach( function ( button ) {
			button.addEventListener( 'click', function () {
				activateTab( button.getAttribute( 'data-tab' ) );
			} );
		} );

		if ( searchInput ) {
			searchInput.addEventListener( 'input', filterCards );
		}
		if ( searchForm ) {
			searchForm.addEventListener( 'submit', function ( event ) {
				event.preventDefault();
				filterCards();
			} );
		}
	}

	/* ------------------------------------------------------------------ */
	/* Rankings                                                           */
	/* ------------------------------------------------------------------ */
	function initRankings() {
		var tabs = document.querySelectorAll( '[data-rankings-tab]' );
		if ( ! tabs.length ) {
			return;
		}

		function applyPeriod( period ) {
			document.querySelectorAll( '[data-rankings-row]' ).forEach( function ( row ) {
				var raw = row.getAttribute( 'data-periods' );
				if ( ! raw ) {
					return;
				}
				var periods;
				try {
					periods = JSON.parse( raw );
				} catch ( e ) {
					return;
				}
				var stats = periods[ period ] || periods.today;
				if ( ! stats ) {
					return;
				}
				var changeEl = row.querySelector( '[data-rankings-change]' );
				var soldEl = row.querySelector( '[data-rankings-sold]' );
				var volumeEl = row.querySelector( '[data-rankings-volume]' );
				if ( changeEl ) {
					changeEl.textContent = stats.change;
				}
				if ( soldEl ) {
					soldEl.textContent = stats.sold;
				}
				if ( volumeEl ) {
					volumeEl.textContent = stats.volume;
				}
			} );
		}

		tabs.forEach( function ( button ) {
			button.addEventListener( 'click', function () {
				tabs.forEach( function ( tab ) {
					var active = tab === button;
					tab.classList.toggle( 'is-active', active );
					tab.setAttribute( 'aria-selected', active ? 'true' : 'false' );
				} );
				applyPeriod( button.getAttribute( 'data-rankings-tab' ) );
			} );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Artist                                                             */
	/* ------------------------------------------------------------------ */
	function initArtist() {
		var artistTabs = document.querySelectorAll( '[data-artist-tab]' );
		var artistPanels = document.querySelectorAll( '[data-artist-panel]' );

		artistTabs.forEach( function ( button ) {
			button.addEventListener( 'click', function () {
				var target = button.getAttribute( 'data-artist-tab' );
				artistTabs.forEach( function ( tab ) {
					var active = tab === button;
					tab.classList.toggle( 'is-active', active );
					tab.setAttribute( 'aria-selected', active ? 'true' : 'false' );
				} );
				artistPanels.forEach( function ( panel ) {
					var active = panel.getAttribute( 'data-artist-panel' ) === target;
					panel.classList.toggle( 'is-active', active );
					if ( active ) {
						panel.removeAttribute( 'hidden' );
					} else {
						panel.setAttribute( 'hidden', 'hidden' );
					}
				} );
			} );
		} );

		document.querySelectorAll( '[data-copy-wallet]' ).forEach( function ( copyBtn ) {
			copyBtn.addEventListener( 'click', function () {
				var value = copyBtn.getAttribute( 'data-copy-wallet' ) || '';
				var label = copyBtn.querySelector( '.artist-profile__wallet-text' );
				var previous = label ? label.textContent : '';

				function done() {
					toast( i18n.copied || 'Copied!' );
					if ( label ) {
						label.textContent = i18n.copied || 'Copied!';
						window.setTimeout( function () {
							label.textContent = previous;
						}, 1200 );
					}
				}

				if ( navigator.clipboard && value ) {
					navigator.clipboard.writeText( value ).then( done ).catch( function () {
						done();
					} );
				} else {
					done();
				}
			} );
		} );

		document.querySelectorAll( '[data-follow-artist]' ).forEach( function ( btn ) {
			if ( window.nftsiteCore ) {
				return;
			}
			var artistId = btn.getAttribute( 'data-follow-artist' );
			var label = btn.querySelector( '.artist-profile__follow-text' );
			var follows = getFollows();
			var isFollowing = follows.indexOf( artistId ) !== -1;

			function sync() {
				btn.classList.toggle( 'is-following', isFollowing );
				if ( label ) {
					label.textContent = isFollowing ? ( i18n.following || 'Following' ) : ( i18n.follow || 'Follow' );
				}
			}

			sync();

			btn.addEventListener( 'click', function () {
				follows = getFollows();
				var idx = follows.indexOf( artistId );
				if ( idx === -1 ) {
					follows.push( artistId );
					isFollowing = true;
					toast( i18n.following || 'Following' );
				} else {
					follows.splice( idx, 1 );
					isFollowing = false;
					toast( i18n.follow || 'Follow' );
				}
				setFollows( follows );
				sync();
			} );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* NFT bid / wallet / account / newsletter                            */
	/* ------------------------------------------------------------------ */
	function initBids() {
		document.querySelectorAll( '[data-place-bid]' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var session = getSession();
				if ( ! session.wallet ) {
					toast( i18n.needWallet || 'Connect a wallet to place a bid.' );
					if ( data.connectWalletUrl ) {
						window.setTimeout( function () {
							window.location.href = data.connectWalletUrl;
						}, 700 );
					}
					return;
				}
				toast( i18n.bidPlaced || 'Bid placed successfully (demo).', 'success' );
			} );
		} );
	}

	function initConnectWallet() {
		document.querySelectorAll( '[data-connect-wallet]' ).forEach( function ( btn ) {
			btn.addEventListener( 'click', function () {
				var provider = btn.getAttribute( 'data-connect-wallet' ) || 'Wallet';
				var session = getSession();
				session.wallet = provider;
				setSession( session );
				document.querySelectorAll( '.connect-wallet__option' ).forEach( function ( el ) {
					el.classList.toggle( 'is-connected', el === btn );
				} );
				toast( ( i18n.walletOk || 'Wallet connected.' ) + ' (' + provider + ')', 'success' );
			} );
		} );
	}

	function initCreateAccount() {
		var form = document.querySelector( '[data-create-account-form]' );
		if ( ! form ) {
			return;
		}
		form.addEventListener( 'submit', function ( event ) {
			event.preventDefault();
			var username = ( form.querySelector( '[name="username"]' ) || {} ).value || '';
			var email = ( form.querySelector( '[name="email"]' ) || {} ).value || '';
			var password = ( form.querySelector( '[name="password"]' ) || {} ).value || '';
			var confirm = ( form.querySelector( '[name="confirm_password"]' ) || {} ).value || '';

			username = username.trim();
			email = email.trim();

			if ( ! username || ! email || ! password || ! confirm ) {
				toast( i18n.invalidForm || 'Please fill in all fields correctly.' );
				return;
			}
			if ( password !== confirm ) {
				toast( i18n.passwordMatch || 'Passwords do not match.' );
				return;
			}

			var session = getSession();
			session.username = username;
			session.email = email;
			setSession( session );
			toast( i18n.accountOk || 'Account created. Welcome!', 'success' );
			window.setTimeout( function () {
				window.location.href = data.marketplaceUrl || data.homeUrl || '/';
			}, 900 );
		} );
	}

	function initNewsletters() {
		document.querySelectorAll( '[data-newsletter-form]' ).forEach( function ( form ) {
			form.addEventListener( 'submit', function ( event ) {
				event.preventDefault();
				var input = form.querySelector( 'input[type="email"]' );
				if ( ! input || ! input.value.trim() ) {
					toast( i18n.invalidForm || 'Please fill in all fields correctly.' );
					return;
				}
				toast( i18n.subscribed || 'You are subscribed!', 'success' );
				input.value = '';
			} );
		} );
	}

	function initToastSoon() {
		document.querySelectorAll( '[data-toast-soon]' ).forEach( function ( link ) {
			link.addEventListener( 'click', function ( event ) {
				event.preventDefault();
				toast( i18n.comingSoon || 'Coming soon.' );
			} );
		} );
	}

	/* ------------------------------------------------------------------ */
	/* Boot                                                               */
	/* ------------------------------------------------------------------ */
	initLoader();
	initNav();
	initCountdowns();
	initMarketplace();
	initRankings();
	initArtist();
	initToastSoon();
	renderSessionChrome();
	initReveals();

	// When nftsite-core is active, wallet.js owns auth / bid / follow / newsletter.
	if ( ! window.nftsiteCore ) {
		initBids();
		initConnectWallet();
		initCreateAccount();
		initNewsletters();
	}
}() );

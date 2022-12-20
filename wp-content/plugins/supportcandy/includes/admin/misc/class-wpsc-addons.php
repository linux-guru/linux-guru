<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly!
}

if ( ! class_exists( 'WPSC_Addons' ) ) :

	final class WPSC_Addons {

		/**
		 * Initialize this class
		 *
		 * @return void
		 */
		public static function init() {}

		/**
		 * List of all supportcandy add-ons
		 *
		 * @return void
		 */
		public static function layout() {
			?>

			<style>
				section {
					color: #7a90ff;
					padding: 2em 0;
					min-height: 100%;
					position: relative;
					-webkit-font-smoothing: antialiased;
					z-index: 10;
				}

				.pricing {
					display: -webkit-flex;
					display: flex;
					-webkit-flex-wrap: wrap;
					flex-wrap: wrap;
					-webkit-justify-content: center;
					justify-content: center;
					width: 100%;
					margin: 0 auto;
				}

				.pricing-item {
					position: relative;
					display: -webkit-flex;
					display: flex;
					-webkit-flex-direction: column;
					flex-direction: column;
					-webkit-align-items: stretch;
					align-items: stretch;
					text-align: center;
					-webkit-flex: 0 1 330px;
					flex: 0 1 275px;
				}

				.pricing-action .a{
					color: inherit;
					border: none;
					background: none;
					cursor: pointer;
				}

				.pricing-action:focus {
					outline: none;
				}

				.pricing-feature-list {
					text-align: left;
				}

				.pricing-palden .pricing-item {
					font-family: 'Open Sans', sans-serif;
					cursor: default;
					color: #313042;
					background: #fff;
					box-shadow: 0 0 10px rgba(46, 59, 125, 0.23);
					border-radius: 20px 20px 10px 10px;
					margin: 1em;
				}

				.pricing-item li {
					border-bottom: 1px solid #d3d3d3;
				}

				.pricing-item ul {
					list-style-type: none;
				}

				.pricing-item li:nth-child(n+1):nth-last-child(-n) {
					border:none;
				}

				@media screen and (min-width: 66.25em) {
					.pricing-palden .pricing-item {
						margin: 1em 1em;
					}
				}

				.pricing-palden .pricing-deco {
					border-radius: 10px 10px 0 0;
					background: linear-gradient(180deg, #67B26F 0%, #4CA2CD 100%);
					padding: 3em 0 2em;
					position: relative;
				}

				.pricing-palden .pricing-deco-img {
					position: absolute;
					bottom: 0;
					left: 0;
					width: 100%;
					height: 160px;
				}

				.pricing-palden .pricing-title {
					font-size: 1.5em;
					padding-bottom: 1em;
					margin: 0;
					text-transform: uppercase;
					letter-spacing: 2px;
					color: #fff;
				}

				.pricing-palden .deco-layer {
					-webkit-transition: -webkit-transform 0.5s;
					transition: transform 0.5s;
				}

				.pricing-palden .pricing-item:hover .deco-layer--1 {
					-webkit-transform: translate3d(15px, 0, 0);
					transform: translate3d(15px, 0, 0);
				}

				.pricing-palden .pricing-item:hover .deco-layer--2 {
					-webkit-transform: translate3d(-15px, 0, 0);
					transform: translate3d(-15px, 0, 0);
				}

				.pricing-palden .icon {
					font-size: 2.5em;
				}

				.pricing-palden .pricing-price {
					font-size: 3.5em;
					font-weight: bold;
					padding: 0;
					color: #fff;
					line-height: 0.75;
				}

				.pricing-palden .pricing-currency {
					font-size: 0.35em;
					vertical-align: top;
				}

				.pricing-palden .pricing-period {
					font-size: 0.25em;
					padding: 0 0 0 0.5em;
					font-style: italic;
				}

				.pricing-palden .pricing__sentence {
					font-weight: bold;
					margin: 0 0 1em 0;
					padding: 0 0 0.5em;
				}

				.pricing-palden .pricing-feature-list {
					margin: 0;
					padding: 2em 2.5em;
					list-style: none;
					text-align: left;
				}

				.pricing-palden .pricing-feature {
					padding: 0.5em 0;
				}

				.pricing-palden .pricing-action {
					font-weight: bold;
					margin: auto 3em 2em 3em;
					padding: 1em 2em;
					color: #fff;
					border-radius: 30px;
					background: linear-gradient(180deg, #4CA2CD 0%, #67B26F 100%);
					-webkit-transition: background-color 0.3s;
					transition: background-color 0.3s;
					text-decoration: none;
				}

				.pricing-palden .pricing-action:hover, .pricing-palden .pricing-action:focus {
					background: linear-gradient(to top, #37ecba 0%, #72afd3 100%);
					text-decoration: none;
				}

				.pricing-palden .pricing-item--featured .pricing-deco {
					padding: 5em 0 8.885em 0;
				}

				.header {
					position: relative;
					text-align: center;
					color: white;
				}

				.inner-header {
					height: 100%;
					width: 100%;
					margin: 0;
					padding: 0;
				}				
			</style>

			<div class="wrap">
				<hr class="wp-header-end">
				<div class="header">
					<div class="inner-header">
						<section>
							<div class="pricing pricing-palden">
								<div class="pricing-item features-item ja-animate">
									<div class="pricing-deco">
										<h3 class="pricing-title">Starter</h3>
										<div class="pricing-price">
											<span class="pricing-currency">$</span>49.99
											<div><span class="pricing-period">Billed yearly, until cancelled</span></div>
										</div>
									</div>
									<ul class="pricing-feature-list">
										<li class="pricing-feature">&#8680;	7 Premium addons</li>
										<li class="pricing-feature">&#8680;	Priority support</li>
									</ul>
									<a class="pricing-action" href="https://supportcandy.net/starter-bundle/" target="__blank">View Details</a>
								</div>
								<div class="pricing-item features-item ja-animate">
									<div class="pricing-deco">
										<h3 class="pricing-title">Econom</h3>
										<div class="pricing-price">
											<span class="pricing-currency">$</span>99.99
											<div><span class="pricing-period">Billed yearly, until cancelled</span></div>
										</div>
									</div>
									<ul class="pricing-feature-list">
										<li class="pricing-feature">&#8680;	12 Premium addons</li>
										<li class="pricing-feature">&#8680;	Priority support</li>
									</ul>
									<a class="pricing-action" href="https://supportcandy.net/econom-bundle/" target="__blank">View Details</a>
								</div>
								<div class="pricing-item features-item ja-animate">
									<div class="pricing-deco">
										<h3 class="pricing-title">Standard</h3>
										<div class="pricing-price">
											<span class="pricing-currency">$</span>149.99
											<div><span class="pricing-period">Billed yearly, until cancelled</span></div>
										</div>
									</div>
									<ul class="pricing-feature-list">
										<li class="pricing-feature">&#8680;	19 Premium addons</li>
										<li class="pricing-feature">&#8680;	Priority support</li>
										<li class="pricing-feature">&#8680;	All future addons</li>
									</ul>
									<a class="pricing-action" href="https://supportcandy.net/standard-bundle/" target="__blank">View Details</a>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
			<?php
		}
	}
endif;

WPSC_Addons::init();

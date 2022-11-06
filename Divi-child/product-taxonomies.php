<?php
/**
 * Product Taxonomies
 *
 * @package @generatepress
 */

// phpcs:disable Generic.Arrays.DisallowShortArraySyntax

/**
 * .ini file parser.
 *
 * For administrators:
 *
 * File is in the same directory as this file and called with the same name
 * but with a .ini extension.
 *
 * The format of the ini file is as follows:
 *
 * [category.*]
 *
 * style = *
 * style._limit = 1
 *
 * subject = *
 * subject._limit = 1
 *
 * color = *
 * color._limit = 3
 *
 * [category.drawing]
 * medium = charcoal, conte, digital, graphite, mixed, pastels, pen-and-ink, pencil, other
 * medium._limit = 1
 *
 * type = framed, unframed
 * type._limit = 1
 *
 * [category.fine-craft]
 * medium = bamboo, ceramics, and-so-on
 * medium._limit = 1
 *
 * First define the outermost taxonomy and all the limits and catch-all conditions.
 * All keywords are in the taxonomy.term format, limits are set via taxonomy._limit keys.
 * taxonomy.* means all terms. As does * mean all terms
 * All terms and taxnomies are defined by their slugs.
 *
 * Sections define conditional logic rules for the term. In the example above as
 * read by a human: all the terms in category will show all style, subject and color
 * terms. Style, subject and color limits are 1, 1, 3 respectively.
 * For the drawing term in the category taxonomy only show charcoal, conte, digital, etc.
 * medium taxonomy terms. Medium is limited to 1 selection. For type show only framed and unframed
 * terms. Limited to 1 selection as well.

 *
 * For developers:
 *
 * @return [ $taxmap, $limitmap, $allterms ] where:
 *
 * $taxmap is a conditional logic map for taxonomies. Layout:
 *
 * [
 *   'category' => [
 *     'drawing' => [
 *       'medium' => [ 'charcoal', 'conte', 'digital', 'graphite', 'mixed media', 'other', ],
 *       'type' => [ 'framed', 'unframed' ],
 *       'style' => [ '*' ], // A nice meaning for ALL, i.e. show them all, don't hide anything.
 *       'subject' => [ '*' ],
 *       'color' => [ '*' ],
 *     ],
 *     'fine-craft' => [
 *       'medium' => [ 'bamboo', 'ceramics', 'glass', 'metal', 'other', ],
 *       'type' => [ 'containers', 'other', 'ceiling' ],
 *       'style' => [ '*' ],
 *       'subject' => [ '*' ],
 *       'color' => [ '*' ],
 *     ],
 *     'paper' => [
 *       'medium' => [ 'collagraphs', 'other' ],
 *       'type' => [ 'framed', 'unframed' ],
 *       'style' => [ '*' ],
 *       'subject' => [ '*' ],
 *       'color' => [ '*' ],
 *     ],
 *   ],
 *   'style' => [
 *     'geometric' => [ '*' ],
 *   ]
 * ]
 *
 * Note: if a taxonomy/term is not listed (targetable) then leave the UI as is, no rule change.
 * It just means there are no conditions that are propagated from it.
 *
 * Example: if a user clicks Category/Drawing you'll find propagation rules. Apply them.
 * Example: if a user then clicks Type/Framed you won't find propagation rules. Do nothing.
 *
 * An asterix (*) pseudoterm stands for show all terms in the taxonomy.
 *
 *
 * $limitmap is how many terms should be selectable at most. 0 for no limit (default). Layout:
 *
 * [
 *   'category' => 1,
 *   'color' => 3,
 * ]
 *
 *
 * $allterms is an array of all the terms inside a defined taxonomy. Any taxonomies not defined
 * in the ini file will not be output here in the default `get_terms` WordPress format.
 */
function dpt_parse_product_taxonomies_ini() {
	static $config;

	if ( $config ) {
		return $config;
	}

	$parsed = parse_ini_file( str_replace( '.php', '.ini', __FILE__ ), true );

	if ( ! $parsed ) {
		return;
	}

	$taxmap   = [];
	$limitmap = [];
	$allterms = [];

	foreach ( $parsed as $section => $values ) {
		list( $taxonomy, $term ) = explode( '.', $section );

		$taxmap[ $taxonomy ]   = isset( $taxmap[ $taxonomy ] ) ? $taxmap[ $taxonomy ] : [];
		$limitmap[ $taxonomy ] = isset( $limitmap[ $taxonomy ] ) ? $limitmap[ $taxonomy ] : 0;

		if ( empty( $allterms[ $taxonomy ] ) ) {
			$allterms[ $taxonomy ] = get_terms(
				[
					'taxonomy'   => $taxonomy,
					'hide_empty' => false,
				]
			);
		}

		foreach ( $values as $key => $value ) {
			if ( strpos( $key, '._limit' ) ) {
				$limitmap[ str_replace( '._limit', '', $key ) ] = $value;
				continue;
			}

			$limitmap[ $key ] = isset( $limitmap[ $key ] ) ? $limitmap[ $key ] : 0;
			if ( empty( $allterms[ $key ] ) ) {
				$allterms[ $key ] = get_terms(
					[
						'taxonomy'   => $key,
						'hide_empty' => false,
					]
				);
			}

			if ( '*' === $term ) {
				foreach ( wp_list_pluck( $allterms[ $taxonomy ], 'slug' ) as $_term ) {
					$taxmap[ $taxonomy ][ $_term ][ $key ] = [ '*' ];
				}
			} else {
				$taxmap[ $taxonomy ][ $term ][ $key ] = array_map( 'trim', explode( ',', $value ) );
			}
		}
	}

	$config = [ $taxmap, $limitmap, $allterms ];

	return $config;
}

/**
 * The main product category selection UI.
 */
add_action(
	'dokan_new_product_after_product_tags',
	$callback = function( $post = null, $post_id = null ) {
		$parsed = dpt_parse_product_taxonomies_ini();

		if ( ! $parsed ) {
			return; // Uh-oh.
		}

		list( $_, $limitmap, $allterms ) = $parsed;

		$add_nonce  = isset( $_REQUEST['dokan_add_new_product_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['dokan_add_new_product_nonce'] ) ), 'dokan_add_new_product' );
		$edit_nonce = isset( $_REQUEST['dokan_edit_product_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['dokan_edit_product_nonce'] ) ), 'dokan_edit_product' );
		$posted     = ( ( $add_nonce || $edit_nonce ) && ! empty( $_POST ) ) ? $_POST : null;
		?>
		<div class="dpt-all-terms">
			<?php
			foreach ( $allterms as $key => $taxonomy ) :
				$input_type   = ( $limitmap && $limitmap[ $key ] && '1' === $limitmap[ $key ] ) ? 'radio' : 'checkbox';
				$input_array  = ( 'checkbox' === $input_type ) ? '[]' : '';
				$limit        = ( $limitmap && $limitmap[ $key ] ) ? $limitmap[ $key ] : null;
				$max_limit    = ( $limit && $limit > 1 ) ? $limit : '';
				$tax          = get_taxonomy( $key );
				$tax_label    = ( $tax && $tax->label ) ? $tax->label : '';
				//$posted_terms = ( ! empty( $_POST[ $key ] ) && is_array( $_POST[ $key ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $key ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
				$posted_terms = ( ! empty( $_POST[ $key ] ) && is_array( $_POST[ $key ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $key ] ) ) : "" );
				?>
				<div class="term-wrap" data-tax="<?php echo esc_attr( $key ); ?>" data-limit="<?php echo esc_attr( $limit ); ?>">
					<label class="form-label"><?php echo esc_html( $tax_label ); ?></label>

					<?php if ( $max_limit ) : ?>
						<span class="data-limit-note">Please select at least 1 <?php echo esc_html( $tax_label ); ?>.<br/>Maximum: <?php echo esc_html( $max_limit ); ?> <?php echo esc_html( $tax_label ); ?>s.</span>
					<?php endif; ?>

					<?php
					foreach ( $taxonomy as $term ) :
						$checked = ( is_array( $posted_terms ) && in_array( $term->slug, $posted_terms, true ) ) ? 'checked' : (( $term->slug === $posted_terms ) ? 'checked' : '');
						?>
						<label><input name="<?php echo esc_attr( $term->taxonomy . $input_array ); ?>" type="<?php echo esc_attr( $input_type ); ?>" value="<?php echo esc_attr( $term->slug ); ?>" data-term="<?php echo esc_attr( $term->slug ); ?>" <?php echo esc_attr( $checked ); ?>> <?php echo esc_html( $term->name ); ?></label>
					<?php endforeach; ?>
				</div>
			<?php endforeach; ?>

			<style>
				.dpt-all-terms .term-wrap {
					display: none;
					margin: 15px 0;
				}

				.dpt-all-terms .term-wrap label {
					text-transform: capitalize;
					display: block;
				}

				.dpt-all-terms .term-wrap span {
					margin-bottom: 5px;
					display: inline-block;
				}

				.dpt-all-terms .term-wrap:first-child {
					display: block;
				}

				.dpt-all-terms .term-wrap.tax-error {
					background: rgba(255, 0, 0, 0.1);
					padding: 10px 10px 5px;
				}

				.dpt-all-terms .term-wrap .tax-error-message {
					font-weight: 700;
					color: #ea2d04;
					margin-bottom: 7.5px;
				}
			</style>
		</div>
		<?php
	}
);
add_action( 'dokan_product_edit_after_product_tags', $callback, 10, 2 );


/**
 * Add product taxonomy script.
 *
 * @return void
 */
add_action(
	'dokan_new_product_form',
	function( $post = null ) {
		$current_terms = [];

		if ( $post && $post->ID ) {
			foreach ( get_post_taxonomies( $post->ID ) as $taxonomy ) {
				$current_terms[ $taxonomy ] = get_the_terms( $post->ID, $taxonomy );
			}
		}

		$parsed = dpt_parse_product_taxonomies_ini();

		if ( ! $parsed ) {
			return; // Uh-oh.
		}

		list( $taxmap, $_, $_ ) = $parsed;
		?>
		<script>
			jQuery(document).ready(function($){
				const allTermsWrap = $( '.dpt-all-terms' );

				if ( allTermsWrap.length ) {
					const taxMap = <?php echo wp_json_encode( $taxmap ); ?>;
					const currentTerms = <?php echo wp_json_encode( $current_terms ); ?>;
					const inputs = allTermsWrap.find( 'input' );

					// show/hide cascade fields based on terms
					function cascadeFields( taxTerms ) {
						$.each( taxTerms, function ( key, terms ) {
							const termsWrap = allTermsWrap.find(
								'[data-tax="' + key + '"]'
							);
							const termInputs = termsWrap.find( 'input' );

							termInputs.parent().hide(); // hide all fields
							termsWrap.show(); // show wrapper

							termInputs.each( function () {
								if (
									terms &&
									( terms[ 0 ] === '*' ||
										terms.includes( $( this ).attr( 'data-term' ) ) )
								) {
									$( this ).parent().show(); // show label if * or term exists
								} else {
									$( this ).parent().hide(); // hide fields
									$( this ).prop( 'checked', 0 ); // uncheck inputs to avoid posting the hidden ones
								}
							} );

							checkboxLimit( termsWrap ); // check limit and enable/disable inputs if needed
						} );
					}

					// cascade logic on input change
					inputs.on( 'change', function () {
						triggerErrorMessage(
							$( this ).parents( '.term-wrap' ),
							false,
							true
						);

						const checkedInputs = allTermsWrap.find( 'input:checked' ); // get selected terms

						if ( checkedInputs.length ) {
							const selectedTerms = {};

							// populate object based on selection
							checkedInputs.each( function () {
								if (
									! selectedTerms[
										$( this ).parents( '.term-wrap' ).attr( 'data-tax' )
									]
								) {
									selectedTerms[
										$( this ).parents( '.term-wrap' ).attr( 'data-tax' )
									] = [];
								}

								selectedTerms[
									$( this ).parents( '.term-wrap' ).attr( 'data-tax' )
								].push( $( this ).attr( 'data-term' ) );
							} );

							// go through each terms in selection and cascade if needed
							if ( selectedTerms ) {
								$.each( selectedTerms, function ( index, terms ) {
									$.each( terms, function ( termIndex, term ) {
										if (
											taxMap &&
											taxMap[ index ] &&
											taxMap[ index ][ term ]
										) {
											cascadeFields( taxMap[ index ][ term ] );
										}
									} );
								} );
							}
						}
					} );

					// Check if field is limited to more than 1 item and disable/enable inputs if needed
					function checkboxLimit( wrap ) {
						const limit = wrap.attr( 'data-limit' )
							? parseInt( wrap.attr( 'data-limit' ) )
							: null;

						if ( limit ) {
							const count = wrap.find( 'input:checkbox:checked' ).length;

							if ( count > limit ) {
								triggerErrorMessage( wrap, limit );

								wrap.find( 'input:checkbox:not(":checked")' ).attr(
									'disabled',
									'disabled'
								);
							} else if ( count === limit ) {
								triggerErrorMessage( wrap, false, true );

								wrap.find( 'input:checkbox:not(":checked")' ).attr(
									'disabled',
									'disabled'
								);
							} else if (
								count === 0 &&
								wrap.find( 'input:checkbox:not(":checked")' ).length
							) {
								triggerErrorMessage( wrap );

								wrap.find( 'input:checkbox:not(":checked")' ).removeAttr(
									'disabled'
								);
							} else {
								wrap.find( 'input:checkbox:not(":checked")' ).removeAttr(
									'disabled'
								);
							}
						}
					}

					// Handle checkbox change
					const checkboxes = allTermsWrap.find(
						'.term-wrap input[type="checkbox"]'
					);
					checkboxes.on( 'change', function () {
						checkboxLimit( $( this ).parent().parent() ); // check limit and enable/disable inputs if needed
					} );

					// Pre-populate fields on load if terms are set
					if ( ! jQuery.isEmptyObject( currentTerms ) ) {
						$.each( currentTerms, function ( key, terms ) {
							const taxWrap = allTermsWrap.find( '[data-tax="' + key + '"]' );

							if ( taxWrap.length && terms.length ) {
								$.each( terms, function ( index, term ) {
									taxWrap
										.find( 'input[data-term="' + term.slug + '"]' )
										.prop( 'checked', 1 )
										.change(); // use change to trigger cascade logic
								} );
							}
						} );
					}

					// Pre-populate if terms are in POST data
					allTermsWrap.find('input:checked').first().prop( 'checked', 1 ).change();

					// Validate taxonomies
					$( '.dokan-dashboard-content form' ).on( 'submit', function ( e ) {
						// e.preventDefault();

						const form = this;
						let errors = 0;

						allTermsWrap.find( '.term-wrap' ).each( function () {
							const limit = $( this ).attr( 'data-limit' );
							let checked = 0;

							$( this )
								.find( 'input' )
								.each( function () {
									if ( $( this ).is( ':checked' ) ) {
										checked++;
									}
								} );

							if ( checked === 0 ) {
								triggerErrorMessage( $( this ) );
								errors++;
							} else if ( checked > limit ) {
								triggerErrorMessage( $( this ), limit );
								errors++;
							}
						} );

						if ( errors ) {
							const topError = allTermsWrap
								.find( '.tax-error' )
								.first()
								.offset();

							window.scrollTo( {
								top: topError.top,
								behavior: 'smooth',
							} );

							return false;
						} else {
							return true;
						}
					} );

					// Trigger error messages
					function triggerErrorMessage( wrap, limit = false, reset = false ) {
						// Reset error
						wrap.removeClass( 'tax-error' );
						wrap.find( 'p.tax-error-message' ).remove();

						if ( reset ) {
							return;
						}

						// Set error
						wrap.addClass( 'tax-error' );

						if ( limit ) {
							wrap.find( 'label.form-label' ).after(
								'<p class="tax-error-message">Error! ' +
									wrap.find( 'label.form-label' ).text() +
									' limit cannot exceed ' +
									limit +
									' items.</p>'
							);
						} else {
							wrap.find( 'label.form-label' ).after(
								'<p class="tax-error-message">Error! Please select a ' +
									wrap.find( 'label.form-label' ).text() +
									'.</p>'
							);
						}
					}
				}
			} );
		</script>
		<?php
	}
);


/**
 * Save custom taxnomies on Dokan product creation/editing.
 *
 * @param int $post_id
 * @return void
 */
add_action(
	'woocommerce_process_product_meta',
	$callback = function( $post_id ) {
		$parsed = dpt_parse_product_taxonomies_ini();

		if ( ! $parsed ) {
			return; // Uh-oh.
		}

		list( $_, $_, $allterms ) = $parsed;

		if ( ! is_array( $allterms ) || empty( $allterms ) ) {
			return; // Uh-oh.
		}

		$taxonomies = array_keys( $allterms );

		$add_nonce  = isset( $_REQUEST['dokan_add_new_product_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['dokan_add_new_product_nonce'] ) ), 'dokan_add_new_product' );
		$edit_nonce = isset( $_REQUEST['dokan_edit_product_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['dokan_edit_product_nonce'] ) ), 'dokan_edit_product' );

		if ( $add_nonce || $edit_nonce ) {
			foreach ( $taxonomies as $taxonomy ) {
				$tax = ( ! empty( $_POST[ $taxonomy ] ) && is_array( $_POST[ $taxonomy ] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST[ $taxonomy ] ) ) : sanitize_text_field( wp_unslash( $_POST[ $taxonomy ] ) ) );

				if ( ! empty( $tax ) ) {
					$tax = ( is_array( $tax ) && array_filter( $tax, 'is_numeric' ) ) ? array_map( 'intval', $tax ) : $tax;
					wp_set_object_terms( $post_id, $tax, $taxonomy );
				}
			}
		} else {
			die( esc_html__( 'Security check. Nonce not matched.', 'generatepress' ) );
		}
	}
);
add_action( 'dokan_process_product_meta', $callback );
add_action( 'dokan_new_product_added', $callback );
add_action( 'dokan_product_updated', $callback );
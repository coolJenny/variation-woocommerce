<?php

/**
 * Class TA_WC_Variation_Swatches_Frontend
 */
class TA_WC_Variation_Swatches_Frontend {
	/**
	 * The single instance of the class
	 *
	 * @var TA_WC_Variation_Swatches_Frontend
	 */
	protected static $instance = null;

	/**
	 * Main instance
	 *
	 * @return TA_WC_Variation_Swatches_Frontend
	 */
	public static function instance() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_filter( 'woocommerce_dropdown_variation_attribute_options_html', array( $this, 'get_swatch_html' ), 100, 2 );
		add_filter( 'tawcvs_swatch_html', array( $this, 'swatch_html' ), 5, 4 );
	}

	/**
	 * Enqueue scripts and stylesheets
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'tawcvs-frontend', plugins_url( 'assets/css/frontend.css', dirname( __FILE__ ) ), array(), '20160615' );
		wp_enqueue_script( 'tawcvs-frontend', plugins_url( 'assets/js/frontend.js', dirname( __FILE__ ) ), array( 'jquery' ), '20160615', true );
	}

	/**
	 * Filter function to add swatches bellow the default selector
	 *
	 * @param $html
	 * @param $args
	 *
	 * @return string
	 */
	public function get_swatch_html( $html, $args ) {
		$swatch_types = TA_WCVS()->types;
		$attr         = TA_WCVS()->get_tax_attribute( $args['attribute'] );

		// Return if this is normal attribute
		if ( empty( $attr ) ) {
			return $html;
		}

		if ( ! array_key_exists( $attr->attribute_type, $swatch_types ) ) {
			return $html;
		}

		$options   = $args['options'];
		$product   = $args['product'];
		$attribute = $args['attribute'];
		$class     = "variation-selector variation-select-{$attr->attribute_type}";
		$swatches  = '';

		if ( empty( $options ) && ! empty( $product ) && ! empty( $attribute ) ) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[$attribute];
		}

		if ( array_key_exists( $attr->attribute_type, $swatch_types ) ) {
			if ( ! empty( $options ) && $product && taxonomy_exists( $attribute ) ) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms( $product->get_id(), $attribute, array( 'fields' => 'all' ) );

				foreach ( $terms as $term ) {
					if ( in_array( $term->slug, $options ) ) {
						$swatches .= apply_filters( 'tawcvs_swatch_html', '', $term, $attr, $args );
					}
				}
			}

			if ( ! empty( $swatches ) ) {
				$class .= ' hidden';

				$swatches = '<div class="tawcvs-swatches" data-attribute_name="attribute_' . esc_attr( $attribute ) . '">' . $swatches . '</div>';
				$html     = '<div class="' . esc_attr( $class ) . '">' . $html . '</div>' . $swatches;
			}
		}

		return $html;
	}

	/**
	 * Print HTML of a single swatch
	 *
	 * @param $html
	 * @param $term
	 * @param $attr
	 * @param $args
	 *
	 * @return string
	 */
	public function swatch_html( $html, $term, $attr, $args ) {
		$selected = sanitize_title( $args['selected'] ) == $term->slug ? 'selected' : '';
		$name     = esc_html( apply_filters( 'woocommerce_variation_option_name', $term->name ) );

		switch ( $attr->attribute_type ) {
			case 'color':
				
				if($name == 'Natural Wood'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/05/natural-wood-style-1.png" alt="%s"><div class="swatch-color-name">Natural Wood</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Black Onyx'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/09/black-onxy-color.png" alt="%s"><div class="swatch-color-name">Black Onyx</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Sunset Gold'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/09/sunset-gold-color.png" alt="%s"><div class="swatch-color-name">Sunset Gold</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Harvest Maple'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/09/harvest-maple-color.png" alt="%s"><div class="swatch-color-name">Harvest Maple</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Golden Oak'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/09/golden-oak-color.png" alt="%s"><div class="swatch-color-name">Golden Oak</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Mirage'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/09/mirage-color.png" alt="%s"><div class="swatch-color-name">Mirage</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Stone White'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/09/stone-white-color.png" alt="%s"><div class="swatch-color-name">Stone White</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Woodstock'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/10/color_woodstock.png" alt="%s"><div class="swatch-color-name">Woodstock</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Seamist'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/10/color_seamist.png" alt="%s"><div class="swatch-color-name">Seamist</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Willow Oak'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/10/color_willowoak.png" alt="%s"><div class="swatch-color-name">Willow Oak</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Orchid Driftwood'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/10/color_orchiddriftwood.png" alt="%s"><div class="swatch-color-name">Orchid Driftwood</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Midnight Oak'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/10/color_midnightoak.png" alt="%s"><div class="swatch-color-name">Midnight Oak</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else if($name == 'Merlot'){
					$html = sprintf(
						'<span style="overflow: visible; float:left;" class="swatch swatch-image custom-swatch swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="/wp-content/uploads/2017/10/color_merlot.png" alt="%s"><div class="swatch-color-name">Merlot</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}else{
					$color = get_term_meta( $term->term_id, 'color', true );
					list( $r, $g, $b ) = sscanf( $color, "#%02x%02x%02x" );
					$html = sprintf(
						'<span class="swatch swatch-color swatch-%s %s" style="background-color:%s;color:%s;" title="%s" data-value="%s"><div class="swatch-color-name">%s</div></span>',
						esc_attr( $term->slug ),
						$selected,
						esc_attr( $color ),
						"rgba($r,$g,$b,0.5)",
						esc_attr( $name ),
						esc_attr( $term->slug ),
						$name
					);
				}
				
				break;

			case 'image':
				$image = get_term_meta( $term->term_id, 'image', true );
				$image = $image ? wp_get_attachment_image_src( $image ) : '';
				$image = $image ? $image[0] : WC()->plugin_url() . '/assets/images/placeholder.png';
				$html  = sprintf(
					'<span style="overflow: visible;" class="swatch swatch-image swatch-%s %s" title="%s" data-value="%s"><img style="border-radius: 100px;" src="%s" alt="%s"><div class="swatch-color-name">%s</div></span>',
					esc_attr( $term->slug ),
					$selected,
					esc_attr( $name ),
					esc_attr( $term->slug ),
					esc_url( $image ),
					esc_attr( $name ),
					esc_attr( $name )
				);
				break;

			case 'label':
				$label = get_term_meta( $term->term_id, 'label', true );
				$label = $label ? $label : $name;
				$html  = sprintf(
					'<span style="line-height: 45px;" class="swatch swatch-label swatch-%s %s" title="%s" data-value="%s">%s</span>',
					esc_attr( $term->slug ),
					$selected,
					esc_attr( $name ),
					esc_attr( $term->slug ),
					esc_html( $label )
				);
				break;
		}

		return $html;
	}
}
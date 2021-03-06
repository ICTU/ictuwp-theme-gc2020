<?php

// Functions specific for Flavor OD
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


//========================================================================================================

// Custom Post Types
if ( ! defined( 'GC_TIP_CPT' ) ) {
	define( 'GC_TIP_CPT', 'tips' );
}

// Custom Taxonomies
if ( ! defined( 'GC_TIPTHEMA' ) ) {
	define( 'GC_TIPTHEMA', 'tipthema' );
}
if ( ! defined( 'GC_ODSPEELSET' ) ) {
	define( 'GC_ODSPEELSET', 'speelset' );
}
if ( ! defined( 'OD_CITAATAUTEUR' ) ) {
	define( 'OD_CITAATAUTEUR', 'tipgever' );
}


//========================================================================================================


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.1
 */

if ( ! class_exists( 'ICTUWP_GC_OD_registerposttypes' ) ) :

	class ICTUWP_GC_OD_registerposttypes {

		/**
		 * @var Rijksvideo
		 */
		public $rhswpregistration = null;

		/** ----------------------------------------------------------------------------------------------------
		 * Init
		 */
		public static function init() {

			$rhswpregistration = new self();

		}

		/** ----------------------------------------------------------------------------------------------------
		 * Constructor
		 */
		public function __construct() {

			add_action( 'init', [ $this, 'register_post_type_taxonomies' ] );

		}


		/** ----------------------------------------------------------------------------------------------------
		 * Do actually register the post types we need
		 */
		public function register_post_type_taxonomies() {


			// ---------------------------------------------------------------------------------------------------
			// uit siteopties de pagina ophalen die het overzicht is van alle links
			$optionpage        = get_field( 'od_overzicht_alle_tips', 'option' );
			$defaultslugforCPT = GC_TIP_CPT;

			if ( $optionpage ) {
				$defaultslugforCPT = get_the_permalink( $optionpage );
				$defaultslugforCPT = str_replace( home_url(), '', $defaultslugforCPT );
				$defaultslugforCPT = trim( $defaultslugforCPT, '/' );
			}

			$labels = [
				"name"               => __( "Tips", 'gctheme' ),
				"singular_name"      => __( "Tip", 'gctheme' ),
				"menu_name"          => __( "Tips", 'gctheme' ),
				"all_items"          => __( "Alle tips", 'gctheme' ),
				"add_new"            => __( "Toevoegen", 'gctheme' ),
				"add_new_item"       => __( "Tip toevoegen", 'gctheme' ),
				"edit"               => __( "Tip bewerken", 'gctheme' ),
				"edit_item"          => __( "Bewerk tip", 'gctheme' ),
				"new_item"           => __( "Nieuwe tip", 'gctheme' ),
				"view"               => __( "Bekijk", 'gctheme' ),
				"view_item"          => __( "Bekijk tip", 'gctheme' ),
				"search_items"       => __( "Tips zoeken", 'gctheme' ),
				"not_found"          => __( "Geen tips gevonden", 'gctheme' ),
				"not_found_in_trash" => __( "Geen tips in de prullenbak", 'gctheme' ),
			];

			$args = [
				"labels"              => $labels,
				"description"         => __( "Hier voer je de tips in.", 'gctheme' ),
				"public"              => true,
				"hierarchical"        => false,
				"exclude_from_search" => false,
				"publicly_queryable"  => true,
				"show_ui"             => true,
				"show_in_menu"        => true,
				"show_in_rest"        => true,
				"capability_type"     => __( "post", 'gctheme' ),
				"supports"            => [
					"title",
					"editor",
					"excerpt",
					"revisions",
					"author",
				],
				"has_archive"         => false,
				"rewrite"             => [
					"slug"       => $defaultslugforCPT,
					"with_front" => true,
				],
				"can_export"          => true,
				"delete_with_user"    => false,
				"map_meta_cap"        => true,
				"query_var"           => true,
			];
			register_post_type( GC_TIP_CPT, $args );

			// ---------------------------------------------------------------------------------------------------

			$labels = [
				"name"                       => __( "Tip-thema's", 'gctheme' ),
				"label"                      => __( "Tip-thema's", 'gctheme' ),
				"menu_name"                  => __( "Tip-thema's", 'gctheme' ),
				"all_items"                  => __( "Alle tip-thema's", 'gctheme' ),
				"edit_item"                  => __( "Bewerk thema", 'gctheme' ),
				"view_item"                  => __( "Bekijk thema", 'gctheme' ),
				"update_item"                => __( "thema bijwerken", 'gctheme' ),
				"add_new_item"               => __( "thema toevoegen", 'gctheme' ),
				"new_item_name"              => __( "Nieuwe thema", 'gctheme' ),
				"search_items"               => __( "Zoek thema", 'gctheme' ),
				"popular_items"              => __( "Meest gebruikte thema's", 'gctheme' ),
				"separate_items_with_commas" => __( "Scheid met komma's", 'gctheme' ),
				"add_or_remove_items"        => __( "thema toevoegen of verwijderen", 'gctheme' ),
				"choose_from_most_used"      => __( "Kies uit de meest gebruikte", 'gctheme' ),
				"not_found"                  => __( "Niet gevonden", 'gctheme' ),
			];

			$args = [
				"labels"             => $labels,
				"hierarchical"       => true,
				"label"              => __( "Tip-thema's", 'gctheme' ),
				"show_ui"            => true,
				"query_var"          => true,
				'show_in_rest'       => true,
				// Needed for tax to appear in Gutenberg editor.
				"rewrite"            => [
					'slug'       => GC_TIPTHEMA,
					'with_front' => true,
				],
				"show_admin_column"  => false,
				"show_in_quick_edit" => true,
			];
			register_taxonomy( GC_TIPTHEMA, [ GC_TIP_CPT ], $args );

			//------------------------------------------------------------------------------------------------------

			$labels = [
				"name"          => __( "Speelsets", 'gctheme' ),
				"singular_name" => __( "Speelset", 'gctheme' ),
			];

			$labels = [
				"name"                  => __( "Speelsets", 'gctheme' ),
				"singular_name"         => __( "Speelset", 'gctheme' ),
				"menu_name"             => __( "Speelsets", 'gctheme' ),
				"all_items"             => __( "Alle speelsets", 'gctheme' ),
				"add_new"               => __( "Nieuwe speelset toevoegen", 'gctheme' ),
				"add_new_item"          => __( "Voeg nieuwe speelset toe", 'gctheme' ),
				"edit_item"             => __( "Bewerk speelset", 'gctheme' ),
				"new_item"              => __( "Nieuwe speelset", 'gctheme' ),
				"view_item"             => __( "Bekijk speelset", 'gctheme' ),
				"search_items"          => __( "Zoek speelset", 'gctheme' ),
				"not_found"             => __( "Geen speelset gevonden", 'gctheme' ),
				"not_found_in_trash"    => __( "Geen speelset gevonden in de prullenbak", 'gctheme' ),
				"featured_image"        => __( "Uitgelichte afbeelding", 'gctheme' ),
				"archives"              => __( "Overzichten", 'gctheme' ),
				"uploaded_to_this_item" => __( "Bijbehorende bestanden", 'gctheme' ),
			];

			$args = [
				"label"              => __( "Speelsets", 'gctheme' ),
				"labels"             => $labels,
				"public"             => true,
				"hierarchical"       => true,
				"label"              => __( "Speelsets", 'gctheme' ),
				"show_ui"            => true,
				"show_in_menu"       => true,
				"show_in_nav_menus"  => true,
				"query_var"          => true,
				'show_in_rest'       => true,
				// Needed for tax to appear in Gutenberg editor.
				"rewrite"            => [
					'slug'       => GC_ODSPEELSET,
					'with_front' => true,
				],
				"show_admin_column"  => false,
				"rest_base"          => "",
				"show_in_quick_edit" => true,
			];

			register_taxonomy( GC_ODSPEELSET, [ GC_TIP_CPT ], $args );

			//------------------------------------------------------------------------------------------------------

			$labels = [
				"name"          => __( "Tipgevers", 'gctheme' ),
				"singular_name" => __( "Tipgever", 'gctheme' ),
			];

			$labels = [
				"name"                  => __( "Tipgevers", 'gctheme' ),
				"singular_name"         => __( "Tipgever", 'gctheme' ),
				"menu_name"             => __( "Tipgevers", 'gctheme' ),
				"all_items"             => __( "Alle tipgevers", 'gctheme' ),
				"add_new"               => __( "Nieuwe tipgever toevoegen", 'gctheme' ),
				"add_new_item"          => __( "Voeg nieuwe tipgever toe", 'gctheme' ),
				"edit_item"             => __( "Bewerk tipgever", 'gctheme' ),
				"new_item"              => __( "Nieuwe tipgever", 'gctheme' ),
				"view_item"             => __( "Bekijk tipgever", 'gctheme' ),
				"search_items"          => __( "Zoek tipgever", 'gctheme' ),
				"not_found"             => __( "Geen tipgever gevonden", 'gctheme' ),
				"not_found_in_trash"    => __( "Geen tipgever gevonden in de prullenbak", 'gctheme' ),
				"featured_image"        => __( "Uitgelichte afbeelding", 'gctheme' ),
				"archives"              => __( "Overzichten", 'gctheme' ),
				"uploaded_to_this_item" => __( "Bijbehorende bestanden", 'gctheme' ),
			];

			$args = [
				"label"              => __( "Tipgevers", 'gctheme' ),
				"labels"             => $labels,
				"public"             => true,
				"hierarchical"       => false,
				"label"              => __( "Tipgevers", 'gctheme' ),
				"show_ui"            => true,
				"show_in_menu"       => true,
				"show_in_nav_menus"  => true,
				"query_var"          => true,
				'show_in_rest'       => true,
				// Needed for tax to appear in Gutenberg editor.
				"rewrite"            => [
					'slug'       => OD_CITAATAUTEUR,
					'with_front' => true,
				],
				"show_admin_column"  => false,
				"rest_base"          => "",
				"show_in_quick_edit" => false,
			];

			register_taxonomy( OD_CITAATAUTEUR, [ GC_TIP_CPT ], $args );

			// ---------------------------------------------------------------------------------------------------

			if ( function_exists( 'acf_add_local_field_group' ) ):

				acf_add_local_field_group( [
					'key'                   => 'group_5654241bc6feb',
					'title'                 => __( "Extra content: layout-instellingen voor de inleiding, goede voorbeelden, waarom werkt dit", 'gctheme' ),
					'fields'                => [
						[
							'key'               => 'field_569d645a172a7',
							'label'             => __( "Soort inleiding", 'gctheme' ),
							'name'              => 'soort_inleiding',
							'type'              => 'radio',
							'instructions'      => __( "Wil je een inleiding met een grote foto of een aantal opsommingen onder elkaar?", 'gctheme' ),
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'choices'           => [
								'geenfoto'    => __( "Geen foto", 'gctheme' ),
								'grotefoto'   => __( "Grote foto naast de tekst", 'gctheme' ),
								'opsommingen' => __( "Lijstje met opsommingen en kleine foto's", 'gctheme' ),
							],
							'other_choice'      => 0,
							'save_other_choice' => 0,
							'default_value'     => 'geenfoto',
							'layout'            => 'vertical',
						],
						[
							'key'               => 'field_569d6543eca6a',
							'label'             => __( "Grote foto", 'gctheme' ),
							'name'              => 'grote_foto',
							'type'              => 'image',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => [
								[
									[
										'field'    => 'field_569d645a172a7',
										'operator' => '==',
										'value'    => 'grotefoto',
									],
								],
							],
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'return_format'     => 'array',
							'preview_size'      => 'thumbnail',
							'library'           => 'all',
							'min_width'         => '',
							'min_height'        => '',
							'min_size'          => '',
							'max_width'         => '',
							'max_height'        => '',
							'max_size'          => '',
							'mime_types'        => '',
						],
						[
							'key'               => 'field_569d656e0caea',
							'label'             => __( "Lijstjes met kleine foto", 'gctheme' ),
							'name'              => 'lijstjes_met_kleine_foto',
							'type'              => 'repeater',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => [
								[
									[
										'field'    => 'field_569d645a172a7',
										'operator' => '==',
										'value'    => 'opsommingen',
									],
								],
							],
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'collapsed'         => '',
							'min'               => '',
							'max'               => '',
							'layout'            => 'table',
							'button_label'      => __( "Nieuwe regel", 'gctheme' ),
							'sub_fields'        => [
								[
									'key'               => 'field_569d660c2835f',
									'label'             => __( "Bijbehorende foto", 'gctheme' ),
									'name'              => 'bijbehorende_foto',
									'type'              => 'image',
									'instructions'      => '',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '10',
										'class' => '',
										'id'    => '',
									],
									'return_format'     => 'array',
									'preview_size'      => 'thumbnail',
									'library'           => 'all',
									'min_width'         => '',
									'min_height'        => '',
									'min_size'          => '',
									'max_width'         => '',
									'max_height'        => '',
									'max_size'          => '',
									'mime_types'        => '',
								],
								[
									'key'               => 'field_569d65dc2835d',
									'label'             => __( "Titel", 'gctheme' ),
									'name'              => 'titel',
									'type'              => 'text',
									'instructions'      => '',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '20',
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'maxlength'         => '',
									'readonly'          => 0,
									'disabled'          => 0,
								],
								[
									'key'               => 'field_569d65f22835e',
									'label'             => __( "Lijstje", 'gctheme' ),
									'name'              => 'lijstje',
									'type'              => 'wysiwyg',
									'instructions'      => __( "Voer alsjeblieft alleen lijstjes in.", 'gctheme' ),
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => 70,
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'tabs'              => 'all',
									'toolbar'           => 'full',
									'media_upload'      => 1,
								],
							],
						],
						[
							'key'               => 'field_565426c3a737d',
							'label'             => __( "Goed voorbeeld", 'gctheme' ),
							'name'              => 'goed_voorbeeld',
							'type'              => 'repeater',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'collapsed'         => 'field_565427cd84d56',
							'min'               => '',
							'max'               => '',
							'layout'            => 'row',
							'button_label'      => __( "Voeg voorbeeld toe", 'gctheme' ),
							'sub_fields'        => [
								[
									'key'               => 'field_565427cd84d56',
									'label'             => __( "Titel", 'gctheme' ),
									'name'              => 'titel_goed_voorbeeld',
									'type'              => 'text',
									'instructions'      => '',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => 100,
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'maxlength'         => '',
									'readonly'          => 0,
									'disabled'          => 0,
								],
								[
									'key'               => 'field_565427f384d57',
									'label'             => __( "Tekst", 'gctheme' ),
									'name'              => 'tekst_goed_voorbeeld',
									'type'              => 'wysiwyg',
									'instructions'      => '',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => 100,
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'maxlength'         => '',
									'rows'              => '',
									'new_lines'         => 'wpautop',
									'readonly'          => 0,
									'disabled'          => 0,
								],

								[
									'key'               => 'field_58ee12572addf',
									'label'             => __( "Tipgever", 'gctheme' ),
									'name'              => OD_CITAATAUTEUR . '_field',
									'type'              => 'taxonomy',
									'instructions'      => __( "Selecteer één uit de lijst of voer een nieuwe naam in", 'gctheme' ),
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'taxonomy'          => OD_CITAATAUTEUR,
									'field_type'        => 'multi_select',
									'allow_null'        => 0,
									'add_term'          => 1,
									'save_terms'        => 1,
									'load_terms'        => 0,
									'return_format'     => 'id',
									'multiple'          => 0,
								],


								[
									'key'               => 'field_5654280584d58',
									'label'             => __( "Naam van de tipgever", 'gctheme' ),
									'name'              => 'voorbeeld-auteur-naam',
									'type'              => 'text',
									'instructions'      => '',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => 100,
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
								],
								[
									'key'               => 'field_5654281b84d59',
									'label'             => __( "Functie van de tipgever", 'gctheme' ),
									'name'              => 'voorbeeld-auteur-functie',
									'type'              => 'text',
									'instructions'      => '',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => 100,
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'maxlength'         => '',
									'readonly'          => 0,
									'disabled'          => 0,
								],
								[
									'key'               => 'field_56542a066f951',
									'label'             => __( "Afbeelding", 'gctheme' ),
									'name'              => 'afbeelding_goed_voorbeeld',
									'type'              => 'image',
									'instructions'      => '',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'return_format'     => 'array',
									'preview_size'      => 'thumbnail',
									'library'           => 'all',
									'min_width'         => '',
									'min_height'        => '',
									'min_size'          => '',
									'max_width'         => '',
									'max_height'        => '',
									'max_size'          => '',
									'mime_types'        => '',
								],
							],
						],

						[
							'key'               => 'field_565429a092d58',
							'label'             => __( "Waarom werkt dit?", 'gctheme' ),
							'name'              => 'waarom_werkt_dit_goed_voorbeeld',
							'type'              => 'wysiwyg',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'maxlength'         => '',
							'rows'              => '',
							'new_lines'         => 'wpautop',
							'readonly'          => 0,
							'disabled'          => 0,
						],

						[
							'key'               => 'field_569d55285990f',
							'label'             => __( "Onderzoek: inleiding", 'gctheme' ),
							'name'              => 'inleiding-onderzoek',
							'type'              => 'wysiwyg',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'maxlength'         => '',
							'rows'              => '',
							'new_lines'         => 'wpautop',
							'readonly'          => 0,
							'disabled'          => 0,
						],

						[
							'key'               => 'field_569d55fd856cc',
							'label'             => __( "Vraag 1 - titel", 'gctheme' ),
							'name'              => 'inleiding-vraag_1_titel',
							'type'              => 'text',
							'instructions'      => 'Maximaal 40 karakters.
  Voorbeeld: "Kan het 100% digitaal?"',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d5639deb33',
							'label'             => __( "Vraag 1 - cijfer", 'gctheme' ),
							'name'              => 'inleiding-vraag_1_-_cijfer',
							'type'              => 'text',
							'instructions'      => 'Hier een percentage of een cijfer.
  Voorbeelden:
  85%
  > 8,0',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d568e1d383',
							'label'             => __( "Vraag 1 - antwoord", 'gctheme' ),
							'name'              => 'inleiding-vraag_1_-_antwoord',
							'type'              => 'text',
							'instructions'      => 'Voorbeeld:
  "Geeft voldoende aan niet-digitale route"
  "55% geeft een 8 of hoger"',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d5701b75ae',
							'label'             => __( "Vraag 2 - titel", 'gctheme' ),
							'name'              => 'inleiding-vraag_2_titel',
							'type'              => 'text',
							'instructions'      => 'Maximaal 40 karakters.
  Voorbeeld: "Kan het 100% digitaal?"',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d57269e612',
							'label'             => __( "Vraag 2 - cijfer", 'gctheme' ),
							'name'              => 'inleiding-vraag_2_-_cijfer',
							'type'              => 'text',
							'instructions'      => 'Hier een percentage of een cijfer.
  Voorbeelden:
  85%
  > 8,0',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d57c2d61d4',
							'label'             => __( "Vraag 2 - antwoord", 'gctheme' ),
							'name'              => 'inleiding-vraag_2_-_antwoord',
							'type'              => 'text',
							'instructions'      => 'Voorbeeld:
  "Geeft voldoende aan niet-digitale route"
  "55% geeft een 8 of hoger"',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d571139792',
							'label'             => __( "Vraag 3 - titel", 'gctheme' ),
							'name'              => 'inleiding-vraag_3_titel',
							'type'              => 'text',
							'instructions'      => 'Maximaal 40 karakters.
  Voorbeeld: "Kan het 100% digitaal?"',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d5735e0391',
							'label'             => __( "Vraag 3 - cijfer", 'gctheme' ),
							'name'              => 'inleiding-vraag_3_-_cijfer',
							'type'              => 'text',
							'instructions'      => 'Hier een percentage of een cijfer.
  Voorbeelden:
  85%
  > 8,0',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d57c1d61d3',
							'label'             => __( "Vraag 3 - antwoord", 'gctheme' ),
							'name'              => 'inleiding-vraag_3_-_antwoord',
							'type'              => 'text',
							'instructions'      => 'Voorbeeld:
  "Geeft voldoende aan niet-digitale route"
  "55% geeft een 8 of hoger"',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_569d55b0f0869',
							'label'             => __( "Onderzoek: conclusie", 'gctheme' ),
							'name'              => 'inleiding-conclusie',
							'type'              => 'wysiwyg',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'maxlength'         => '',
							'rows'              => '',
							'new_lines'         => 'wpautop',
							'readonly'          => 0,
							'disabled'          => 0,
						],

					],
					'location'              => [
						[
							[
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => GC_TIP_CPT,
							],
						],
					],
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => [
						0 => 'custom_fields',
						1 => 'discussion',
						2 => 'comments',
						3 => 'slug',
						4 => 'send-trackbacks',
					],
					'active'                => 1,
					'description'           => '',
				] );


				acf_add_local_field_group( [
					'key'                   => 'group_5654e441524ac',
					'title'                 => 'Tip-nummer',
					'fields'                => [
						[
							'key'               => 'field_5654e448b40c2',
							'label'             => __( "Tip-nummer", 'gctheme' ),
							'name'              => 'tip-nummer',
							'type'              => 'number',
							'instructions'      => 'Voer het tip-nummer in. Geen letters, alleen cijfers',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'min'               => '',
							'max'               => '',
							'step'              => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
					],
					'location'              => [
						[
							[
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => GC_TIP_CPT,
							],
						],
					],
					'menu_order'            => 0,
					'position'              => 'acf_after_title',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => 1,
					'description'           => '',
				] );

				/*
				 *
				 * andere opzet voor kleur en icoon
								acf_add_local_field_group( array(
									'key'                   => 'group_56656a2421879',
									'title'                 => 'Layout van titel-thema\'s',
									'fields'                => array(
										array(
											'key'               => 'field_56656a8b627fc',
											'label'             => __( "Thema-logo", 'gctheme' ),
											'name'              => 'thema-logo',
											'type'              => 'radio',
											'instructions'      => '',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'choices'           => array(
												'icon-deelenwerksamen'      => 'Deel en werk samen',
												'icon-digitaaloporde'       => 'Digitaal op orde',
												'icon-goedproces'           => 'Goed proces',
												'icon-interndraagvlak'      => 'Intern draagvlak',
												'icon-kanaalsturing'        => 'Kanaalsturing',
												'icon-informatieveiligheid' => 'Informatieveiligheid',
												'icon-gloeilamp'            => 'Gloeilamp',
											),
											'other_choice'      => 0,
											'save_other_choice' => 0,
											'default_value'     => 'muis',
											'layout'            => 'vertical',
										),
										array(
											'key'               => 'field_56656a2e627fb',
											'label'             => __( "Thema-kleur", 'gctheme' ),
											'name'              => 'thema-kleur',
											'type'              => 'radio',
											'instructions'      => '',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'choices'           => array(
												'oranje'    => 'Oranje',
												'groen'     => 'Groen',
												'paars'     => 'Paars',
												'blauw'     => 'Blauw',
												'turquoise' => 'Turquoise',
												'bruin'     => 'Rood',
												'goud'      => 'Goud',
											),
											'other_choice'      => 0,
											'save_other_choice' => 0,
											'default_value'     => 'oranje',
											'layout'            => 'vertical',
										),
									),
									'location'              => array(
										array(
											array(
												'param'    => 'taxonomy',
												'operator' => '==',
												'value'    => 'tipthema',
											),
										),
									),
									'menu_order'            => 0,
									'position'              => 'normal',
									'style'                 => 'default',
									'label_placement'       => 'top',
									'instruction_placement' => 'label',
									'hide_on_screen'        => '',
									'active'                => 1,
									'description'           => '',
								) );
				 */


				acf_add_local_field_group( [
					'key'                   => 'group_569f5ed3033ec_XXXXX',
					'title'                 => 'Tips: nuttige links',
					'fields'                => [
						[
							'key'               => 'field_569f616abab78',
							'label'             => __( "Nuttige links", 'gctheme' ),
							'name'              => 'nuttige_links',
							'type'              => 'repeater',
							'instructions'      => 'De URL is verplicht; de andere velden niet. Maar als er geen beschrijving, CTA of titel wordt ingevoerd, wordt er "<em>' . __( "Geen linkbeschrijving ingevoerd", 'gctheme' ) . '</em>" getoond.',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'collapsed'         => '',
							'min'               => '',
							'max'               => '',
							'layout'            => 'table',
							'button_label'      => 'Nieuwe regel',
							'sub_fields'        => [
								[
									'key'               => 'field_569f619e3c9cb',
									'label'             => __( "URL", 'gctheme' ),
									'name'              => 'url',
									'type'              => 'url',
									'instructions'      => 'Dit is de link waarnaar wordt verwezen',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
								],
								[
									'key'               => 'field_56a9f294de11f',
									'label'             => __( "Link: icoon", 'gctheme' ),
									'name'              => 'link_icoon',
									'type'              => 'radio',
									'instructions'      => 'Het plaatje voor de link',
									'required'          => 1,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'choices'           => [
										'folder'   => '<img src="/wp-content/themes/optimaal-digitaal/images/icon-folder20h.png" alt="Folder" width="26" height="20" />&nbsp;Folder',
										'document' => '<img src="/wp-content/themes/optimaal-digitaal/images/icon-document20h.png"	alt="Document" width="17" height="20"/>&nbsp;Document',
									],
									'other_choice'      => 0,
									'save_other_choice' => 0,
									'default_value'     => 'folder',
									'layout'            => 'vertical',
								],
								[
									'key'               => 'field_569f61c53c9cc',
									'label'             => __( "Link: Titel", 'gctheme' ),
									'name'              => 'link_titel',
									'type'              => 'text',
									'instructions'      => 'Deze wordt in vette letters getoond',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'maxlength'         => '',
									'readonly'          => 0,
									'disabled'          => 0,
								],
								[
									'key'               => 'field_569f634af8a81',
									'label'             => __( "Link: beschrijving", 'gctheme' ),
									'name'              => 'link_beschrijving',
									'type'              => 'textarea',
									'instructions'      => 'Deze kan meerdere regels bevatten',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'maxlength'         => '',
									'rows'              => '',
									'new_lines'         => 'wpautop',
									'readonly'          => 0,
									'disabled'          => 0,
								],
								[
									'key'               => 'field_569f636df8a82',
									'label'             => __( "Link: CTA", 'gctheme' ),
									'name'              => 'link_cta',
									'type'              => 'text',
									'instructions'      => 'Call to action. ',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'maxlength'         => '',
									'readonly'          => 0,
									'disabled'          => 0,
								],
								[
									'key'               => 'field_5ZfuTpRAX3AFv',
									'label'             => __( "Link: hreflang", 'gctheme' ),
									'name'              => 'link_hreflang',
									'type'              => 'text',
									'instructions'      => 'Als de taal van de pagina waarnaar je verwijst anders is dan Nederlands, voer je hier de hreflang in.<br>(zie: <a href="https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes">lijst met taalcodes</a>)',
									'required'          => 0,
									'conditional_logic' => 0,
									'wrapper'           => [
										'width' => '',
										'class' => '',
										'id'    => '',
									],
									'default_value'     => '',
									'placeholder'       => '',
									'prepend'           => '',
									'append'            => '',
									'maxlength'         => 5,
									'readonly'          => 0,
									'disabled'          => 0,
								],
							],
						],
					],
					'location'              => [
						[
							[
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'tips',
							],
						],
					],
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => 1,
					'description'           => '',
				] );


				acf_add_local_field_group( [
					'key'                   => 'group_5a02ef774dca6',
					'title'                 => 'Contactgegevens voor tipgever',
					'fields'                => [
						[
							'key'               => 'field_5a02f087c923e',
							'label'             => __( "Functietitel", 'gctheme' ),
							'name'              => 'tipgever_functietitel',
							'type'              => 'text',
							'value'             => null,
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
						],
						[
							'key'               => 'field_5a02ef8fe03f1',
							'label'             => __( "Foto", 'gctheme' ),
							'name'              => 'tipgever_foto',
							'type'              => 'image',
							'value'             => null,
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'return_format'     => 'array',
							'preview_size'      => 'opsommingwidth',
							'library'           => 'all',
							'min_width'         => '',
							'min_height'        => '',
							'min_size'          => '',
							'max_width'         => '',
							'max_height'        => '',
							'max_size'          => '',
							'mime_types'        => '',
						],
						[
							'key'               => 'field_5a02f05afe0a8',
							'label'             => __( "E-mailadres", 'gctheme' ),
							'name'              => 'tipgever_mail',
							'type'              => 'email',
							'value'             => null,
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
						],
						[
							'key'               => 'field_5a02f8c21d789',
							'label'             => __( "Telefoonnummer", 'gctheme' ),
							'name'              => 'tipgever_telefoonnummer',
							'type'              => 'text',
							'value'             => null,
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
						],
					],
					'location'              => [
						[
							[
								'param'    => 'taxonomy',
								'operator' => '==',
								'value'    => OD_CITAATAUTEUR,
							],
						],
					],
					'menu_order'            => 0,
					'position'              => 'acf_after_title',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => 1,
					'description'           => '',
				] );


				//========================================================================================================
				// options page
				$args = [
					'slug'   => 'instellingen',
					'title'  => 'Theme-instelling',
					'parent' => 'themes.php',
				];

				acf_add_options_page( $args );

				/*

								acf_add_local_field_group( array(
									'key'                   => 'group_56b268032bdb7',
									'title'                 => 'Tekst op homepage',
									'fields'                => array(
										array(
											'key'               => 'field_56b2680c9d5fd',
											'label'             => __( "Tekst op homepage", 'gctheme' ),
											'name'              => 'tekst_op_homepage',
											'type'              => 'wysiwyg',
											'instructions'      => 'Deze tekst wordt getoond op de homepage, in de magentakleurige header.',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Tips met praktijkvoorbeelden om de digitale weg naar de overheid te stimuleren onder burgers en bedrijven. Samengesteld op basis van onderzoek en gedragspyschologie.',
											'tabs'              => 'all',
											'toolbar'           => 'full',
											'media_upload'      => 1,
										),
										array(
											'key'               => 'field_yiMQNn4HpgGr2',
											'label'             => __( "Selectiemelding", 'gctheme' ),
											'name'              => 'filtering_selectie_boodschap',
											'type'              => 'text',
											'instructions'      => 'Deze tekst meldt het aantal gevonden tips voor de selectie van de gebruiker.',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Aantal gevonden tips',
											'tabs'              => 'all',
											'toolbar'           => 'full',
											'media_upload'      => 1,
										),
										array(
											'key'               => 'field_L8rpCEa3srHTR',
											'label'             => __( "Label op Wissen-knop", 'gctheme' ),
											'name'              => 'filtering_wissen_knop',
											'type'              => 'text',
											'instructions'      => 'Dit is het label op de knop "wissen".',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Wis selectie',
											'tabs'              => 'all',
											'toolbar'           => 'full',
											'media_upload'      => 1,
										),
										array(
											'key'               => 'field_591230c9d5fd',
											'label'             => __( "Foutboodschap voor filtering", 'gctheme' ),
											'name'              => 'filtering_foutboodschap',
											'type'              => 'text',
											'instructions'      => 'Deze tekst wordt getoond als er geen tips gevonden worden voor de ingegeven filters.',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Er zijn geen tips met deze selectie.',
											'tabs'              => 'all',
											'toolbar'           => 'full',
											'media_upload'      => 1,
										),
										array(
											'key'               => 'field_yKs8LFHipYc8',
											'label'             => __( "Label op Toon Alles-knop", 'gctheme' ),
											'name'              => 'filtering_foutboodschap_knop',
											'type'              => 'text',
											'instructions'      => 'Dit is het label op de knop voor het tonen van alle tips, als de foutboodschap hiervoor getoond wordt.',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Toon alles',
											'tabs'              => 'all',
											'toolbar'           => 'full',
											'media_upload'      => 1,
										),


									),
									'location'              => array(
										array(
											array(
												'param'    => 'options_page',
												'operator' => '==',
												'value'    => 'instellingen',
											),
										),
									),
									'menu_order'            => 0,
									'position'              => 'normal',
									'style'                 => 'default',
									'label_placement'       => 'top',
									'instruction_placement' => 'label',
									'hide_on_screen'        => '',
									'active'                => 1,
									'description'           => '',
								) );


								acf_add_local_field_group( array(
									'key'                   => 'group_56a73cbfdf435',
									'title'                 => 'Instellingen voor contactformulier',
									'fields'                => array(
										array(
											'key'               => 'field_56a73cbfe31be',
											'label'             => __( "Contactformulier", 'gctheme' ),
											'name'              => 'contactformulier',
											'type'              => 'post_object',
											'instructions'      => '',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'post_type'         => array(
												0 => 'wpcf7_contact_form',
											),
											'taxonomy'          => array(),
											'allow_null'        => 0,
											'multiple'          => 0,
											'return_format'     => 'id',
											'ui'                => 1,
										),
										array(
											'key'               => 'field_56a73ce794fcf',
											'label'             => __( "Lege naam", 'gctheme' ),
											'name'              => 'lege_naam',
											'type'              => 'text',
											'instructions'      => 'Foutboodschap als naam leeg is',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'We willen graag uw naam weten.',
											'placeholder'       => '',
											'prepend'           => '',
											'append'            => '',
											'maxlength'         => '',
											'readonly'          => 0,
											'disabled'          => 0,
										),
										array(
											'key'               => 'field_56a73d2e94fd0',
											'label'             => __( "Lege suggestie", 'gctheme' ),
											'name'              => 'lege_suggestie',
											'type'              => 'text',
											'instructions'      => 'Foutboodschap als er geen suggestie of vraag is ingevuld',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'U hebt geen vraag of suggestie ingevuld.',
											'placeholder'       => '',
											'prepend'           => '',
											'append'            => '',
											'maxlength'         => '',
											'readonly'          => 0,
											'disabled'          => 0,
										),
										array(
											'key'               => 'field_56a73d6294fd1',
											'label'             => __( "Leeg mailadres", 'gctheme' ),
											'name'              => 'leeg_mailadres',
											'type'              => 'text',
											'instructions'      => 'Foutboodschap als er geen e-mailadres is ingevuld',
											'required'          => 0,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'We hebben uw mailadres nodig om te antwoorden.',
											'placeholder'       => '',
											'prepend'           => '',
											'append'            => '',
											'maxlength'         => '',
											'readonly'          => 0,
											'disabled'          => 0,
										),
									),
									'location'              => array(
										array(
											array(
												'param'    => 'options_page',
												'operator' => '==',
												'value'    => 'instellingen',
											),
										),
									),
									'menu_order'            => 0,
									'position'              => 'normal',
									'style'                 => 'default',
									'label_placement'       => 'top',
									'instruction_placement' => 'label',
									'hide_on_screen'        => '',
									'active'                => 1,
									'description'           => '',
								) );

								acf_add_local_field_group( array(
									'key'                   => 'group_569e0529172fb',
									'title'                 => 'Teksten voor doorspringen naar contactformulier',
									'fields'                => array(
										array(
											'key'               => 'field_56a72fb44d372',
											'label'             => __( "Titel", 'gctheme' ),
											'name'              => 'spring_naar_contactformulier_titel',
											'type'              => 'text',
											'instructions'      => '',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Hebt u misschien een aanvulling op deze tip?',
											'placeholder'       => '',
											'prepend'           => '',
											'append'            => '',
											'maxlength'         => '',
											'readonly'          => 0,
											'disabled'          => 0,
										),
										array(
											'key'               => 'field_56a72febac2b1',
											'label'             => __( "Tekst", 'gctheme' ),
											'name'              => 'spring_naar_contactformulier_tekst',
											'type'              => 'textarea',
											'instructions'      => '',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Heeft u een voorbeeld, eigen case of andere aanvulling waar anderen iets aan hebben? Laat het ons weten! Optimaal Digitaal draait immers om het delen van goede ideeën.',
											'placeholder'       => '',
											'prepend'           => '',
											'append'            => '',
											'maxlength'         => '',
											'readonly'          => 0,
											'disabled'          => 0,
										),
										array(
											'key'               => 'field_56a72ffada688',
											'label'             => __( "Call to action", 'gctheme' ),
											'name'              => 'spring_naar_contactformulier_cta',
											'type'              => 'text',
											'instructions'      => '',
											'required'          => 1,
											'conditional_logic' => 0,
											'wrapper'           => array(
												'width' => '',
												'class' => '',
												'id'    => '',
											),
											'default_value'     => 'Stuur hier in',
											'placeholder'       => '',
											'prepend'           => '',
											'append'            => '',
											'maxlength'         => '',
											'readonly'          => 0,
											'disabled'          => 0,
										),
									),
									'location'              => array(
										array(
											array(
												'param'    => 'options_page',
												'operator' => '==',
												'value'    => 'instellingen',
											),
										),
									),
									'menu_order'            => 2,
									'position'              => 'normal',
									'style'                 => 'default',
									'label_placement'       => 'top',
									'instruction_placement' => 'label',
									'hide_on_screen'        => '',
									'active'                => 1,
									'description'           => '',
								) );
					*/


				acf_add_local_field_group( [
					'key'                   => 'group_56dd829022462',
					'title'                 => '404 tekst',
					'fields'                => [
						[
							'key'               => 'field_56dd82959ab29',
							'label'             => __( "Titel op 404-pagina", 'gctheme' ),
							'name'              => 'titel404',
							'type'              => 'text',
							'instructions'      => 'Titel zoals die getoond wordt op de 404-pagina',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => 'Excuses. De pagina waarnaar u verwezen bent bestaat niet.',
							'placeholder'       => '',
							'prepend'           => '',
							'append'            => '',
							'maxlength'         => '',
							'readonly'          => 0,
							'disabled'          => 0,
						],
						[
							'key'               => 'field_56dd83d6c4674',
							'label'             => __( "Beschrijving op 404-pagina", 'gctheme' ),
							'name'              => 'description404',
							'type'              => 'wysiwyg',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'default_value'     => '',
							'tabs'              => 'all',
							'toolbar'           => 'full',
							'media_upload'      => 1,
						],
					],
					'location'              => [
						[
							[
								'param'    => 'options_page',
								'operator' => '==',
								'value'    => 'instellingen',
							],
						],
					],
					'menu_order'            => 3,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => 1,
					'description'           => '',
				] );


				acf_add_local_field_group( [
					'key'                   => 'group_5ee25849d572e',
					'title'                 => 'Kleur & icoon tipthema',
					'fields'                => [
						[
							'key'               => 'field_5ee2591580057',
							'label'             => 'kleur en icoon tipthema',
							'name'              => 'kleur_en_icoon_tipthema',
							'type'              => 'radio',
							'instructions'      => '',
							'required'          => 1,
							'conditional_logic' => 0,
							'wrapper'           => [
								'width' => '',
								'class' => '',
								'id'    => '',
							],
							'choices'           => [
								'gebruiksgemak'        => '<img src="' . get_template_directory_uri() . 'assets/images/od/gebruiksgemak.jpg" alt=""> Gebruiksgemak',
								'informatieveiligheid' => '<img src="' . get_template_directory_uri() . 'assets/images/od/informatieveiligheid.jpg" alt=""> informatieveiligheid',
								'procesaanpak'         => '<img src="' . get_template_directory_uri() . 'assets/images/od/procesaanpak.jpg" alt=""> procesaanpak',
								'kanaalsturing'        => '<img src="' . get_template_directory_uri() . 'assets/images/od/kannibaalsturing.jpg" alt=""> kanaalsturing',
								'samenwerking'         => '<img src="' . get_template_directory_uri() . 'assets/images/od/samenwerking.jpg" alt=""> samenwerking',
								'commitment'           => '<img src="' . get_template_directory_uri() . 'assets/images/od/commitment.jpg" alt=""> commitment',
								'inclusie'             => '<img src="' . get_template_directory_uri() . 'assets/images/od/inclusie.jpg" alt=""> inclusie',
							],
							'allow_null'        => 0,
							'other_choice'      => 0,
							'default_value'     => '',
							'layout'            => 'vertical',
							'return_format'     => 'value',
							'save_other_choice' => 0,
						],
					],
					'location'              => [
						[
							[
								'param'    => 'taxonomy',
								'operator' => '==',
								'value'    => 'tipthema',
							],
						],
					],
					'menu_order'            => 0,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => true,
					'description'           => '',
				] );


			endif;

			// Boolean voor is_toptip
			acf_add_local_field_group( [
				'key'                   => 'group_5ef1f556c66d7',
				'title'                 => 'Toptip',
				'fields'                => [
					[
						'key'               => 'field_5ef1f56620cd9',
						'label'             => 'Is deze tip een toptip?',
						'name'              => 'is_toptip',
						'type'              => 'radio',
						'instructions'      => '',
						'required'          => 0,
						'conditional_logic' => 0,
						'wrapper'           => [
							'width' => '',
							'class' => '',
							'id'    => '',
						],
						'choices'           => [
							0 => 'Nee, dit is geen toptip',
							1 => 'Ja, dit is een toptip',
						],
						'allow_null'        => 0,
						'other_choice'      => 0,
						'default_value'     => 0,
						'layout'            => 'vertical',
						'return_format'     => 'value',
						'save_other_choice' => 0,
					],
				],
				'location'              => [
					[
						[
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'tips',
						],
					],
				],
				'menu_order'            => 0,
				'position'              => 'side',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => 'Is deze tip een toptip?',
			] );

			///-----
			// parent voor tips; deze pagina fungeert als de archive page voor tips

			acf_add_local_field_group( array(
				'key'                   => 'group_5ee7a4a0c9dfd',
				'title'                 => '[OD] Overzichtspagina\'s',
				'fields'                => array(
					array(
						'key'               => 'field_5ee7a4b0f1054',
						'label'             => 'Op welke pagina staat het overzicht van alle tips?',
						'name'              => 'od_overzicht_alle_tips',
						'type'              => 'post_object',
						'instructions'      => 'LET OP: als je hier een pagina hebt gekozen, moet je de site-instellingen voor tips opnieuw laden. Ga daarvoor naar [wp-admin] > Instellingen > Permalinks. Zodra je deze pagina hebt opgevraagd, wordt de permalink voor alle tips bijgewerkt.',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'page',
						),
						'taxonomy'          => '',
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'object',
						'ui'                => 1,
					),
					array(
						'key'               => 'field_5f3c24a825519',
						'label'             => 'Op welke pagina staat het overzicht van alle tipgevers?',
						'name'              => 'od_overzicht_alle_tipgevers',
						'type'              => 'post_object',
						'instructions'      => 'LET OP: als je hier een pagina hebt gekozen, moet je de site-instellingen voor tips opnieuw laden. Ga daarvoor naar [wp-admin] > Instellingen > Permalinks. Zodra je deze pagina hebt opgevraagd, wordt de permalink voor alle tips bijgewerkt.',
						'required'          => 1,
						'conditional_logic' => 0,
						'wrapper'           => array(
							'width' => '',
							'class' => '',
							'id'    => '',
						),
						'post_type'         => array(
							0 => 'page',
						),
						'taxonomy'          => '',
						'allow_null'        => 0,
						'multiple'          => 0,
						'return_format'     => 'object',
						'ui'                => 1,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'options_page',
							'operator' => '==',
							'value'    => 'instellingen',
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => '',
				'active'                => true,
				'description'           => '',
			) );


			// ---------------------------------------------------------------------------------------------------
			// clean up after ourselves
			flush_rewrite_rules();

		}


	}

endif;

//========================================================================================================

/*
 * filter for breadcrumb
 */

if ( ! function_exists( 'ictuwp_gc_filter_yoast_breadcrumb ' ) ) {

	add_filter( 'wpseo_breadcrumb_links', 'ictuwp_gc_filter_yoast_breadcrumb' );

	function ictuwp_gc_filter_yoast_breadcrumb( $links ) {
		global $post;
		$currentitem = null;
		$optionpage  = null;

		if ( is_front_page() ) {
			// geen breadcrumb op de homepage
			return [];
		} elseif ( is_home() ) {
			// dit is de blogpagina
			return $links;
		} elseif ( is_tax( OD_CITAATAUTEUR ) ) {
			// voor de tipgevers invoegen het overzicht van tipgevers
			$optionpage = get_field( 'od_overzicht_alle_tipgevers', 'option' );
		} elseif ( is_tax( GC_TIPTHEMA ) || is_tax( GC_ODSPEELSET ) ) {
			// voor tipthema's en speelsets het totale tipkaartoverzicht invoegen
			$optionpage = get_field( 'od_overzicht_alle_tips', 'option' );
		} elseif ( is_singular( GC_TIP_CPT ) ) {
			// uit siteopties de pagina ophalen die het overzicht is van alle links
			$optionpage = get_field( 'od_overzicht_alle_tips', 'option' );
		} else {
			return $links;
		}

		if ( $optionpage ) {
			// haal de ancestors op voor deze pagina
			$ancestors   = get_post_ancestors( $optionpage );
			$currentitem = array_pop( $links );
			$home        = $links[0];
			$parents[]   = array(
				'url'  => get_page_link( $optionpage ),
				'text' => get_the_title( $optionpage ),
			);

			if ( $ancestors ) {

				// haal de hele keten aan ancestors op en zet ze in de returnstring
				foreach ( $ancestors as $ancestorid ) {

					if ( $home['url'] !== get_page_link( $ancestorid ) ) {
						// home link staat al in $home, dus niet extra toevoegen

						// Prepend one or more elements to the beginning of an array
						array_unshift( $parents, [
							'url'  => get_page_link( $ancestorid ),
							'text' => get_the_title( $ancestorid ),
						] );

					}
				}
			}

			// append the home link
			array_unshift( $parents, $links[0] );

			if ( isset( $currentitem['id'] ) || isset( $currentitem['term_id'] ) ) {

				if ( isset( $currentitem['id'] ) ) {
					$parents[] = [
						'url'  => get_page_link( $currentitem['id'] ),
						'text' => get_the_title( $currentitem['id'] ),
					];
				} elseif ( isset( $currentitem['term_id'] ) ) {
					$parents[] = [
						'url'  => get_term_link( $currentitem['term_id'] ),
						'text' => $currentitem['text'],
					];
				}
				$links = $parents;
			}

			return $links;
		}
	}
}

//========================================================================================================
if ( ! function_exists( 'ictuwp_od_change_tip_permalinks ' ) ) {

	// Apply to field named "od_overzicht_alle_tips".
	add_filter( 'acf/update_value/name=od_overzicht_alle_tips', 'ictuwp_od_change_tip_permalinks', 10, 3 );

	function ictuwp_od_change_tip_permalinks( $value, $post_id, $field ) {

		if ( $value ) {

			$asf       = get_the_title( $value );
			$permalink = get_the_permalink( $value );
			$permalink = str_replace( home_url(), '', $permalink );
			$permalink = trim( $permalink, '/' );

			if ( $permalink ) {

				$args = array(
					"rewrite" => array(
						"slug"       => $permalink,
						"with_front" => true
					),
				);

				register_post_type( GC_TIP_CPT, $args );

				// ---------------------------------------------------------------------------------------------------
				// clean up after ourselves
				flush_rewrite_rules();

				if ( WP_DEBUG ) {

					// note in log
					error_log( 'ictuwp_od_change_tip_permalinks: slug for ' . GC_TIP_CPT . " changed to " . $permalink );

				}
			}
		}

		return $value;
	}
}

//========================================================================================================
/*
 * Deze function wijzigt de main query voor de tipgever- en speelset-taxonomieen
 * van optimaal digitaal.
 * Door deze wijziging wordt op 1 pagina een overzicht getoond van ALLE kaarten bij een bepaalde
 * speelset / tipgever, in plaats van maximaal posts_per_page (meestal 10)
 */
function od_modify_taxonomy_query( $query ) {

	global $query_vars;

	if ( ! is_admin() && $query->is_main_query() ) {

		if ( ( is_tax( OD_CITAATAUTEUR ) ) || ( is_tax( GC_ODSPEELSET ) ) || ( is_tax( GC_TIPTHEMA ) ) ) {
			// geen pagination voor tipgevers of speelset overzichten of tipthema's
			$query->set( 'posts_per_page', - 1 );

			return $query;

		}

	}

	return $query;
}

add_action( 'pre_get_posts', 'od_modify_taxonomy_query' );

//========================================================================================================

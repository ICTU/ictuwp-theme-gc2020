<?php
/**
 * Template Name: Landingspagina
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

$timber_post     = new Timber\Post();
$context['post'] = $timber_post;

if ( get_field( 'post_inleiding' ) ) {
	// ACF veld 'post_inleiding' is gevuld
	$intro            = get_field( 'post_inleiding' );
	$context['intro'] = wpautop( $intro );

}

$spotlightblocks = spotlight_block_get_data();

if ( $spotlightblocks ) {

	$context['spotlight'] = $spotlightblocks;

}


Timber::render( array( 'page-landing.twig', 'page.twig' ), $context );

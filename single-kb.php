<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::query_post();
$context['post'] = $timber_post;

// de publicatiedatum is geen relevante informatie voor een KB-artikel. Daarentegen is
// de tijd en datum van laatste wijziging wel nuttige informatie. Maar deze extra
// informatie is niet standaard beschikbaar.
// Daarom voegen we die hierbij toe, zowel datum als tijd.
$context['last_changed'] = get_the_modified_time( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );

if ( 'ja' === get_field( 'downloads_tonen' ) && get_field( 'download_items' ) ) {

	$context['downloads'] = download_block_get_data();

}

if ( 'ja' === get_field( 'gerelateerde_content_toevoegen' ) ) {

	$context['related'] = related_block_get_data();

}

if ( 'ja' === get_field( 'links_tonen' ) ) {

	$context['links'] = links_block_get_data();

}

$spotlightblocks = spotlight_block_get_data();

if ( $spotlightblocks ) {

	$context['spotlight'] = $spotlightblocks;

}

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $timber_post->ID . '.twig', 'single-' . $timber_post->post_type . '.twig', 'single-' . $timber_post->slug . '.twig', 'single.twig' ), $context );
}

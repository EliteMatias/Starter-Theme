<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
  Container::make( 'theme_options', __( 'Theme Options' ) )
    ->add_tab( __( 'Contact Info' ), array(
      Field::make( 'text', 'elite_email', __( 'Email' ) )
        ->set_attribute( 'placeholder', 'dummy@email.com' ),
      Field::make( 'text', 'elite_phone', __( 'Phone Number' ) )
        ->set_attribute( 'placeholder', '(+---) --- ----' ),
    ) )
    ->add_tab( __( 'Default Banner' ), array(
      Field::make( 'image', 'elite_banner_image', __( 'Banner Image' ) ),
      Field::make( 'text', 'elite_banner_title', __( 'Custom Title' ) )
        ->set_attribute( 'placeholder', 'Replace default post title' ),
    ) );
}
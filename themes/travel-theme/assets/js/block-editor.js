wp.domReady( function() {
    wp.blocks.unregisterBlockStyle( 'core/quote', 'large' );

    wp.blocks.registerBlockStyle( 'core/quote', {
        name: 'fancy-quote',
        label: 'Fancy Quote',
    } );

    wp.blocks.registerBlockStyle( 'core/heading', {
        name: 'underline',
        label: 'underline',
    } );
} );
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

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'fancy-ordered-list',
        label: 'Fancy Ordered List',
    } );

    wp.blocks.registerBlockStyle( 'core/verse', {
        name: 'fancy-verse',
        label: 'Fancy verse',
    } );
} );
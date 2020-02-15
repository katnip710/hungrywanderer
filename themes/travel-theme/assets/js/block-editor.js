wp.domReady( function() {
    wp.blocks.unregisterBlockStyle( 'core/quote', 'default' );
    wp.blocks.unregisterBlockStyle( 'core/quote', 'large' );

    wp.blocks.registerBlockStyle( 'core/quote', {
        name: 'fancy-quote',
        label: 'Fancy Quote',
    } );

    wp.blocks.registerBlockStyle( 'core/heading', {
        name: 'underline',
        label: 'underline',
    } );

    wp.blocks.unregisterBlockStyle( 'core/list', 'default' );

    wp.blocks.registerBlockStyle( 'core/list', {
        name: 'fancy-list',
        label: 'Fancy List',
    } );

    wp.blocks.unregisterBlockStyle( 'core/verse', 'default' );

    wp.blocks.registerBlockStyle( 'core/verse', {
        name: 'fancy-verse',
        label: 'Fancy Verse',
    } );

    wp.blocks.unregisterBlockStyle( 'core/separator', 'default' );
    wp.blocks.unregisterBlockStyle( 'core/separator', 'wide' );
    wp.blocks.unregisterBlockStyle( 'core/separator', 'dots' );

    wp.blocks.registerBlockStyle( 'core/separator', {
        name: 'airplane',
        label: 'Airplane',
    } );

    wp.blocks.registerBlockStyle( 'core/separator', {
        name: 'flowers',
        label: 'Flowers',
    } );
} );
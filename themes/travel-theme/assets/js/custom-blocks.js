const { registerBlockType } = wp.blocks;

registerBlockType('wanderers/custom-border', {
    // built in attributes
    title: 'Border',
    description: 'Add border to block',
    icon: 'format-image',
    category: 'layout',

    // custom attributes
    attributes: {},

    // custom functions

    // built-in functions
    edit() {}, 
    save() {}
}); 
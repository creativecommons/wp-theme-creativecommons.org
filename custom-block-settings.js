// Enable spacing control on the following blocks
const enableSpacingControlOnBlocks = [
    'core/columns',
    'core/column',
    'core/group',
];
 
/**
 * Add spacing control attribute to block.
 *
 * @param {object} settings Current block settings.
 * @param {string} name Name of block.
 *
 * @returns {object} Modified block settings.
 */
const addSpacingControlAttribute = ( settings, name ) => {
    // Do nothing if it's another block than our defined ones.
    if ( ! enableSpacingControlOnBlocks.includes( name ) ) {
        return settings;
    }

    // Use Lodash's merge to gracefully handle if attributes are undefined
    settings = lodash.merge( settings, {
        supports: {
            spacing: {
                blockGap: true,
                margin: true,  
                padding: true, 
            }
        }
    } );
    console.log(settings);
    return settings;
};

wp.hooks.addFilter(
    'blocks.registerBlockType',
    'custom-spacing',
    addSpacingControlAttribute
);

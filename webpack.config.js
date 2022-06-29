const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );
const path = require('path')

module.exports = {
    ...defaultConfig,
    devtool: 'source-map',
    entry: {
        'additional-authors': path.resolve(__dirname, './src/gutenberg.js'),
        'additional-authors-meta-box': path.resolve(__dirname, './src/meta-box.js'),
        'users-table': path.resolve(__dirname, './src/users-table.ts'),
    },
    output: {
        path: path.resolve(__dirname, './public/dist/.'),
    },
}

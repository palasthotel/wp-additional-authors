const defaultConfig = require('@wordpress/scripts/config/webpack.config');
const { CycloneDxWebpackPlugin } = require('@cyclonedx/webpack-plugin');

/**
 * Production builds also write a CycloneDX SBOM of what webpack bundled into
 * <output-path>/cyclonedx/bom.json - public/build/cyclonedx/bom.json for the
 * scripts and public/build/blocks/cyclonedx/bom.json for the blocks. The release
 * workflows of palasthotel/github-workflows collect them for Dependency-Track and
 * keep cyclonedx/ out of the plugin payload, so they never ship to wordpress.org.
 * `wp-scripts start` (development mode) does not write an SBOM.
 */
function withSbom(config) {
    if (config.mode !== 'production') {
        return config;
    }
    return {
        ...config,
        plugins: [
            ...config.plugins,
            new CycloneDxWebpackPlugin({
                specVersion: '1.6',
                outputLocation: './cyclonedx',
                includeWellknown: false,
                reproducibleResults: true,
            }),
        ],
    };
}

// wp-scripts exports an array (script and module config) when the
// --experimental-modules flag is set, otherwise a single config.
module.exports = Array.isArray(defaultConfig)
    ? defaultConfig.map(withSbom)
    : withSbom(defaultConfig);

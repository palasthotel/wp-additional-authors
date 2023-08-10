import { registerPlugin } from '@wordpress/plugins';
import { PluginPostStatusInfo } from '@wordpress/edit-post';
import Plugin from "./gutenberg/Plugin.js";

const AdditionalAuthorsPlugin = () => (
    <PluginPostStatusInfo>
        <Plugin
            {...AdditionalAuthors}
        />
    </PluginPostStatusInfo>
);

registerPlugin( 'post-status-info-test', { render: AdditionalAuthorsPlugin } );

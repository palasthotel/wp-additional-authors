import { registerPlugin } from '@wordpress/plugins';
import { PluginPostStatusInfo } from '@wordpress/edit-post';
import Plugin from "./gutenberg/Plugin.jsx";

const availableAuthors = [];

const AdditionalAuthors = () => (
    <PluginPostStatusInfo>
        <Plugin
            availableAuthors={availableAuthors}
            i18n={AdditionalAuthors.i18n}
        />
    </PluginPostStatusInfo>
);

registerPlugin( 'post-status-info-test', { render: AdditionalAuthors } );

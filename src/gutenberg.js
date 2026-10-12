import { registerPlugin } from '@wordpress/plugins';
import { PluginDocumentSettingPanel } from '@wordpress/editor';
import Plugin from "./gutenberg/Plugin.js";

const AdditionalAuthorsPlugin = () => (
    <PluginDocumentSettingPanel
        name="additional-authors"
        title={ AdditionalAuthors.i18n.label }
    >
        <Plugin
            {...AdditionalAuthors}
        />
    </PluginDocumentSettingPanel>
);

registerPlugin( 'additional-authors', { render: AdditionalAuthorsPlugin } );

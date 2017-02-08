import React from 'react';
import ReactDOM from 'react-dom';
import MetaBox from './meta-box.jsx';

/**
 * wait for dom to be ready so all plugins etc are loaded
 */
document.addEventListener("DOMContentLoaded", function(event) {
	/**
	 * Toolbar button components
	 */
	const tb = window.grid_toolbar_buttons;
	const etb = window.grid_toolbar_buttons_editor;
	
	/**
	 * grid overlays
	 */
	const gov = window.grid_overlays;
	const eov = window.grid_overlays_editor;
	
	/**
	 * append app to grid app root
	 */
	
	const {language, users, selected, root, onAuthorsChange} = window.additional_authors;
	
	ReactDOM.render(
		<MetaBox
			language={language}
			users={users}
		    selected={selected}
		    onAuthorsChange={onAuthorsChange}
		/>,
		root
	);
});
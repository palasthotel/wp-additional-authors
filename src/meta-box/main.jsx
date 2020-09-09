import React from 'react';
import ReactDOM from 'react-dom';
import MetaBox from './meta-box.jsx';

/**
 * wait for dom to be ready so all plugins etc are loaded
 */
document.addEventListener("DOMContentLoaded", function(event) {
	
	/**
	 * append app to grid app root
	 */
	
	const {language, users, selected, root_id} = AdditionalAuthors;

	const isGutenberg = typeof wp.blocks !== typeof undefined;
	
	ReactDOM.render(
		<MetaBox
			isGutenbergActive={isGutenberg}
			language={language}
			users={users}
		    selected={selected}
			onAuthorsChange={(authors)=>{
				document.dispatchEvent(new CustomEvent("onAdditionalAuthorsChange", { detail: authors }));
			}}
		/>,
		document.getElementById(root_id)
	);
});
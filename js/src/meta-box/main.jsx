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
	
	ReactDOM.render(
		<MetaBox
			language={language}
			users={users}
		    selected={selected}
		/>,
		document.getElementById(root_id)
	);
});
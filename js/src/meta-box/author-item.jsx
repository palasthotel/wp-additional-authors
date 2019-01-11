import React, {Component} from 'react';
import PropTypes from 'prop-types';

class AuthorItem extends Component {
	
	/**
	 * ------------------------------------------------
	 * lifecycle
	 * ------------------------------------------------
	 */
	constructor(props) {
		super(props);
		
	}
	
	/**
	 * ------------------------------------------------
	 * rendering
	 * ------------------------------------------------
	 */
	render() {
		const {author, isMainAuthor} = this.props;
		return (
			<div
				className={`author-item${(isMainAuthor)?" is-main-author":""}${(author.ID < 0)?" is-new-author":""}`}
			>
				<span className="autor-item__name">
					{this.wrapWithProfileLink(author.display_name)}
					<span className="author-item__nicename">{author.user_nicename}</span>
				</span>

				{this.renderDelete()}
				
				<span
					className="author-item__move author-item__up"
				    onClick={this.onChangePosition.bind(this,-1)}
				>
					▲
				</span>
				<span
					className="author-item__move author-item__down"
				    onClick={this.onChangePosition.bind(this,1)}
				>
					▼
				</span>
				<input type="hidden" name="additional_authors[ids][]" value={author.ID} />
				<input type="hidden" name="additional_authors[names][]" value={author.display_name} />
			</div>
		)
	}

	renderDelete(){
		if(this.props.isMainAuthor) return null;
		return (
			<span
				className="author-item__delete"
				onClick={this.props.onUnselect}
			>
				&times;
			</span>
		)
	}
	wrapWithProfileLink(frag){
		const {ID} = this.props.author;
		if(ID > 0){
			return <a href={`/wp-admin/user-edit.php?user_id=${ID}`} target="_blank">{frag}</a>
		}
		return frag
	}

	/**
	 * ------------------------------------------------
	 * events
	 * ------------------------------------------------
	 */
	onChangePosition(diff){
		this.props.onChangePosition((this.props.index+diff));
	}
	
	/**
	 * ------------------------------------------------
	 * other functions
	 * ------------------------------------------------
	 */
}

/**
 * property defaults
 */
AuthorItem.defaultProps = {
	author: {
		ID: -1,
		name: "",
		user_login: "",
	},
	className: "",
};

/**
 * define property types
 */
AuthorItem.propTypes = {
	author: PropTypes.object.isRequired,
	index: PropTypes.number.isRequired,
	onUnselect: PropTypes.func.isRequired,
	onChangePosition: PropTypes.func.isRequired,
	isMainAuthor: PropTypes.bool.isRequired,
};

/**
 * export component to public
 */
export default AuthorItem;
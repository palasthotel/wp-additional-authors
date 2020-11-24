import PropTypes from 'prop-types';

const Delete = ({onClick}) => {
	return (
		<span
			className="author-item__delete"
			onClick={onClick}
		>
			&times;
		</span>
	)
}

const ProfileLink = ({author}) => {
	const {ID,display_name} = author;
	if(ID > 0){
		return <a href={`/wp-admin/user-edit.php?user_id=${ID}`} target="_blank">{display_name}</a>
	}
	return display_name
}

const AuthorItem = ({author, isMainAuthor, index, onUnselect, onChangePosition})=>{

	return (
		<div
			className={`author-item${(isMainAuthor)?" is-main-author":""}${(author.ID < 0)?" is-new-author":""}`}
		>
				<span className="autor-item__name">
					<ProfileLink author={author} />
					<span className="author-item__nicename">{author.user_nicename}</span>
				</span>

			{isMainAuthor? null : <Delete onClick={onUnselect} /> }

			<span
				className="author-item__move author-item__up"
				onClick={()=>onChangePosition(index-1)}
			>
					▲
				</span>
			<span
				className="author-item__move author-item__down"
				onClick={()=>onChangePosition(index+1)}
			>
					▼
				</span>
			<input type="hidden" name="additional_authors[ids][]" value={author.ID} />
			<input type="hidden" name="additional_authors[names][]" value={author.display_name} />
		</div>
	)

}

/**
 * property defaults
 */
AuthorItem.defaultProps = {
	author: {
		ID: -1,
		display_name: "",
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
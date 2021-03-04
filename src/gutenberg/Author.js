import PropTypes from 'prop-types';
import "./Author.css";

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

const Author = ({author, index, onUnselect, onChangePosition})=>{

	return (
		<div
			className={`author-item ${(author.ID < 0)?"is-new-author":""}`}
		>
				<span className="autor-item__name">
					<ProfileLink author={author} />
					<span className="author-item__nicename">{author.user_nicename}</span>
				</span>

			<Delete onClick={onUnselect} />

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
		</div>
	)

}

/**
 * property defaults
 */
Author.defaultProps = {
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
Author.propTypes = {
	author: PropTypes.object.isRequired,
	index: PropTypes.number.isRequired,
	onUnselect: PropTypes.func.isRequired,
	onChangePosition: PropTypes.func.isRequired,
	isMainAuthor: PropTypes.bool.isRequired,
};

/**
 * export component to public
 */
export default Author;
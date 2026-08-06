import PropTypes from 'prop-types';
import { Button, Flex, FlexItem, __experimentalText as Text } from "@wordpress/components";
import { chevronDown, chevronUp, closeSmall } from "@wordpress/icons";
import "./Author.css";

const ProfileLink = ({author}) => {
	const {ID,display_name} = author;
	if(ID > 0){
		return <a href={`/wp-admin/user-edit.php?user_id=${ID}`} target="_blank">{display_name}</a>
	}
	return display_name
}

const Author = ({author, index, isFirst, isLast, onUnselect, onChangePosition, i18n})=>{

	return (
		<Flex
			className={`author-item ${(author.ID < 0)?"is-new-author":""}`}
			align="center"
			gap="1"
		>
			<FlexItem isBlock>
				<Text>
					<ProfileLink author={author} />
				</Text>
			</FlexItem>
			<Button
				size="small"
				icon={chevronUp}
				label={i18n.move_up}
				disabled={isFirst}
				onClick={()=>onChangePosition(index-1)}
			/>
			<Button
				size="small"
				icon={chevronDown}
				label={i18n.move_down}
				disabled={isLast}
				onClick={()=>onChangePosition(index+1)}
			/>
			<Button
				size="small"
				icon={closeSmall}
				isDestructive
				label={i18n.remove}
				onClick={onUnselect}
			/>
		</Flex>
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
	isFirst: PropTypes.bool.isRequired,
	isLast: PropTypes.bool.isRequired,
	onUnselect: PropTypes.func.isRequired,
	onChangePosition: PropTypes.func.isRequired,
	isMainAuthor: PropTypes.bool.isRequired,
	i18n: PropTypes.object.isRequired,
};

/**
 * export component to public
 */
export default Author;

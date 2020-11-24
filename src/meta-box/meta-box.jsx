import {Component} from 'react';
import PropTypes from 'prop-types';
import _ from 'underscore';

import Search from './search.jsx';
import AuthorItem from './author-item.jsx';

class MetaBox extends Component {
	
	/**
	 * ------------------------------------------------
	 * lifecycle
	 * ------------------------------------------------
	 */
	constructor(props) {
		super(props);
		
		this.state = {
			users: props.users,
			selected: this.props.selected,
			new_user_id: -1,
		};
		
	}

	componentDidMount(){
		this.dispatchChanged();
		this.getMainUserControl();
	}
	
	/**
	 * ------------------------------------------------
	 * rendering
	 * ------------------------------------------------
	 */
	render() {
		const {language, isGutenbergActive} = this.props;
		const {selected, users, new_users, main_author} = this.state;
		let gutenbergInfo = null;
		if(isGutenbergActive){
			gutenbergInfo = <input type="hidden" name="additional_authors_is_gutenberg" value="it-is" />
		}
		return (
			<div className="additional-authors">
				{gutenbergInfo}
				<Search
					users={users}
					selected={selected}
					languages={language}
				    onSelect={this.onSelect.bind(this)}
				/>
				
				<hr/>
				
				<p><i>{language.description}</i></p>

				<div>

					{selected.map((id, index)=>{
						if(isGutenbergActive && index === 0) return null;
						for(const key in users){
							if(!users.hasOwnProperty(key)) continue;
							const _user = users[key];
							if(parseInt(_user.ID) === parseInt(id)){
								return (
									<AuthorItem
										key={id}
										index={index}
										author={_user}
									    onUnselect={this.onUnselect.bind(this,_user)}
									    onChangePosition={this.onChangePosition.bind(this,_user, index)}
									    isMainAuthor={(index === 0)}
									/>
								)
							}
						}
						return null;
					})}
				</div>
			</div>
		)
	}
	
	/**
	 * ------------------------------------------------
	 * events
	 * ------------------------------------------------
	 */
	onSelect(author){
		if(author.ID == 0){
			author.ID = this.state.new_user_id--;
			this.state.users.push(author);
		}
		
		this.state.selected.push(author.ID);
		this.state.selected = _.unique(this.state.selected);
		this.setState({ selected: this.state.selected });

		this.dispatchChanged();
		
	}
	onUnselect(author){
		let selected = [];
		if(this.state.main_author == author.ID){
			console.log("you cannot delete main author");
			return;
		}
		for(let _id of this.state.selected){
			
			if(_id == author.ID) continue;
			selected.push(_id);
		}
		this.setState({selected: selected});
		this.dispatchChanged()
	}
	onChangePosition(user, from, to){
		let selected = [];
		
		/**
		 * new user cannot be on first position
		 */
		if(to == 0 && user.ID <= 0) return;
		
		for(let index in this.state.selected){
			
			if(!this.state.selected.hasOwnProperty(index)) continue;
			
			if(index == from){
				selected.push(this.state.selected[to]);
			} else if( index == to){
				selected.push(this.state.selected[from]);
			} else {
				selected.push(this.state.selected[index]);
			}
		}
		this.setMainUserID(selected[0]);
		this.setState({selected: selected, main_author: this.getMainUserID()});
		this.dispatchChanged();
	}
	onMainAuthorChanged(e){
		const author_id = e.target.value;
		
		/**
		 * remove if already in selecteds
		 * @type {number}
		 */
		let index = 0;
		while(index < this.state.selected.length){
			if(this.state.selected[index] === author_id){
				this.state.selected.splice(index,1);
				break;
			}
			index++;
		}
		
		/**
		 * add to top as main author
		 */
		this.state.selected.unshift(author_id);
		
		// update main author
		this.setState({selected:this.state.selected});
	}
	
	/**
	 * ------------------------------------------------
	 * other functions
	 * ------------------------------------------------
	 */
	getMainUserControl(){
		if(this.props.isGutenbergActive) return null;

		if(this._main_user_select != null) return this._main_user_select;
		let control = document.getElementById("post_author_override");
		if(control == null)
			control = document.getElementById("post-author-selector-1");

		if(control != null){
			this._main_user_select = control;
			this._main_user_select.addEventListener("change",this.onMainAuthorChanged.bind(this));
		}
		return this._main_user_select;
	}
	setMainUserID(user_id){
		const control = this.getMainUserControl();
		if(typeof control !== typeof undefined && control != null){
			control.value = user_id;
			control.dispatchEvent(new Event("change"));
		}

	}
	getMainUserID(){
		const control = this.getMainUserControl();
		if(typeof control !== typeof undefined && control !== null) return control.value;
 		return -1;
	}
	isSelected(user_id){
		for(let _uid of this.state.selected){
			if(_uid === user_id) return true;
		}
		return false;
	}
	dispatchChanged(){
		clearTimeout(this.dispatchTimeout);
		this.dispatchTimeout = setTimeout(()=>{
			const users = [];
			for(const uid of this.state.selected){
				for(const user of this.props.users){
					if(parseInt(user.ID) === parseInt(uid)){
						users.push({...user});
					}
				}
			}
			this.props.onAuthorsChange(users);
		}, 300);

	}
}

/**
 * property defaults
 */
MetaBox.defaultProps = {
	users: [],
	language: {},
	onAuthorsChange: () => {},
};

/**
 * define property types
 */
MetaBox.propTypes = {
	isGutenbergActive: PropTypes.bool.isRequired,
	users: PropTypes.array.isRequired,
	selected: PropTypes.array.isRequired,
	language: PropTypes.object.isRequired,
	onAuthorsChange: PropTypes.func,
};

/**
 * export component to public
 */
export default MetaBox;
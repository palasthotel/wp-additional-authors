import React, {Component, PropTypes} from 'react';
import SearchItem from './search-item.jsx';
import NewItem from './new-item.jsx';

class Search extends Component {
	
	/**
	 * ------------------------------------------------
	 * lifecycle
	 * ------------------------------------------------
	 */
	constructor(props) {
		super(props);
		this.state = {
			query: "",
			over_index: 0,
			search_result: [],
			focus: false,
		}
	}
	
	/**
	 * ------------------------------------------------
	 * rendering
	 * ------------------------------------------------
	 */
	render() {
		const {query} = this.state;
		return (
			<div
				className="additional-authors-search"
			    onKeyUp={this.onKeyUp.bind(this)}
			>
				<label>
					{this.props.languages.label}
					<br />
					<input
						className="additional-authors-search__input"
						type="text"
						value={query}
						onKeyDown={this.onKeyDown.bind(this)}
					    onChange={this.onChange.bind(this)}
					    onFocus={this.onFocusSearch.bind(this, true)}
					    onBlur={this.onFocusSearch.bind(this, false)}
					/>
				</label>
				{this.renderList()}
			</div>
		)
	}
	renderList(){
		const {selected} = this.props;
		const {over_index, search_result, focus, query} = this.state;
		if(focus){
			return (
				<div
					className="additional-authors-search-list"
				>
					{search_result.map((item, index)=>{
						return <SearchItem
							key={item.ID}
							author={item}
							onSelect={this.onSelect.bind(this, item)}
							isOver={(over_index == index)}
						/>
					})}
					<NewItem
						name={query}
						isOver={(over_index == search_result.length)}
					    onSelect={this.onNewItem.bind(this)}
					/>
				</div>
			)
		}
		return null;
	}
	
	/**
	 * ------------------------------------------------
	 * events
	 * ------------------------------------------------
	 */
	onChange(e){
		
		if(e) this.state.query = e.target.value;
		
		const {users, selected} = this.props;
		const {query} = this.state;
		
		let search_result = [];
		
		if(query != ''){
			for(let user of users){
				if(user.display_name.toLowerCase().indexOf(query.toLowerCase()) > -1){
					if(selected.indexOf(user.ID) >= 0) continue;
					search_result.unshift(user);
				}
			}
		} else {
			search_result = [];
		}
		
		this.setState({over_index: 0, search_result: search_result});
		
		
	}
	onFocusSearch(focus){
		if(!focus){
			// just enough time to check if list item was clicked
			setTimeout(()=>{
				this.setState({focus: focus});
			},100);
			return;
		}
		this.setState({focus: focus});
	}
	onSelect(user){
		this.props.onSelect(user);
		this.onChange();
	}
	onNewItem(name){
		this.props.onSelect({
			ID: 0,
			display_name: name,
			user_nicename: "-",
		});
	}
	onKeyDown(e){
		const ENTER = 13;
		if(ENTER == e.keyCode && this.state.focus){
			e.preventDefault();
			if(typeof this.state.search_result[this.state.over_index] != typeof undefined ){
				this.onSelect(this.state.search_result[this.state.over_index]);
			}
		}
	}
	onKeyUp(e){
		
		if(!this.state.focus) return;
		
		const ESC = 27;
		const UP = 38;
		const DOWN = 40;
		
		if(ESC == e.keyCode){
			this.setState({search_result: []});
			return;
		}
		else if(UP == e.keyCode){
			e.preventDefault();
			this.state.over_index--;
		} else if(DOWN == e.keyCode){
			e.preventDefault();
			this.state.over_index++;
		}
		if(this.state.over_index > this.state.search_result.length){
			this.state.over_index = this.state.search_result.length;
		} else if(this.state.over_index < 0) {
			this.state.over_index = 0;
		}
		
		this.setState({over_index: this.state.over_index });
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
Search.defaultProps = {
	users: [],
};

/**
 * define property types
 */
Search.propTypes = {
	users: PropTypes.array.isRequired,
	selected: PropTypes.array.isRequired,
	languages: PropTypes.object.isRequired,
	onSelect: PropTypes.func.isRequired,
};

/**
 * export component to public
 */
export default Search;
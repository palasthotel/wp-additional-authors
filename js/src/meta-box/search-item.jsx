import React, {Component, PropTypes} from 'react';

class SearchItem extends Component{
	constructor(props){
		super();
		this.state = {
			over: props.isOver,
		};
	}
	componentWillReceiveProps(nextProps){
		this.state.over = nextProps.isOver;
	}
	render(){
		const {display_name} = this.props.author;
		return(
			<div
				onMouseOver={this.onMouseOver.bind(this, true)}
				onMouseOut={this.onMouseOver.bind(this, false)}
				onClick={this.onClick.bind(this)}
				className={`additional-authors-search-item ${(this.state.over)? 'is-over': ''}`}
			>
				{display_name}
			</div>
		)
	}
	onMouseOver(is_over){
		this.setState({over: is_over});
	}
	onClick(){
		this.props.onSelect(this.props.author);
	}
}

/**
 * export component to public
 */
export default SearchItem;
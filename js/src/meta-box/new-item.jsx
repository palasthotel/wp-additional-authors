import React, {Component, PropTypes} from 'react';

class NewItem extends Component{
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
		return(
			<div
				onMouseOver={this.onMouseOver.bind(this, true)}
				onMouseOut={this.onMouseOver.bind(this, false)}
				onClick={this.onClick.bind(this)}
				className={`additional-authors-new-item ${(this.state.over)? 'is-over': ''}`}
			>
				New user "{this.props.name}"
			</div>
		)
	}
	onMouseOver(is_over){
		this.setState({over: is_over});
	}
	onClick(){
		this.props.onSelect(this.props.name);
	}
}

/**
 * export component to public
 */
export default NewItem;

const path = require('path');
// const webpack = require('webpack');

const config = {
	entry: {
  	main: './js/src/meta-box/main.jsx',
  },
	output: {

		path: path.resolve(__dirname, 'js/bundle/'),
		filename: '[name].js',
		sourceMapFilename: '[name].map',
	},
	devtool: 'source-map',
	module: {
		rules: [
			{
				test: /\.jsx$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ["@babel/preset-env", "@babel/react"],
						plugins: ["@babel/plugin-proposal-object-rest-spread"],
					}
				},

			}
		]
	},
};


if(process.env.NODE_ENV === "production"){
	config.output.filename = "[name].min.js";
	config.output.sourceMapFilename = "[name].min.map";
	config.plugins = [
		// new webpack.DefinePlugin({
		// 	'process.env': {
		// 		'NODE_ENV': JSON.stringify('production')
		// 	}
		// })
	];
}

module.exports = config;
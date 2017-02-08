
// const webpack = require('webpack');

const config = {
	entry: {
  	main: './js/src/meta-box/main.jsx',
  },
	output: {
		path: './js/bundle/',
		filename: '[name].js',
		sourceMapFilename: '[name].map',
	},
	devtool: 'source-map',
	module: {
		loaders: [
			{
				test: /\.jsx$/,
				exclude: /node_modules/,
				loader: 'babel-loader',
				query: {
					presets: ["es2015", "react"],
					plugins: ["transform-object-rest-spread"],
				}
			}
		]
	},
};


if(process.env.NODE_ENV == "production"){
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
/**
 * Lazy load axios module
 * @return {Promise} [description]
 */
export default () => {
	return import(/*webpackChunkName: "axios"*/'axios')
		.then(({default: axios}) => { return axios; });
}
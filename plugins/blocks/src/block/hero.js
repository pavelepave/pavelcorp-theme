/**
 * BLOCK: Hero
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';

import Uploader from '../utils/media-upload';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { RichText, URLInput } = wp.blockEditor; 
const { withSelect } = wp.data;

/**
 * Register: aa Gutenberg Block.
 *
 * Registers a new block provided a unique name and an object defining its
 * behavior. Once registered, the block is made editor as an option to any
 * editor interface where blocks are implemented.
 *
 * @param  {string}   name     Block name.
 * @param  {Object}   settings Block settings.
 * @return {?WPBlock}          The block, if it has been successfully
 *                             registered; otherwise `undefined`.
 */
registerBlockType( 'pavelcorp/hero-block', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Hero Block', 'pavelcorp' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [],
	attributes: {
		richText: {
			type: 'array',
			source: 'children',
			selector: 'p'
		},
		title: {
			type: 'array',
			source: 'children',
			selector: 'h2'
		},
		ctaText: {
			type: 'array',
			source: 'children',
			selector: 'a'
		},
		url: {
			type: 'string',
			default: ''
		},
		mediaId: {
			type: 'number',
			default: 0
		},
		mediaUrl: {
			type: 'string',
			default: ''
		},
		reversed: {
			type: 'boolean',
			default: false
		}
	},

	// The "edit" property must be a valid function.
	edit: (props) => {

		/**
		 * Update URL on input change
		 * @param {string} url 
		 */
		const onSelectUrl = function (url) {
			props.setAttributes({ url: url })
		}

		/**
		 * Set content
		 * @param {Object} props Props.
		 */
		function setRichText(props) {
			return (val) => {
				props.setAttributes( {richText: val} )
			}
		}

		/**
		 * Set button text
		 * @param {Object} props Props.
		 */
		function setCtaText(props) {
			return (val) => {
				props.setAttributes( {ctaText: val} )
			}
		}

		/**
		 * Set title
		 * @param {Object} props Props.
		 */
		function setTitle(props) {
			return (val) => {
				props.setAttributes({ title: val })
			}
		}

		/**
		 * Set checkbox
		 */
		function setReverse(props) {
			return (evt) => {
				props.setAttributes({ reversed: evt.target.checked})
			}
		}

		return (
			<div>
				<Uploader 
					{...props} 
					mediaId={props.attributes.mediaId} 
					mediaUrl={props.attributes.mediaUrl}
				/>

				{/* Hero title */}
				<RichText
					tagName='h2'
					label='Title'
					value={props.attributes.title}
					onChange={setTitle(props)}
					placeholder={__('Title', 'pavelcorp')}
				/>

				{/* Hero content */}
				<RichText
					tagName='p'
					label='Content'
					value={props.attributes.richText}
					onChange={setRichText(props)}
					placeholder={__('Content', 'pavelcorp')}
					style={{ margin: `0 0 24px` }}
				/>

				{/* Hero button text */}
				<RichText
					tagName='a'
					label='Button'
					href={props.attributes.url ? props.attributes.url : ''}
					className="components-button is-primary"
					value={props.attributes.ctaText}
					onChange={setCtaText(props)}
					placeholder={__('Button text', 'pavelcorp')}
					style={{ margin: `0 0 16px` }}
				/>

				{/* Hero link */}
				<URLInput value={props.attributes.url} onChange={onSelectUrl} />

				{/* Reverse ? */}
				{__('Regular', 'pavelcorp')}
				<label 
					className={`Block-Radio`}
					htmlFor={`reversed-${props.clientId}`}
				>
					<input 
						id={`reversed-${props.clientId}`}
						type="checkbox" 
						checked={props.attributes.reversed} 
						name="reversed" 
						onChange={setReverse(props)}
					/>
					<span aria-hidden="true"/>
				</label>
				{__('Reversed', 'pavelcorp')}
			</div>
		);
	},

	// The "save" property must be specified and must be a valid function.
	save: function( props ) {
		const blockClass = `Block-Hero`;
		const reversedClass = `Block-Hero--Reverse`;
		const className = props.attributes.reversed ? `${blockClass} ${reversedClass}` : `${blockClass}`;
		return (
			<div className={`${className}`}>
				<div>
					{
						props.attributes && props.attributes.mediaUrl &&
						<img src={props.attributes.mediaUrl} />
					}
				</div>
				<div>

					<RichText.Content
						tagName='h2'
						label='Title'
						className="title title--h2"
						value={props.attributes.title}
					/>

					<RichText.Content
						tagName='p'
						label='Content'
						value={props.attributes.richText}
					/>
					<div className={`Right`}>
						<RichText.Content
							tagName='a'
							label='Button'
							href={props.attributes.url ? props.attributes.url : ''}
							className="components-button is-primary button button--blue"
							value={props.attributes.ctaText}
						/>
					</div>
				</div>

			</div>
		);
	},
} );

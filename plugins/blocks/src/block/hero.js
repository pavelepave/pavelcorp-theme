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
import Image from '../utils/image';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { RichText, URLInput } = wp.blockEditor; 

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
		media: {
			type: 'object',
			default: {}
		},
		base64: {
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

		return (
			<div>
				<Uploader 
					{...props} 
					{...props.attributes}
				/>

				{/* Hero title */}
				<RichText
					tagName='h2'
					label='Title'
					value={props.attributes.title}
					placeholder={__('Title', 'pavelcorp')}
					onChange={
						(title) => {
							props.setAttributes({ title });
						} 
					}
				/>

				{/* Hero content */}
				<RichText
					tagName='p'
					label='Content'
					value={props.attributes.richText}
					placeholder={__('Content', 'pavelcorp')}
					style={{ margin: `0 0 24px` }}
					onChange={
						(richText) => {
							props.setAttributes({ richText });
						}
					}
				/>

				{/* Hero button text */}
				<RichText
					tagName='a'
					label='Button'
					href={props.attributes.url ? props.attributes.url : ''}
					className={`components-button is-primary`}
					value={props.attributes.ctaText}
					placeholder={__('Button text', 'pavelcorp')}
					style={{ margin: `0 0 16px` }}
					onChange={
						(ctaText) => {
							props.setAttributes({ ctaText });
						}
					}
				/>

				{/* Hero link */}
				<URLInput 
					value={props.attributes.url} 
					onChange={
						(url) => {
							props.setAttributes({ url });
						}
					} 
				/>

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
						onChange={
							(evt) => {
								props.setAttributes({ reversed: evt.target.checked })
							}
						}
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
					<div className={`Block-Hero__Img`}>
						{
							props.attributes && props.attributes.mediaUrl &&
							<Image 
								{...props.attributes}
								alt={props.attributes.title} 
							/>
						}
					</div>
				</div>
				<div>

					<RichText.Content
						tagName='h2'
						label='Title'
						value={props.attributes.title}
					/>

					<RichText.Content
						tagName='p'
						label='Content'
						value={props.attributes.richText}
					/>
					<div>
						<RichText.Content
							tagName='a'
							label='Button'
							href={props.attributes.url ? props.attributes.url : ''}
							className={`Btn`}
							value={props.attributes.ctaText}
						/>
					</div>
				</div>

			</div>
		);
	},
} );

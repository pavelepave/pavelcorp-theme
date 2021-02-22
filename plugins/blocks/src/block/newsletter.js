/**
 * BLOCK: Hero
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';

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
registerBlockType('pavelcorp/newsletter-block', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __('Newsletter/form Block', 'pavelcorp'), // Block title.
  icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [],
  attributes: {
    title: {
      type: 'array',
      source: 'children',
      selector: 'h3'
    },
    ctaText: {
      type: 'array',
      source: 'children',
      selector: 'a'
    },
  },

  // The "edit" property must be a valid function.
  edit: (props) => {

    return (
      <div>

        {/* Hero title */}
        <RichText
          tagName='h3'
          label='Title'
          value={props.attributes.title}
          placeholder={__('Title', 'pavelcorp')}
          onChange={
            (title) => {
              props.setAttributes({title})
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
              props.setAttributes({ctaText});
            }
          }
        />
      </div>
    );
  },

  // The "save" property must be specified and must be a valid function.
  save: function (props) {    
    return (
      <div className={`Block-Newsletter`}>
        <div>
          <RichText.Content
            tagName='h3'
            value={props.attributes.title}
          />

          <form>
            <div>
              <input
                className={`Input`}
                type={`email`}
                name={`email`}
                placeholder={__('john.smith@gmail.com', 'pavelcorp')}
                />
            </div>
            <div>
              <RichText.Content
                tagName={`button`}
                className={`Btn`}
                value={props.attributes.ctaText}
              />
            </div>
          </form>
        </div>

      </div>
    );
  },
});

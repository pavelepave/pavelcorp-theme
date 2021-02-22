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
const { RichText } = wp.blockEditor;

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
registerBlockType('pavelcorp/features-block', {
  // Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
  title: __('Features Block', 'pavelcorp'), // Block title.
  icon: 'awards', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
  category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
  keywords: [],
  attributes: {
    features: {
      type: 'array',
      default: [{
        title: '',
      }]
    },
    title: {
      type: 'string',
      default: '',
    },
    content: {
      type: 'string',
      default: '',
    }
  },

  // The "edit" property must be a valid function.
  edit: (props) => {
    /**
     * Set feature value for specific key
     * @param {number} index
     * @param {string} key Object key
     * @param {string} val Value
     */
    function setFeature(index, key, val) {
      let oFeatures = [...props.attributes.features];
      
      // Add empty slot
      if (!key) { 
        oFeatures[oFeatures.length] = {};
      // Set value for key
      } else {
        if (!oFeatures[index]) oFeatures[index] = {};
        oFeatures[index][key] = val;
      }
      
      props.setAttributes({ features: oFeatures });
    }

    /**
     * Remove feature at index
     * @param {number} index
     */
    function removeFeature(index) {
      let oFeatures = [...props.attributes.features];
      oFeatures.splice(index,1);
      props.setAttributes({features: oFeatures});
    }

    /**
     * Feature
     */
    const Feature = ({ feature, index, ...props}) => {
      return (
        <div className={`Back-Block-Feature`}>
          <div>
            <Uploader
              {...props}
              {...props.attributes.features[index].media}
              onSelect={
                (media, base64) => {
                  setFeature(index, 'media', {
                    mediaId: media.id,
                    mediaUrl: media.url,
                    media,
                    base64
                  });
                }
              }
              onRemoveImg={
                (evt) => {
                  evt.preventDefault();
                  setFeature(index, 'media', {
                    mediaId: 0,
                    mediaUrl: '',
                    base64: null
                  });
                }
              }
            />
            <RichText
              tagName='h3'
              placeholder={__('Title', 'pavelcorp')}
              value={feature.title || ''}
              onChange={
                (val) => { setFeature(index, 'title', val) }
              }
            />
            <RichText
              tagName='p'
              placeholder={__('Content', 'pavelcorp')}
              value={feature.content || ''}
              onChange={
                (val) => { setFeature(index, 'content', val) }
              }
            />
            <div>
              <a
                href="javascript:{}"
                className={`Block-Remove`}
                onClick={
                  (evt) => {
                    evt.preventDefault();
                    removeFeature(index);
                  }
                }
              >
                {__('Remove', 'pavelcorp')}
              </a>
            </div>
          </div>
        </div>
      )
    }

    return (
      <div>
        <RichText
          tagName='h3'
          placeholder={__('Title', 'pavelcorp')}
          value={props.attributes.title}
          onChange={
            (val) => {
              props.setAttributes({title: val});
            } 
          }
        />

        <RichText
          tagName='p'
          placeholder={__('Content (otpional)', 'pavelcorp')}
          value={props.attributes.content}
          onChange={
            (val) => {
              props.setAttributes({content: val})
            }
          }
        />

        <h3>{__('Features', 'pavelcorp')}</h3>
        <div className={`Back-Block-Features`}>
          {
            props.attributes.features.map((feature, index) => (
              <div key={index}>
                <Feature 
                  {...props} 
                  feature={feature}
                  index={index} 
                />
              </div>
            ))
          }

        </div>
        <a 
          href="javascript:{}" 
          className={`Block-Add`}
          onClick={
            (evt) => {
              evt.preventDefault();
              setFeature();
            }
          }
        >{__('Add Feature', 'pavelcorp')}</a>
      </div>
    );
  },

  // The "save" property must be specified and must be a valid function.
  save: function (props) {
    return (
      <div className={`Block-Features`}>

        <div className={`Block-Features__Header`}>
          <h2>
            {props.attributes.title}
          </h2>
          {
            props.attributes.content &&
            <div>
              <RichText.Content
                value={props.attributes.content} 
                tagName={`p`}/>
            </div>
          }
        </div>

        <ul>
          {
            props.attributes.features.map((feature, key) => {
              if (!feature) return null;
              return (
                <li key={key}>
                  <div className={`Block-Feature`}>
                    <div className={`Block-Feature__Img`}>
                      <Image
                        {...feature.media}
                        alt={feature.title} 
                      />
                    </div>
                    <RichText.Content
                      tagName='h3'
                      value={feature.title}
                    />
                    <RichText.Content
                      tagName='p'
                      value={feature.content}
                    />
                  </div>
                </li>
              )
            })
          }
        </ul>
      </div>
    );
  },
});


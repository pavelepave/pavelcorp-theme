/**
 * UTILS: Media uplaod
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */
import axios from 'axios';

const { __ } = wp.i18n; 
const { MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { Button } = wp.components;

export default function Uploader({ mediaId, mediaUrl, ...props}) {

  /**
   * Select media default function
   * @param {*} media 
   */
  const defaultSelect = (media, base64) => {
    console.log(media,base64)
    props.setAttributes({
      mediaId: media.id,
      mediaUrl: media.url,
      media,
      base64
    })
  };

  /**
   * Remove media
   */
  const defaultRemove = (evt) => {
    evt.preventDefault();
    props.setAttributes({
      mediaId: 0,
      mediaUrl: '',
      base64: null
    })
  }

  function getMediaBase64(media, cb) {
    if (media && media.sizes && media.sizes.base64) {
      return axios.get(media.sizes.base64.url, {responseType: 'blob'})
        .then(({data}) => {
          const reader = new FileReader();
          reader.readAsDataURL(data)
          reader.onloadend = function() { 
            cb(reader.result);
          }
        }).finally(cb)
    }
    return cb();
  }

  return (
    <MediaUploadCheck>
      <MediaUpload
        onSelect={(arg) => {
          getMediaBase64(arg, (base64) => {
            props.onSelect ? props.onSelect(arg, base64) : defaultSelect(arg, base64);
          })
        }}
        value={mediaId || ''}
        allowedTypes={props.allowedTypes || ['image']}
        render={({ open }) => (
          <div>
            {
              (!mediaId || mediaId == 0) && 
              <div className={`Block-ResponsiveImg`}>
                <Button className={`Block-AddImg`} onClick={open}>
                  {__('Choose an image', 'pavelcorp')}
                </Button>
              </div>
            }
            {
              !!mediaId &&
              <div className={`Block-ResponsiveImg`}>
                <a 
                  className={`Block-ResponsiveImg__Remove`} 
                  onClick={props.onRemoveImg || defaultRemove}
                >
                  <span />
                  <span />
                </a>
                <img src={mediaUrl} alt={__('Selected image', 'pavelcorp')} />
              </div>
            }
          </div>
        )}>

      </MediaUpload>
    </MediaUploadCheck>
  )
}
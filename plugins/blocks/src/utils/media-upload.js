/**
 * UTILS: Media uplaod
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

const { __ } = wp.i18n; 
const { MediaUpload, MediaUploadCheck } = wp.blockEditor;
const { Button } = wp.components;

export default function Uploader({ mediaId, mediaUrl, ...props}) {

  /**
   * Select media default function
   * @param {*} media 
   */
  const defaultSelect = (media) => {
    props.setAttributes({
      mediaId: media.id,
      mediaUrl: media.url
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
    })
  }

  return (
    <MediaUploadCheck>
      <MediaUpload
        onSelect={props.onSelect || defaultSelect}
        value={mediaId || ''}
        allowedTypes={props.allowedTypes || ['image']}
        render={({ open }) => (
          <div>
            {
              (!mediaId || mediaId == 0) && 
              <Button className={`Block-AddImg`} onClick={open}>
                {__('Choose an image', 'pavelcorp')}
              </Button>
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
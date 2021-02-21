export default ({media, base64, mediaUrl, mediaId, ...props}) => {
  if (media && media.mime !== 'image/svg+xml' && media.sizes) {
    let srcSet = [];
    for (let key in media.sizes) {
      srcSet.push(media.sizes[key]);
    }

    return (
      <img 
        src={base64 ? `${base64}` :  media.sizes.base64.url}
        data-srcset={srcSet.map((src, index, arr) => {
          return `${src.url} ${src.width}w${index < arr.length - 1 ? ',' : ''}`;
        }).join('')}
        {...props}
      />
    )
  }

  return <img {...props} src={mediaUrl} />
}
/*
 * This gist will help you to fix orientation
 * of image picked from local FS
 * without canvas.
 * CSS-only!
 * 
 * @expample
 * const img = document.createElement('img')
 * img.src = URL.createObjectURL(file)
 * img.style.transform = ORIENT_TRANSFORMS[ getOrientation(file) ]
 */

const ORIENT_TRANSFORMS = {
    1: '',
    2: 'rotateY(180deg)',
    3: 'rotate(180deg)',
    4: 'rotate(180deg) rotateY(180deg)',
    5: 'rotate(270deg) rotateY(180deg)',
    6: 'rotate(90deg)',
    7: 'rotate(90deg) rotateY(180deg)',
    8: 'rotate(270deg)'
}

/*
 * http://stackoverflow.com/a/32490603
 */
function getOrientation( file ) {
    return new Promise( ( resolve, reject ) => {
        const reader = new FileReader();

        reader.onerror = reject
        
        reader.onload = ( { target } ) => {
            try {
                const view = new DataView( target.result ),
                      length = view.byteLength
                let offset = 2

                if( view.getUint16(0, false) != 0xFFD8 ) {
                    return reject( new Error( 'File is not a .jpeg' ) )
                }

                while( offset < length ) {
                    const marker = view.getUint16( offset, false )
                    offset += 2;

                    if (marker == 0xFFE1) {
                        if( view.getUint32( offset += 2, false ) != 0x45786966 ) {
                            return resolve()
                        }

                        const little = view.getUint16(offset += 6, false) == 0x4949
                        offset += view.getUint32(offset + 4, little)

                        const tags = view.getUint16(offset, little)
                        offset += 2

                        for( var i = 0; i < tags; i++ ) {
                            if( view.getUint16( offset + ( i * 12 ), little ) == 0x0112 ) {
                                return resolve( view.getUint16( offset + ( i * 12 ) + 8, little ) )
                            }
                        }

                    } else if( ( marker & 0xFF00 ) != 0xFF00 ) {
                        break;
                    } else {
                        offset += view.getUint16( offset, false )
                    }
                }

                return resolve()
            } catch( err ) {
                return reject( err )
            }
        };
        
        reader.readAsArrayBuffer( file.slice( 0, 64 * 1024 ) );
    } )
}

//Single Upload
function readURL(input, url) {
  if (input.files && input.files[0]) {
      var preview = url;
      var reader = new FileReader();

      getOrientation(input.files[0]).then(function(response) {
        var orientation = ''+ORIENT_TRANSFORMS[response]+'';
        reader.onload   = function (e) {
            $(preview).attr('style', 'background: url(' + e.target.result + ') center top no-repeat;');
        }
        reader.readAsDataURL(input.files[0]);
      }).catch(function() {
        reader.onload   = function (e) {
            $(preview).attr('style', 'background: url(' + e.target.result + ') center top no-repeat;');
        }
        reader.readAsDataURL(input.files[0]);
      });
  }
}


$("#CoverUpload").change(function () {
  readURL(this, '#cover-container');
});

$("#profileupload").change(function () {
  readURL(this, '.profile-img');
});
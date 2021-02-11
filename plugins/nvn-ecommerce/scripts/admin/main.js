jQuery(document).ready(function ($) {

    $("#postbox-container-2").draggable({ disabled: true })
    $("#normal-sortables").draggable({ disabled: true });
    $("#products_detail_fields").draggable({ disabled: true });
    /**
     * 
     * 
     * Media 
     * Uploader
     * 
     * 
     */


    var custom_uploader;
    let previewImages = [];

    /** handle open image uploader */
    const handleOpenImageUploader = () => {
        return new Promise((resolve) => {
            setTimeout(() => {
                //If the uploader object has already been created, reopen the dialog
                if (custom_uploader) {
                    custom_uploader.open();
                    return;
                }
                //Extend the wp.media object
                custom_uploader = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                        text: 'Choose Image'
                    },
                    multiple: 'add'
                });
                custom_uploader.on('select', function () {
                    var selection = custom_uploader.state().get('selection');
                    selection.map(function (attachment) {
                        attachment = attachment.toJSON();
                        if (!previewImages.includes(attachment.url)) {
                            previewImages.push(attachment.url)
                        } else {
                            alert('already selected')
                        }
                    });
                });
                custom_uploader.open();
                resolve('ok')
            }, 10);
        })
    }

    /**show selected image when first loaded post page */
    const ShowSelectedImage = () => {
        const input = $('.nvn-uploader__input-images').val()?.split(',')
        // fix bug empty string in first array
        const newInput = input?.filter(i => i !== "")
        previewImages = newInput
        addImageToPreview(previewImages)
    }

    /**function actually show previe image */
    const addImageToPreview = (imageArr) => {
        const PreviewImagesParentElement = document.querySelector('#nvn-uploader__preview-image__parent')
        const previewImagesHTML = imageArr.map((image => `
            <div class="nvn-uploader__preview-image">
                <div class="nvn-uploader__preview-image__delete">
                    <button 
                        type="button" 
                        id=${image} 
                        class="nvn-uploader__preview-image__delete-button">
                            delete
                        </button>
                </div>
                <img src='${image}' />
            </div>
        `))

        // if we have img in Arr
        if (imageArr.length == 0)
            PreviewImagesParentElement.innerHTML = `
            <div class="nvn-uploader__preview-image__no-image">
                it's quiet here, let's add some images
            </div>
            `
        else
            PreviewImagesParentElement.innerHTML = previewImagesHTML.join(' ')

        // we only can run this func after previewImagesHTML rendered in DOM
        deleteImagesFromArr()
    }


    /** function change input value */
    const changeInputValue = (newInputVal) => {
        const input = $('.nvn-uploader__input-images')
        newInputVal = previewImages.join(',')

        input.val(newInputVal)
    }

    /** function => delete image from arr*/
    const deleteImagesFromArr = () => {
        const buttons = document.querySelectorAll('.nvn-uploader__preview-image__delete-button')
        buttons.forEach(button => {
            button.addEventListener('click', () => {

                // delete mathes imgArr
                const newPreviewImages = previewImages.filter(img => img !== button.id)
                previewImages = newPreviewImages

                // then preview new imgArr
                // and change input with new val of imgArr
                addImageToPreview(previewImages)
                changeInputValue(previewImages)
            })
        });
    }


    $('#upload_image_button').on('click', () => handleOpenImageUploader()
        .then(() => {
            const button = $('.media-button-select')

            button.on('click', () => {
                addImageToPreview(previewImages)
                changeInputValue()
            })

        }))


    /** run function => show selected image when first loaded post page */
    ShowSelectedImage()

    /**
     * 
     * end
     * media
     * uploader
     * 
     * 
     */


    /**
     * input 
     * price
     */

    const inputPrice = document.querySelector('.nvn-metabox__product-price__input')
    const inputPriceValue = document.querySelector('.nvn-metabox__product-price__input-value')

    function convertToRupiah(angka) {
        var rupiah = '';
        var angkarev = angka.toString().split('').reverse().join('');
        for (var i = 0; i < angkarev.length; i++) if (i % 3 == 0) rupiah += angkarev.substr(i, 3) + '.';

        return 'Rp. ' + rupiah.split('', rupiah.length - 1).reverse().join('');
    }


    inputPrice.value = convertToRupiah(inputPriceValue.value)


    inputPrice.addEventListener('input', () => {

        // if contain number 
        if (/\d/.test(inputPrice.value)) {
            inputPrice.value = convertToRupiah(parseInt(inputPrice.value.replace(/,.*|[^0-9]/g, ''), 10))
            inputPriceValue.value = parseInt(inputPrice.value.replace(/,.*|[^0-9]/g, ''), 10)
            console.log(inputPriceValue.value)
        }
        else
            inputPrice.value = null
    })

    /**
     * end
     * input 
     * price
     */



});
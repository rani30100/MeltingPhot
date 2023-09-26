import { Controller } from '@hotwired/stimulus';
import tinymce from 'tinymce';

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="tinymce" attribute will cause
 * this controller to be executed. The name "tinymce" comes from the filename:
 * tinymce_controller.js -> "tinymce"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        tinymce.init({
            selector: "#" + this.element.id,
            height: 400,
            // plugins: [
            //     "advlist autolink lists link image imagetools charmap print preview hr anchor pagebreak",
            //     "searchreplace wordcount visualblocks visualchars code fullscreen",
            //     "insertdatetime media nonbreaking save table contextmenu directionality",
            //     "emoticons template paste textpattern"
            // ],
            toolbar1: "undo redo | fullscreen | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link media image",
            toolbar2: "",
            paste_data_images: true,
            image_caption: false,
            image_title: true,
            automatic_uploads: true,
            imagetools_cors_hosts: ['localhost'],
            file_picker_types: 'image',
            imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
            setup: function (editor) {
                // This ensures the actual field TinyMCE is supplanting gets updated with content.
                editor.on('change', function () {
                    editor.save();
                });
            },
            image_advtab: true,
            // file_picker_callback: function (callback, value, meta) {
            //     // This adds an extra button to the image menu and enables image uploads into the field as base64
            //     if (meta.filetype == 'image') {
            //         var upload = $('#upload');
            //         upload.trigger('click');
            //         upload.on('change', function () {
            //             var file      = this.files[0];
            //             var reader    = new FileReader();
            //             reader.onload = function (e) {
            //                 callback(e.target.result, {
            //                     alt: ''
            //                 });
            //             };
            //             reader.readAsDataURL(file);
            //         });
            //     }
            // }
        });
    }
}

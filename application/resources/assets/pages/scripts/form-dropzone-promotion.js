var FormDropzone = function () {


    return {
        //main function to initiate the module
        init: function () {
        // console.log($('#my-dropzone').parents("form").attr('action'))

            Dropzone.options.myDropzone = {
                url: $('#my-dropzone').parents("form").attr('action'),
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,
                acceptedFiles: "image/*",
                dictDefaultMessage: "",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    var submitButton = document.querySelector("#submit");
                    var wrapperThis = this;

                    submitButton.addEventListener("click", function () {
                        wrapperThis.processQueue();
                    });

                    this.on("addedfile", function(file) {
                        // Create the remove button
                        var removeButton = Dropzone.createElement("<a href='javascript:;'' class='btn red btn-sm btn-block'>Remove</a>");
                        // Capture the Dropzone instance as closure.
                        var _this = this;

                        // Listen to the click event
                        removeButton.addEventListener("click", function(e) {
                          // Make sure the button click doesn't submit the form:
                          e.preventDefault();
                          e.stopPropagation();

                          // Remove the file preview.
                          _this.removeFile(file);
                          // If you want to the delete the file on the server as well,
                          // you can do the AJAX request here.
                        });

                        // Add the button to the file preview element.
                        file.previewElement.appendChild(removeButton);
                    });

                    this.on("successmultiple", function(files, response) {
                        App.unblockUI();
                        window.location.href = response.redirect_url;
                    });

                    this.on('sendingmultiple', function (data, xhr, formData) {
                        formData.append("promotion_name", $("#promotion_name").val());
                        formData.append("promotion_name_eng", $("#promotion_name_eng").val());
                        formData.append("promotion_description", $("#promotion_description").val());
                        formData.append("promotion_description_eng", $("#promotion_description_eng").val());
                    });
                }
            }
        }
    };
}();

jQuery(document).ready(function() {    
   FormDropzone.init();
});
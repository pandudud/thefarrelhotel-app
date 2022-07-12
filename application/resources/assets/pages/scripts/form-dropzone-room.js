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
                        // window.location.href = response.redirect_url;
                        console.log(response);
                    });

                    this.on('sendingmultiple', function (data, xhr, formData) {
                        formData.append("room_name", $("#room_name").val());
                        formData.append("room_name_eng", $("#room_name_eng").val());
                        formData.append("room_price", $("#room_price").val());
                        formData.append("room_description", $("#room_description").val());
                        formData.append("room_description_eng", $("#room_description_eng").val());
                        formData.append("room_facility_id[]", $("#room_facility_id").select2("val"));
                    });

                    this.on("error", function(files, response) {
                        App.unblockUI();
                        // window.location.href = response.redirect_url;
                        console.log(response);
                    });
                }
            }
        }
    };
}();

jQuery(document).ready(function() {    
   FormDropzone.init();
});
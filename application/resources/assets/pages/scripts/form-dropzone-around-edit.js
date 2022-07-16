var FormDropzone = function () {
    return {
        init: function () {
            Dropzone.options.myDropzone = {
                url: $('#my-dropzone').parents("form").attr('action'),
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 1,
                acceptedFiles: "image/*",
                dictDefaultMessage: "",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                init: function() {
                    var submitButton = document.querySelector("#submit");
                    var wrapperThis = this;

                    submitButton.addEventListener("click", function (e) {
                        e.preventDefault();
                        swal({
                            title: "Apakah anda yakin?",
                            text: $(this).data("swa-text"),
                            type: "warning",
                            showCancelButton: true
                        }).then(function() {
                            App.blockUI();
                            wrapperThis.processQueue();
                        }).catch(swal.noop);
                    });

                    this.on("addedfile", function(file) {
                        if(this.files.length > 1) {
                            this.removeFile(this.files[0]);
                        }

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
                        console.log(response);
                        // window.location.href = response.redirect_url;
                    });

                    this.on('sendingmultiple', function (data, xhr, formData) {
                        // console.log($("#around_name").val())
                        formData.append("_method", "patch");
                        formData.append("around_name", $("#around_name").val());
                        formData.append("around_name_eng", $("#around_name_eng").val());
                        formData.append("around_description", $("#around_description").val());
                        formData.append("around_description_eng", $("#around_description_eng").val());
                        formData.append("link_map", $("#link_map").val());
                    });

                    // console.log(this);
                    let mockFile = { name: "Sekeliling.jpg", size: 1 };
                    this.emit("addedfile", mockFile);
                    this.emit("thumbnail", mockFile, $("#fileExisting").val());
                    this.emit("complete", mockFile);
                }
            }
        }
    };
}();

jQuery(document).ready(function() {
   FormDropzone.init();
});
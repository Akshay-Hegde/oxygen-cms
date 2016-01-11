


jQuery(function($)
{


        // notify the developer
        console.log('loading DropZone');

        //create the ui on the browser after confirmation
        function image_added(file_id,row_id,is_cover)  {

            /*
            var preview_url = SITE_URL + 'files/thumb/'+file_id;
            var str = '';

            var cuurentImagesHtml = $("#ProductGalleryImages").html();

            $("#ProductGalleryImages").html( cuurentImagesHtml + str );

            if(is_cover==true)  {
                $("#cover_container").html(image_tag);
            }
            */
        }


        // Now that the DOM is fully loaded, create the dropzone, and setup the
        var myDropzone = new Dropzone("div#mydrop", { url: SITE_URL + 'admin/files/upload/ajax'});


        // Dropzone.autoDiscover = true;
        Dropzone.options.mydrop = {
            // Make sure only images are accepted
            acceptedFiles: "image/*",
            autoProcessQueue: true,
        };



        $(document).on('click', '.addSingleImage', function(event) {  //this works much better
              $('#mydrop').trigger('click');
              event.preventDefault();
        });


        /**
        *
        * @param  {[type]} e [description]
        * @return {[type]}   [description]
        */
        $(document).on('click', 'a.delImage', function(event) {  //this works much better


              var row_id = $(this).attr('row-id');
              var imgBlock = $('#img-key-' + row_id );

              //Warn about delete
              if(confirm("Are you sure you want to remove this image ? "))
              {
                  var url = SITE_URL + "admin/store_gallery/images/remove/" + $(this).attr("row-id") + "/" + $(this).attr("image-id");

                  $.post(url).done(function(data)
                  {

                      var obj = jQuery.parseJSON(data);

                      if(obj.status == 'success')
                      {
                          imgBlock.fadeTo("slow", 0.1);
                          setTimeout(function() {
                              imgBlock.delay(4000).remove();
                              if(obj.cover_removed ==true)
                              {
                                $("#cover_container").html("<div>[No Image]</div>");
                              }
                          }, 3000);
                      }
                      else
                      {
                          alert(obj.message);
                      }

                  });

              }

              // Prevent Navigation
              event.preventDefault();
        });

        $(document).on('click', 'a.setCover', function(e) {  //this works much better


              var url = SITE_URL + "admin/store_gallery/images/set_as_cover/" + $(this).attr("product-id") + "/" + $(this).attr("row-id");

              var success_image_path = SITE_URL + "files/thumb/" + $(this).attr("image-id") + "/100/100";

              $.post(url).done(function(data)
              {

                  var obj = jQuery.parseJSON(data);

                  if(obj.status == 'success') {

                      var image_tag = ' <img id="prod_cover" src="'+success_image_path+'" alt="" width="100px" /> ';
                      $("#cover_container").html(image_tag);
                  }
                  else  {
                      alert(obj.message);
                  }

              });

              // Prevent Navigation
              e.preventDefault();
        });
        



        myDropzone.on("addedfile", function(file) {
          file.previewElement.addEventListener("click", function() { myDropzone.removeFile(file); });
        });

        myDropzone.on("sending", function(file, xhr, formData) {
            formData.append("filesize", file.size); // Will send the filesize along with the file as POST data.
            // Will send the filesize along with the file as POST data.

            var folder = $('select[name=filter_folder]').val();
            var token_name = _token_name;
            var token_value = _token_value;

            formData.append(token_name, token_value);
            formData.append('module', 'files');
            formData.append('folder', folder);

        });


        //feedback
        Dropzone.options.myDropzone = {

            init: function()
            {
                this.on("addedfile", function(file) {
                 //do stuff
                });
                this.on("uploadprogress", function(file) {
                 //do stuff
                });
            }

        };


        myDropzone.on("success", function(file, responseText) {
                  // Handle the responseText here. For example, add the text to the preview element:
                  file.previewTemplate.appendChild(document.createTextNode("Complete"));

                  var obj = jQuery.parseJSON(responseText);

                  image_added(obj.file_id,obj.row_id,obj.is_cover);

        });


        myDropzone.on("complete", function(file) {
              setTimeout(function() {
                  myDropzone.removeFile(file);
              }, 2000);
        });


});

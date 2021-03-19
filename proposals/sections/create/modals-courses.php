
<!-- Add new chapter Modal -->
<div class="modal fade" id="add_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_sectionLabel">Add new chapter</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
  <div class="form-group">
    <label for="exampleInputEmail1">Chapter Title</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">Provide a chapter name</small>
  </div>
  
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>


<!-- Add new lesson Modal 1 -->
<div class="modal fade" id="add_lesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_lessonLabel">Add Lesson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
  <div class="form-group">
    <label for="exampleInputEmail1">Select Chapter</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>Chapter 1: Demo Chapter</option>
      <option>Chapter 2: Demo Chapter</option>
     
    </select>
  </div>

  <div class="form-group">
    <label for="exampleInputEmail1">Select Lesson Type</label>
    <select class="form-control">
                                                <option value="default" selected disabled>Select Lesson Type</option>
                                                <option value="Youtube">Youtube</option>
                                                <option value="Vimeo">Vimeo</option>
                                                <option value="Video-file">Video file</option>
                                                <option value="Video-url">Video url [ .mp4 ]</option>
                                                <option value="Document">Document</option>
                                                <option value="Image-file">Image file</option>

                                                </select>
  </div>

  
  
  
  
  
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#add_lesson2">Next</button>
        
      </div>
    </div>
  </div>
</div>

<!-- Add new lesson Modal 2 -->
<div class="modal fade" id="add_lesson2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_lessonLabel">Add Lesson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
      <div class="alert alert-success" role="alert">
      Chapter: <strong>Chapter 1 Demo</strong>

            </div>

            <div class="Youtube lesson-box">
            <div class="form-group">
                                            <label class="">Lesson Title</label>
                                            <div class="">

                                                <input type="text" class="form-control" id="inputtext" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Youtube url</label>
                                            <div class="">

                                                <input type="url" class="form-control" id="inputurl" placeholder="https://youtube.com/video" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Duration</label>
                                            <div class="">

                                                <input type="number" class="form-control" id="lessonduration" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Summary</label>
                                            <div class="">

                                                <textarea type="text" class="form-control" id="lessonsummary" rows="3" placeholder="" data-name=""></textarea>

                                                

                                            </div>
                                        </div>




            
            </div>
    <div class="Vimeo lesson-box">
      
    <div class="form-group">
                                            <label class="">Lesson Title</label>
                                            <div class="">

                                                <input type="text" class="form-control" id="inputtext" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Vimeo url</label>
                                            <div class="">

                                                <input type="url" class="form-control" id="inputurl" placeholder="https://vimeo.com/33031367" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Duration</label>
                                            <div class="">

                                                <input type="number" class="form-control" id="lessonduration" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Summary</label>
                                            <div class="">

                                                <textarea type="text" class="form-control" id="lessonsummary" rows="3" placeholder="" data-name=""></textarea>

                                                

                                            </div>
                                        </div>


    </div>
    <div class="Video-file lesson-box">
      
    <div class="form-group">
                                            <label class="">Lesson Title</label>
                                            <div class="">

                                                <input type="text" class="form-control" id="inputtext" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div id="video-type"></div>
  
  
  </div>
    <div class="Video-url lesson-box">
      
    <div class="form-group">
                                            <label class="">Lesson Title</label>
                                            <div class="">

                                                <input type="text" class="form-control" id="inputtext" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="">Video URL</label>
                                            <div class="">

                                                <input type="url" class="form-control" id="inputtext" placeholder="https://websiteaddress/video.mp4" data-name="">

                                                

                                            </div>
                                        </div>

    </div>
    <div class="Document lesson-box">

    <div class="form-group">
                                            <label class="">Lesson Title</label>
                                            <div class="">

                                            <input type="text" class="form-control" id="inputtext" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>
    
    <div id="document-type"></div>
    
    
    </div>
    <div class="Image-file lesson-box">
    
    <div class="form-group">
                                            <label class="">Lesson Title</label>
                                            <div class="">

                                            <input type="text" class="form-control" id="inputtext" placeholder="" data-name="">

                                                

                                            </div>
                                        </div>

                                        <div id="image-type"></div>
    
    </div>

                                     

                                      
                                     
                                     
  
  
  
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#add_lesson" data-dismiss="modal">Previous</button>
        <button type="button" class="btn btn-success" data-dismiss="modal">Finish</button>
        
      </div>
    </div>
  </div>
</div>

<script src="../js/uppy.js"></script>
<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".lesson-box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".lesson-box").hide();
            }
        });
    }).change();
});


// Upload Video File Zone
var uppy = Uppy.Core()
        .use(Uppy.Dashboard, {
          inline: true,
          target: '#video-type',
        })
        .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

      uppy.on('complete', (result) => {
        console.log('Upload complete! We’ve uploaded these files:', result.successful)
      })

      // Upload Document Zone
var uppy = Uppy.Core()
        .use(Uppy.Dashboard, {
          inline: true,
          target: '#document-type',
        })
        .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

      uppy.on('complete', (result) => {
        console.log('Upload complete! We’ve uploaded these files:', result.successful)
      })

      // Upload Image Zone
var uppy = Uppy.Core()
        .use(Uppy.Dashboard, {
          inline: true,
          target: '#image-type',
        })
        .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

      uppy.on('complete', (result) => {
        console.log('Upload complete! We’ve uploaded these files:', result.successful)
      })

      
</script>


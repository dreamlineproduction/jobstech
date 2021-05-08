<script type="text/javascript">
    function browse_video(str='add'){
        var settingsVideo = {
                url: "<?php echo $site_url?>/proposals/action_course",
                dragDrop:false,
                multiple: false,
                fileName: "video_file_lesson",
                allowedTypes:"mp4",
                showProgress: true,
                returnType:"json",
                showAbort: false,
                statusBarWidth: "400",
                showDone: false,
                uploadStr: "Select a Video",
                onSuccess:function(files,data,xhr)
                {   
                    if (data.status == 1){
                        if (str == 'add') {
                            $("#lesson_video_preview").html(data['html']);
                            $("#video_info").html(data['video_info']);                
                        } else {
                            $("#lesson_video_edit_preview").html(data['html']);
                            $("#video_info_edit").html(data['video_info']);

                            var player = jwplayer('lesson_video_edit_preview');
                            player.setup({
                                file: data["url"]
                            });                
                        }                   
                    }            
                },
                afterUploadAll:function(){
                    $(".Video-file .ajax-file-upload-statusbar").remove();
                    $(".Video-file #lesson_video_error").html('').hide();

                    $("#edit_lesson").find(".ajax-file-upload-statusbar").remove();
                    $("#edit_lesson").find("#lesson_video_error").html('').hide();
                },
                onSubmit:function(){
                },
                deleteCallback: function(data,pd)
                {}
            }

        if(str == "add")
            var uploadObj = $("#lesson_video").uploadFile(settingsVideo);           
        else 
            var uploadObj = $("#lesson_video_edit").uploadFile(settingsVideo);           
    }



    $(document).ready(function(){
        
            browse_video(str='add');

            var documentUpload = {
                url: "<?php echo $site_url?>/proposals/action_course",
                dragDrop:false,
                multiple: false,
                fileName: "document_file_lesson",
                allowedTypes:"pdf,doc,docx",
                showProgress: true,
                returnType:"json",
                showAbort: false,
                statusBarWidth: "400",
                showDone: false,
                uploadStr: "Select a File",
                onSuccess:function(files,data,xhr)
                {
                    if (data.status == 1){
                        $("#lesson_document_preview").html(data['html']);                
                        $("#document_info").html(data['document_info']);
                    }            
                },
                afterUploadAll:function(){
                    $(".Document .ajax-file-upload-statusbar").remove();
                    $(".Document #lesson_document_error").html('').hide();
                },
                onSubmit:function(){
                },
                deleteCallback: function(data,pd)
                {}
            }
            var uploadObj = $("#lesson_document").uploadFile(documentUpload);       


            var imageUpload = {
                url: "<?php echo $site_url?>/proposals/action_course",
                dragDrop:false,
                multiple: false,
                fileName: "lesson_image",
                allowedTypes:"jpeg,jpg,png",
                showProgress: true,
                returnType:"json",
                showAbort: false,
                statusBarWidth: "400",
                showDone: false,
                uploadStr: "Select a Image",
                onSuccess:function(files,data,xhr)
                {
                    if (data.status == 1){
                        $("#lesson_image_preview").html(data['html']);                
                        $("#image_info").html(data['image_info']);
                    }            
                },
                afterUploadAll:function(){
                    $(".Image-file .ajax-file-upload-statusbar").remove();
                    $(".Image-file #lesson_image_error").html('').hide();
                },
                onSubmit:function(){
                },
                deleteCallback: function(data,pd)
                {}
            }
            var uploadObj = $("#lesson_image").uploadFile(imageUpload);   
    });
    
</script>
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
                <form action="" method="post" id="add_chapter" name="add_chapter_frm">
                    <input type="hidden" name="action" value="add_chapter">
                    <div class="form-group">
                        <label for="name">Chapter Title</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                        <small id="name-error" class="form-text text-muted">Provide a chapter name</small>
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

<!-- Edit Chapter Model -->

<div class="modal fade" id="edit_chapter_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_sectionLabel">Edit chapter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="edit_chapter_frm" name="edit_chapter_frm">
                    <input type="text" name="action" value="edit_chapter">
                    <div class="form-group">
                        <label for="name">Chapter Title</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                        <small id="name-error" class="form-text text-muted">Provide a chapter name</small>
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




<script type="text/javascript">    
    $("body").on("submit","#edit_chapter_frm",function(event) {
        event.preventDefault();        
        $('input[type="submit"]').prop('disabled',true);
        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data:$(this).serializeArray(),
            success:function(data){
                $('input[type="submit"]').prop('disabled',false);
                $("#add_chapter #name").val("");

                if (data["status"] == 0) {
                    $("#name-error").html(data["name"]);
                } else {
                    $("#course-wrapper").html(data["html"]);
                    $("#edit_chapter_section").modal("hide");
                }
            }
        });
    });

    $("#add_chapter").submit(function(event){
        event.preventDefault();
        $('input[type="submit"]').prop('disabled',true);
        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data:$(this).serializeArray(),
            success:function(data){
                $('input[type="submit"]').prop('disabled',false);
                $("#add_chapter #name").val("");

                if (data["status"] == 0) {
                    $("#name-error").html(data["name"]);
                } else {
                    $("#course-wrapper").html(data["html"]);
                    $("#add_section").modal("hide");
                }
            }
        });
    });

    function edit_chapter(id) {
        $("#edit_chapter_section .modal-body").html("");
        $("#edit_chapter_section").modal("show");

        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data:{action:"get_single_chapter",id:id},
            success:function(data){
                $("#edit_chapter_section .modal-body").html(data["html"]);
            }
        });
    }


    function delete_chapter(id) {
        if (confirm("Are you sure you want to delete?")){
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data:{action:"delete_chapter",id:id},
                success:function(data){
                    $("#course-wrapper").html(data["html"]);
                }
            });
        }
    }

    function delete_lesson(chapter_id,lesson_id) {
        if (confirm("Are you sure you want to delete?")){
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data:{action:"delete_lesson",lesson_id:lesson_id,chapter_id:chapter_id},
                success:function(data){
                    $('#lesson-wrapper-'+chapter_id).html(data["html"]);
                }
            });
        }
    }

    function show_lesson_modal() {
        $("#add_lesson").modal("show");
        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data:{action:"show_add_lesson_popup"},
            success:function(data){
                $("#add_lesson .modal-body").html(data["html"]);
            }
        });
    }


    

</script>


<div class="modal fade" id="edit_lesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_lessonLabel">Edit Lesson</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div id="lesson-box"></div>

            <!-- <div class="modal-body">

            </div> -->
            
        </div>
    </div>
</div>

<script type="text/javascript">
    function show_edit_lesson_popup(c_id,l_id,name) {
        $("#edit_lesson .modal-body").html("");
        $("#edit_lesson").modal("show");

        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data:{action:"get_single_lesson",c_id:c_id,l_id:l_id,name:name},
            success:function(data) {
                $("#edit_lesson #lesson-box").html(data["html"]);

                if (data['video_code']) {
                    browse_video(str='edit');
                    $("#edit_lesson #lesson-box").append(data['video_code']);
                }
            }
        });
    }
</script>

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
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="lesson_next_step();">Next</button> 
                <!-- data-dismiss="modal" data-toggle="modal" data-target="#add_lesson2" -->
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function lesson_next_step() {
        var error = false;
        if ($("#add_lesson #chapter").val() == "" || $("#add_lesson #chapter").val() == null) {
            $(".chapter_error").html("Please select a Chapter");            
            error = true;
        } else {
           $(".chapter_error").html("");             
        }

        if ($("#add_lesson #lesson_type").val() == "" || $("#add_lesson #lesson_type").val() == null) {
            $(".type_error").html("Please select lesson type");
            error = true;
        } else {
           $(".chapter_error").html("");             
        }

        if(error == false) {
            $(".type_error").html("");
            $("#add_lesson").modal("hide");
            $("#add_lesson2").modal("show");

            var chapter = $("#add_lesson #chapter").val();

            var res = chapter.split('|');

            $("#add_lesson2 #chapter").html(res[1]);
            $("#add_lesson2 #chapter_id").val(res[0]);
        }
    }
</script>

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
            <form id="add_lesson_frm" name="add_lesson_frm" action="" method="post">
                <div class="modal-body">
                    <input type="hidden" name="chapter_id" id="chapter_id" value="">
                    <div class="alert alert-success" id="chapter">
                        <!-- Chapter: <strong>Chapter 1 Demo</strong> -->
                    </div>
                    <div class="Youtube lesson-box">
                        <div class="form-group">
                            <label class="">Lesson Title</label>                            
                            <input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title">
                            <p class="error lesson_title_error"></p>                            
                        </div>
                        <div class="form-group">
                            <label class="">Youtube url</label>                            
                            <input type="url" class="form-control" id="youtube_url" name="youtube_url" placeholder="Youtube URL">                            
                            <p class="error youtube_url_error"></p>                            
                        </div>
                        <div class="form-group">
                            <label class="">Duration</label>
                            <input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration">
                            <p class="error lessonduration_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Summary</label>
                            <textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary"></textarea>
                            <p class="error lessonsummary_error"></p>
                        </div>
                    </div>
                    <div class="Vimeo lesson-box">
                        <div class="form-group">
                            <label class="">Lesson Title</label>
                            <input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title">
                            <p class="error lesson_title_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Vimeo url</label>
                            <input type="url" class="form-control" id="vimeo_url" name="vimeo_url" placeholder="Vimeo url">
                            <p class="error vimeo_url_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Duration</label>                                
                            <input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration">
                            <p class="error lessonduration_error"></p>                            
                        </div>
                        <div class="form-group">
                            <label class="">Summary</label>
                            <textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary"></textarea>
                            <p class="error lessonsummary_error"></p>    
                        </div>
                    </div>
                    <div class="Video-file lesson-box">
                        <div class="form-group">
                            <label class="">Lesson Title</label>
                            <input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title">
                            <p class="error lesson_title_error"></p>
                        </div>
                        <!-- <div id="video-type"></div> -->

                        <script type="text/javascript" src="https://cdn.jwplayer.com/libraries/hfiS1ZF7.js"></script>
                        <div id="lesson_video">Video</div>
                        <div id="lesson_video_preview"></div>    
                        <div id="video_info"></div>    

                        <div class="error" id="lesson_video_error"></div>

                        <div class="form-group">
                            <label class="">Duration</label>
                            <input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration">
                            <p class="error lessonduration_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Summary</label>
                            <textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary"></textarea>
                            <p class="error lessonsummary_error"></p>
                        </div>
                    </div>

                    <div class="Video-url lesson-box">
                        <div class="form-group">
                            <label class="">Lesson Title</label>                            
                            <input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title">
                            <p class="error lesson_title_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Video URL</label>                            
                            <input type="url" class="form-control" id="video_url" name="video_url" placeholder="Video URL">
                            <p class="error video_url_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Duration</label>
                            <input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration">
                            <p class="error lessonduration_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Summary</label>
                            <textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary"></textarea>
                            <p class="error lessonsummary_error"></p>
                        </div>
                    </div>
                    <div class="Document lesson-box">
                        <div class="form-group">
                            <label class="">Lesson Title</label>                            
                            <input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title">
                            <p class="error lesson_title_error"></p>
                        </div>
                        <div id="lesson_document">Video</div>
                        <div id="lesson_document_preview"></div> 
                        <div id="document_info"></div>                           
                        <div class="error" id="lesson_document_error"></div>

                        <div class="form-group">
                            <label class="">Duration</label>
                            <input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration">
                            <p class="error lessonduration_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Summary</label>
                            <textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary"></textarea>
                            <p class="error lessonsummary_error"></p>
                        </div>
                    </div>                    
                    <div class="Image-file lesson-box">
                        <div class="form-group">
                            <label class="">Lesson Title</label>                            
                            <input type="text" class="form-control" id="lesson_title" name="lesson_title" placeholder="Title">
                            <p class="error lesson_title_error"></p>
                        </div>
                        <div id="lesson_image">Image</div>
                        <div id="lesson_image_preview"></div> 
                        <div id="image_info"></div>                           
                        <div class="error" id="lesson_image_error"></div>

                        <div class="form-group">
                            <label class="">Duration</label>
                            <input type="number" class="form-control" id="lessonduration" name="lessonduration" placeholder="Duration">
                            <p class="error lessonduration_error"></p>
                        </div>
                        <div class="form-group">
                            <label class="">Summary</label>
                            <textarea type="text" class="form-control" id="lessonsummary" name="lessonsummary" rows="3" placeholder="Summary"></textarea>
                            <p class="error lessonsummary_error"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" value="add_lesson">
                    <button type="button" class="btn btn-success" data-dismiss="modal" data-toggle="modal" data-target="#add_lesson" data-dismiss="modal">Previous</button>
                    <button type="submit" class="btn btn-success">Finish</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../js/uppy.js"></script>
<script>
$(document).ready(function(){

    $('body').on('change','#lesson_type',function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".lesson-box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".lesson-box").hide();
            }
        });
    });

    // /


    $('body').on('submit','#edit_vimeo_lesson_frm',function(){
        event.preventDefault();
        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data: $(this).serializeArray(),
            success:function(data){
                if (data["status"] == 0) {
                    if (data['lesson_title']) {
                        $("#edit_vimeo_lesson_frm .lesson_title_error").html(data["lesson_title"]);
                    } else {
                        $("#edit_vimeo_lesson_frm .lesson_title_error").html('');
                    }

                    if (data['lessonsummary']) {
                        $("#edit_vimeo_lesson_frm .lessonsummary_error").html(data["lessonsummary"]);
                    } else {
                        $("#edit_vimeo_lesson_frm .lessonsummary_error").html('');
                    }

                    if (data['lessonduration']) {
                        $("#edit_vimeo_lesson_frm .lessonduration_error").html(data["lessonduration"]);
                    } else {
                        $("#edit_vimeo_lesson_frm .lessonduration_error").html('');
                    }

                    if (data['vimeo_url']) {
                        $("#edit_vimeo_lesson_frm .vimeo_url_error").html(data["vimeo_url"]);
                    } else {
                        $("#edit_vimeo_lesson_frm .vimeo_url_error").html('');
                    }

                } else {
                    $('#lesson-wrapper-'+data['id']).html(data["html"]);
                    $("#edit_lesson").modal("hide");
                }
            }
        });  
    });


    $('body').on('submit','#edit_youtube_lesson_frm',function(){
        event.preventDefault();
        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data: $(this).serializeArray(),
            success:function(data){
                if (data["status"] == 0) {
                    if (data['lesson_title']) {
                        $("#edit_youtube_lesson_frm .lesson_title_error").html(data["lesson_title"]);
                    } else {
                        $("#edit_youtube_lesson_frm .lesson_title_error").html('');
                    }

                    if (data['lessonsummary']) {
                        $("#edit_youtube_lesson_frm .lessonsummary_error").html(data["lessonsummary"]);
                    } else {
                        $("#edit_youtube_lesson_frm .lessonsummary_error").html('');
                    }

                    if (data['lessonduration']) {
                        $("#edit_youtube_lesson_frm .lessonduration_error").html(data["lessonduration"]);
                    } else {
                        $("#edit_youtube_lesson_frm .lessonduration_error").html('');
                    }

                    if (data['youtube_url']) {
                        $("#edit_youtube_lesson_frm .youtube_url_error").html(data["youtube_url"]);
                    } else {
                        $("#edit_youtube_lesson_frm .youtube_url_error").html('');
                    }

                    if (data['lesson_title']) {
                        $("#edit_youtube_lesson_frm .lesson_title_error").html(data["lesson_title"]);
                    } else {
                        $("#edit_youtube_lesson_frm .lesson_title_error").html('');
                    }
                } else {
                    $('#lesson-wrapper-'+data['id']).html(data["html"]);
                    $("#edit_lesson").modal("hide");
                }
            }
        });  
    });

     $('body').on('submit','#edit_video_lesson_frm',function(){
        event.preventDefault();
        $.ajax({
            url:"<?php echo $site_url?>/proposals/action_course",
            method:"POST",
            dataType: 'json',
            data: $(this).serializeArray(),
            success:function(data){
                if (data["status"] == 0) {
                    if (data['lesson_title']) {
                        $("#edit_video_lesson_frm .lesson_title_error").html(data["lesson_title"]);
                    } else {
                        $("#edit_video_lesson_frm .lesson_title_error").html('');
                    }

                    // if (data['lessonsummary']) {
                    //     $("#edit_video_lesson_frm #lesson_video_error").html(data["lessonsummary"]);
                    // } else {
                    //     $("#edit_video_lesson_frm #lesson_video_error").html('');
                    // }

                    
                } else {
                    $('#lesson-wrapper-'+data['id']).html(data["html"]);
                    $("#edit_lesson").modal("hide");
                }
            }
        });  
    });

    //
    // $("#edit_youtube_lesson_frm").submit(function(event){
        
    // });

    $("#add_lesson_frm").submit(function(event){
        event.preventDefault();
        if ($("#lesson_type").val() == "Youtube") {
            var id = $("#add_lesson_frm #chapter_id").val();
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: {
                    chapter_id: id,
                    action: 'add_lesson',
                    lesson_title: $('#add_lesson_frm .Youtube #lesson_title').val(),
                    lesson_type: 'youtube',
                    youtube_url: $('#add_lesson_frm .Youtube #youtube_url').val(),
                    lessonduration: $('#add_lesson_frm .Youtube #lessonduration').val(),
                    lessonsummary: $('#add_lesson_frm .Youtube #lessonsummary').val(),
                },
                success:function(data){
                    if (data["status"] == 0) {

                        if (data['lesson_title']) {
                            $("#add_lesson_frm .Youtube .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $("#add_lesson_frm .Youtube .lesson_title_error").html('');
                        }

                        if (data['lessonsummary']) {
                            $("#add_lesson_frm .Youtube .lessonsummary_error").html(data["lessonsummary"]);                            
                        } else {
                            $("#add_lesson_frm .Youtube .lessonsummary_error").html('');
                        }

                        if (data['lessonduration']) {
                            $("#add_lesson_frm  .Youtube .lessonduration_error").html(data["lessonduration"]);
                        } else {
                            $("#add_lesson_frm  .Youtube .lessonduration_error").html('');
                        }

                        if (data['youtube_url']) {
                            $("#add_lesson_frm .Youtube .youtube_url_error").html(data["youtube_url"]);
                        } else {
                            $("#add_lesson_frm .Youtube .youtube_url_error").html('');
                        }

                        if (data['lesson_title']) {
                            $("#add_lesson_frm .Youtube .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $("#add_lesson_frm .Youtube .lesson_title_error").html('');
                        }
                    } else {
                        var id = $("#add_lesson_frm #chapter_id").val();
                        $('#lesson-wrapper-'+id).html(data["html"]);

                        $("#add_lesson2").modal("hide");
                        $("#add_lesson_frm").find("input[type=url], input[type=number], input[type=text], textarea").val("");
                    }
                }
            });            
        } 
       
        if ($("#lesson_type").val() == "Vimeo") {

            var id = $("#add_lesson_frm #chapter_id").val();
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: {
                    chapter_id: id,
                    action: 'add_lesson',
                    lesson_title: $('#add_lesson_frm .Vimeo #lesson_title').val(),
                    lesson_type: 'vimeo',
                    vimeo_url: $('#add_lesson_frm .Vimeo #vimeo_url').val(),
                    lessonduration: $('#add_lesson_frm .Vimeo #lessonduration').val(),
                    lessonsummary: $('#add_lesson_frm .Vimeo #lessonsummary').val(),
                },
                success:function(data){
                    if (data["status"] == 0) {
                        if (data['lesson_title']) {
                            $("#add_lesson_frm .Vimeo .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $("#add_lesson_frm .Vimeo .lesson_title_error").html('');
                        }

                        if (data['lessonsummary']) {
                            $("#add_lesson_frm .Vimeo .lessonsummary_error").html(data["lessonsummary"]);
                        } else {
                            $("#add_lesson_frm .Vimeo .lessonsummary_error").html('');
                        }

                        if (data['lessonduration']) {
                            $("#add_lesson_frm .Vimeo .lessonduration_error").html(data["lessonduration"]);
                        } else {
                            $("#add_lesson_frm .Vimeo .lessonduration_error").html('');
                        }

                        if (data['vimeo_url']) {
                            $("#add_lesson_frm .Vimeo .vimeo_url_error").html(data["vimeo_url"]);
                        } else {
                            $("#add_lesson_frm .Vimeo .vimeo_url_error").html('');
                        }

                        if (data['lesson_title']) {
                            $("#add_lesson_frm .Vimeo .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $("#add_lesson_frm .Vimeo .lesson_title_error").html('');
                        }
                    } else {
                        var id = $("#add_lesson_frm #chapter_id").val();
                        $('#lesson-wrapper-'+id).html(data["html"]);
                        $("#add_lesson2").modal("hide");
                    }
                    //$("#add_lesson .modal-body").html(data["html"]);
                }
            });  
        }

        if ($("#lesson_type").val() == "Video-file") {

            var id = $("#add_lesson_frm #chapter_id").val();
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: {
                    chapter_id: id,
                    action: 'add_lesson',
                    lesson_title: $('.Video-file  #lesson_title').val(),
                    video_id: $('.Video-file  #video_id').val(),
                    lesson_type: 'video_file',
                    lessonduration: 10                    
                },
                success:function(data){
                    if (data["status"] == 0) {
                        if (data['lesson_title']) {
                            $("#add_lesson_frm .Video-file .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $("#add_lesson_frm .Video-file .lesson_title_error").html('');
                        }

                        if (data['video_id']) {
                            $("#add_lesson_frm .Video-file #lesson_video_error").html(data["video_id"]);
                        } else {
                            $("#add_lesson_frm .Video-file #lesson_video_error").html('');
                        }
                        
                    } else {
                        var id = $("#add_lesson_frm #chapter_id").val();
                        $('#lesson-wrapper-'+id).html(data["html"]);
                        $("#add_lesson2").modal("hide");

                        $("#add_lesson_frm").find("input[type=url], input[type=number], input[type=text], textarea").val("");
                    }
                }
            }); 
        }

        if ($("#lesson_type").val() == "Video-url") {
            var id = $("#add_lesson_frm #chapter_id").val();
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: {
                    chapter_id: id,
                    action: 'add_lesson',
                    lesson_title: $('#add_lesson_frm .Video-url #lesson_title').val(),
                    lesson_type: 'video_url',
                    video_url: $('#add_lesson_frm .Video-url #video_url').val(),
                    lessonduration: 10                    
                },
                success:function(data){
                    if (data["status"] == 0) {
                        if (data['lesson_title']) {
                            $("#add_lesson_frm .Video-url .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $("#add_lesson_frm .Video-url .lesson_title_error").html('');
                        }

                        if (data['video_url']) {
                            $("#add_lesson_frm .Video-url .video_url_error").html(data["video_url"]);
                        } else {
                            $("#add_lesson_frm .Video-url .video_url_error").html('');
                        }

                    } else {
                        var id = $("#add_lesson_frm #chapter_id").val();
                        $('#lesson-wrapper-'+id).html(data["html"]);
                        $("#add_lesson2").modal("hide");
                        $("#add_lesson_frm").find("input[type=url], input[type=number], input[type=text], textarea").val("");
                    }
                }
            });            
        } 

        

        if ($("#lesson_type").val() == "Document") {
            var id = $("#add_lesson_frm #chapter_id").val();
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: {
                    chapter_id: id,
                    action: 'add_lesson',
                    lesson_title: $('#add_lesson_frm .Document #lesson_title').val(),
                    lesson_type: 'document',
                    document_id: $('#add_lesson_frm .Document #document_id').val(),
                    lessonduration: 10
                },
                success:function(data){
                    if (data["status"] == 0) {
                        if (data['lesson_title']) {
                            $("#add_lesson_frm .Document .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $("#add_lesson_frm .Document .lesson_title_error").html('');
                        }

                        if (data['document_id']) {
                            $("#add_lesson_frm .Document #lesson_document_error").html(data["document_id"]);
                        } else {
                            $("#add_lesson_frm .Document #lesson_document_error").html('');
                        }
                    } else {
                        var id = $("#add_lesson_frm #chapter_id").val();
                        $('#lesson-wrapper-'+id).html(data["html"]);
                        $("#add_lesson2").modal("hide");
                        $("#add_lesson_frm").find("input[type=url], input[type=number], input[type=text], textarea").val("");
                    }
                }
            });            
        } 

        if ($("#lesson_type").val() == "Image-file") {
            var id = $("#add_lesson_frm #chapter_id").val();
            $.ajax({
                url:"<?php echo $site_url?>/proposals/action_course",
                method:"POST",
                dataType: 'json',
                data: {
                    chapter_id: id,
                    action: 'add_lesson',
                    lesson_title: $('#add_lesson_frm .Image-file #lesson_title').val(),
                    lesson_type: 'image',
                    image_id: $('#add_lesson_frm .Image-file #image_id').val(),
                    lessonduration: 10
                },
                success:function(data){
                    if (data["status"] == 0) {
                        if (data['lesson_title']) {
                            $(".Image-file .lesson_title_error").html(data["lesson_title"]);
                        } else {
                            $(".Image-file .lesson_title_error").html('');
                        }

                        if (data['image_id']) {
                            $(".Image-file #lesson_image_error").html(data["image_id"]);
                        } else {
                            $(".Image-file #lesson_image_error").html('');
                        }

                    } else {
                        var id = $("#add_lesson_frm #chapter_id").val();
                        $('#lesson-wrapper-'+id).html(data["html"]);
                        $("#add_lesson2").modal("hide");
                        $("#add_lesson_frm").find("input[type=url], input[type=number], input[type=text], textarea").val("");                    
                    }
                    //$("#add_lesson .modal-body").html(data["html"]);
                }
            });            
        } 

        

    });

        
        
});



// Upload Video File Zone
// var uppy = Uppy.Core()
//         .use(Uppy.Dashboard, {
//           inline: true,
//           target: '#video-type',
//         })
//         .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

//       uppy.on('complete', (result) => {
//         console.log('Upload complete! We’ve uploaded these files:', result.successful)
//       })

//       // Upload Document Zone
// var uppy = Uppy.Core()
//         .use(Uppy.Dashboard, {
//           inline: true,
//           target: '#document-type',
//         })
//         .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

//       uppy.on('complete', (result) => {
//         console.log('Upload complete! We’ve uploaded these files:', result.successful)
//       })

//       // Upload Image Zone
// var uppy = Uppy.Core()
//         .use(Uppy.Dashboard, {
//           inline: true,
//           target: '#image-type',
//         })
//         .use(Uppy.Tus, {endpoint: 'https://tusd.tusdemo.net/files/'})

//       uppy.on('complete', (result) => {
//         console.log('Upload complete! We’ve uploaded these files:', result.successful)
//       })

      
</script>


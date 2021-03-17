<?php 

$form_errors = Flash::render("form_errors");
$form_data = Flash::render("form_data");
if (empty($form_data)) {
  $form_data = $input->post();
}

?>


<section class="signup-step-container">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-9">
                    <div class="wizard">
                        <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Basic</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Requirements</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab"><span class="round-tab">3</span> <i>Outcomes</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">4</span> <i>Pricing</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step5" data-toggle="tab" aria-controls="step5" role="tab"><span class="round-tab">5</span> <i>Media</i></a>
                                </li>
                                <li role="presentation" class="disabled">
                                    <a href="#step6" data-toggle="tab" aria-controls="step6" role="tab"><span class="round-tab">6</span> <i>Curriculum</i></a>
                                </li>
                            </ul>
                        </div>
        
                        <form role="form" action="index.html" class="login-box">
                            <div class="tab-content" id="main_form">
                                <div class="tab-pane active" role="tabpanel" id="step1">
                                    <h4 class="text-center">Step 1</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Course title  *</label> 
                                                <input class="form-control" type="text" name="name" placeholder=""> 
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Short description  *</label> 
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> 
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Description *</label> 
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea> 
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                        <select name="proposal_cat_id" id="category" class="form-control mb-3"  required="">
<option value="" class="hidden"> Select A Category </option>
<?php 
  $get_cats = $db->select("categories");
  while($row_cats = $get_cats->fetch()){
  $cat_id = $row_cats->cat_id;
  $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $siteLanguage));
  $cat_title = $get_meta->fetch()->cat_title;
?>
<option <?php if(@$form_data['proposal_cat_id'] == $cat_id){ echo "selected"; } ?> value="<?= $cat_id; ?>"> <?= $cat_title; ?> </option>
<?php } ?>
</select>
<small class="form-text text-danger"><?= ucfirst(@$form_errors['proposal_cat_id']); ?></small>
<select name="proposal_child_id" id="sub-category" class="form-control" required="">
<option value="" class="hidden"> Select A Sub Category </option>
<?php if(@$form_data['proposal_child_id']){ ?>
<?php
  $get_c_cats = $db->select("categories_children",array("child_parent_id"=> $form_data['proposal_cat_id']));
  while($row_c_cats = $get_c_cats->fetch()){
  $child_id = $row_c_cats->child_id;
  $get_meta = $db->select("child_cats_meta",array("child_id"=>$child_id,"language_id"=>$siteLanguage));
  $row_meta = $get_meta->fetch();
  $child_title = $row_meta->child_title;
  echo "<option ".($form_data['proposal_cat_id'] == $child_id ? "selected" : "")." value='$child_id'> $child_title </option>";
  }
?>
<?php } ?>
</select>
                                        </div>


                                <div class="col-md-12">
                                <div class="form-group">
                                  <label for="Level">Level</label>
                                  <select class="form-control" id="exampleFormControlSelect1">
                                    <option>Beginner</option>
                                    <option>Advanced</option>
                                    <option>Intermediate</option>
                                
                                  </select>
                                </div>
                                </div>

                                <div class="col-md-12">
                                <div class="form-group">
                                  <label for="language-made">Language made in</label>
                                  <select class="form-control" id="exampleFormControlSelect1">
                                  <option value="af">Afrikaans</option>
    <option value="sq">Albanian - shqip</option>
    <option value="am">Amharic - አማርኛ</option>
    <option value="ar">Arabic - العربية</option>
    <option value="an">Aragonese - aragonés</option>
    <option value="hy">Armenian - հայերեն</option>
    <option value="ast">Asturian - asturianu</option>
    <option value="az">Azerbaijani - azərbaycan dili</option>
    <option value="eu">Basque - euskara</option>
    <option value="be">Belarusian - беларуская</option>
    <option value="bn">Bengali - বাংলা</option>
    <option value="bs">Bosnian - bosanski</option>
    <option value="br">Breton - brezhoneg</option>
    <option value="bg">Bulgarian - български</option>
    <option value="ca">Catalan - català</option>
    <option value="ckb">Central Kurdish - کوردی (دەستنوسی عەرەبی)</option>
    <option value="zh">Chinese - 中文</option>
    <option value="zh-HK">Chinese (Hong Kong) - 中文（香港）</option>
    <option value="zh-CN">Chinese (Simplified) - 中文（简体）</option>
    <option value="zh-TW">Chinese (Traditional) - 中文（繁體）</option>
    <option value="co">Corsican</option>
    <option value="hr">Croatian - hrvatski</option>
    <option value="cs">Czech - čeština</option>
    <option value="da">Danish - dansk</option>
    <option value="nl">Dutch - Nederlands</option>
    <option value="en">English</option>
    <option value="en-AU">English (Australia)</option>
    <option value="en-CA">English (Canada)</option>
    <option value="en-IN">English (India)</option>
    <option value="en-NZ">English (New Zealand)</option>
    <option value="en-ZA">English (South Africa)</option>
    <option value="en-GB">English (United Kingdom)</option>
    <option value="en-US">English (United States)</option>
    <option value="eo">Esperanto - esperanto</option>
    <option value="et">Estonian - eesti</option>
    <option value="fo">Faroese - føroyskt</option>
    <option value="fil">Filipino</option>
    <option value="fi">Finnish - suomi</option>
    <option value="fr">French - français</option>
    <option value="fr-CA">French (Canada) - français (Canada)</option>
    <option value="fr-FR">French (France) - français (France)</option>
    <option value="fr-CH">French (Switzerland) - français (Suisse)</option>
    <option value="gl">Galician - galego</option>
    <option value="ka">Georgian - ქართული</option>
    <option value="de">German - Deutsch</option>
    <option value="de-AT">German (Austria) - Deutsch (Österreich)</option>
    <option value="de-DE">German (Germany) - Deutsch (Deutschland)</option>
    <option value="de-LI">German (Liechtenstein) - Deutsch (Liechtenstein)</option>
    <option value="de-CH">German (Switzerland) - Deutsch (Schweiz)</option>
    <option value="el">Greek - Ελληνικά</option>
    <option value="gn">Guarani</option>
    <option value="gu">Gujarati - ગુજરાતી</option>
    <option value="ha">Hausa</option>
    <option value="haw">Hawaiian - ʻŌlelo Hawaiʻi</option>
    <option value="he">Hebrew - עברית</option>
    <option value="hi">Hindi - हिन्दी</option>
    <option value="hu">Hungarian - magyar</option>
    <option value="is">Icelandic - íslenska</option>
    <option value="id">Indonesian - Indonesia</option>
    <option value="ia">Interlingua</option>
    <option value="ga">Irish - Gaeilge</option>
    <option value="it">Italian - italiano</option>
    <option value="it-IT">Italian (Italy) - italiano (Italia)</option>
    <option value="it-CH">Italian (Switzerland) - italiano (Svizzera)</option>
    <option value="ja">Japanese - 日本語</option>
    <option value="kn">Kannada - ಕನ್ನಡ</option>
    <option value="kk">Kazakh - қазақ тілі</option>
    <option value="km">Khmer - ខ្មែរ</option>
    <option value="ko">Korean - 한국어</option>
    <option value="ku">Kurdish - Kurdî</option>
    <option value="ky">Kyrgyz - кыргызча</option>
    <option value="lo">Lao - ລາວ</option>
    <option value="la">Latin</option>
    <option value="lv">Latvian - latviešu</option>
    <option value="ln">Lingala - lingála</option>
    <option value="lt">Lithuanian - lietuvių</option>
    <option value="mk">Macedonian - македонски</option>
    <option value="ms">Malay - Bahasa Melayu</option>
    <option value="ml">Malayalam - മലയാളം</option>
    <option value="mt">Maltese - Malti</option>
    <option value="mr">Marathi - मराठी</option>
    <option value="mn">Mongolian - монгол</option>
    <option value="ne">Nepali - नेपाली</option>
    <option value="no">Norwegian - norsk</option>
    <option value="nb">Norwegian Bokmål - norsk bokmål</option>
    <option value="nn">Norwegian Nynorsk - nynorsk</option>
    <option value="oc">Occitan</option>
    <option value="or">Oriya - ଓଡ଼ିଆ</option>
    <option value="om">Oromo - Oromoo</option>
    <option value="ps">Pashto - پښتو</option>
    <option value="fa">Persian - فارسی</option>
    <option value="pl">Polish - polski</option>
    <option value="pt">Portuguese - português</option>
    <option value="pt-BR">Portuguese (Brazil) - português (Brasil)</option>
    <option value="pt-PT">Portuguese (Portugal) - português (Portugal)</option>
    <option value="pa">Punjabi - ਪੰਜਾਬੀ</option>
    <option value="qu">Quechua</option>
    <option value="ro">Romanian - română</option>
    <option value="mo">Romanian (Moldova) - română (Moldova)</option>
    <option value="rm">Romansh - rumantsch</option>
    <option value="ru">Russian - русский</option>
    <option value="gd">Scottish Gaelic</option>
    <option value="sr">Serbian - српски</option>
    <option value="sh">Serbo-Croatian - Srpskohrvatski</option>
    <option value="sn">Shona - chiShona</option>
    <option value="sd">Sindhi</option>
    <option value="si">Sinhala - සිංහල</option>
    <option value="sk">Slovak - slovenčina</option>
    <option value="sl">Slovenian - slovenščina</option>
    <option value="so">Somali - Soomaali</option>
    <option value="st">Southern Sotho</option>
    <option value="es">Spanish - español</option>
    <option value="es-AR">Spanish (Argentina) - español (Argentina)</option>
    <option value="es-419">Spanish (Latin America) - español (Latinoamérica)</option>
    <option value="es-MX">Spanish (Mexico) - español (México)</option>
    <option value="es-ES">Spanish (Spain) - español (España)</option>
    <option value="es-US">Spanish (United States) - español (Estados Unidos)</option>
    <option value="su">Sundanese</option>
    <option value="sw">Swahili - Kiswahili</option>
    <option value="sv">Swedish - svenska</option>
    <option value="tg">Tajik - тоҷикӣ</option>
    <option value="ta">Tamil - தமிழ்</option>
    <option value="tt">Tatar</option>
    <option value="te">Telugu - తెలుగు</option>
    <option value="th">Thai - ไทย</option>
    <option value="ti">Tigrinya - ትግርኛ</option>
    <option value="to">Tongan - lea fakatonga</option>
    <option value="tr">Turkish - Türkçe</option>
    <option value="tk">Turkmen</option>
    <option value="tw">Twi</option>
    <option value="uk">Ukrainian - українська</option>
    <option value="ur">Urdu - اردو</option>
    <option value="ug">Uyghur</option>
    <option value="uz">Uzbek - o‘zbek</option>
    <option value="vi">Vietnamese - Tiếng Việt</option>
    <option value="wa">Walloon - wa</option>
    <option value="cy">Welsh - Cymraeg</option>
    <option value="fy">Western Frisian</option>
    <option value="xh">Xhosa</option>
    <option value="yi">Yiddish</option>
    <option value="yo">Yoruba - Èdè Yorùbá</option>
    <option value="zu">Zulu - isiZulu</option>
                                  </select>
                                </div>
                                </div>
                                        
                                        
                                        
                                    </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step2">
                                    <h4 class="text-center">Step 2</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 1</label>
                                    <input type="text" class="form-control" id="Requirements1"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 2</label>
                                    <input type="text" class="form-control" id="Requirements2"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 3</label>
                                    <input type="text" class="form-control" id="Requirements3"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 4</label>
                                    <input type="text" class="form-control" id="Requirements4"  placeholder="Provide requirements">
                                        </div>
                                        <div class="form-group">
                                        <label for="Requirements">Requirements 5</label>
                                    <input type="text" class="form-control" id="Requirements5"  placeholder="Provide requirements">
                                        </div>
                                    </div>
 
                                   </div>
                                    
                                    
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step3">
                                    <h4 class="text-center">Step 3</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                        <label for="Outcomes">Outcomes 1</label>
                                    <input type="text" class="form-control" id="Outcomes1"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes2">Outcomes 2</label>
                                    <input type="text" class="form-control" id="Outcomes2"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes3">Outcomes 3</label>
                                    <input type="text" class="form-control" id="Outcomes3"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes4">Outcomes 4</label>
                                    <input type="text" class="form-control" id="Outcomes4"  placeholder="Provide Outcome">
                                        </div>
                                        <div class="form-group">
                                        <label for="Outcomes5">Outcomes 5</label>
                                    <input type="text" class="form-control" id="Outcomes5"  placeholder="Provide Outcome">
                                        </div>
                                    </div>
 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>
                                <div class="tab-pane" role="tabpanel" id="step4">
                                    <h4 class="text-center">Step 4</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
                                                <label>Course price ($)  *</label> 
                                                <input class="form-control" type="number" name="name" placeholder="Enter course course price"> 
                                            </div>
                                            <div class="form-group">
                                                <label>Discounted price ($) <small>Leave 0 if its not free</small></label> 
                                                <input class="form-control" type="number" name="name" placeholder="Enter discounted price"> 
                                            </div>
                                        
                                      
                                      
                                    </div>
 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>

                                <div class="tab-pane" role="tabpanel" id="step5">
                                    <h4 class="text-center">Step 5</h4>
                                    <div class="row">
                                    <div class="col-md-12">
                                    <div class="form-group">
    <label for="course-provider-source">Course overview provider</label>
    <select class="form-control" id="exampleFormControlSelect1">
      <option>Youtube</option>
      <option>Vimeo</option>
      <option>Upload from your system</option>
    
    </select>
  </div>
                                            <div class="form-group">
                                                <label>Course preview video url</label> 
                <input class="form-control" type="text" name="video-url" placeholder="Enter video url" value="https://www.youtube.com/watch?v=TXzLvYN-HSc"> 
                                            </div>

                                            <div class="form-group imgUp">
                                                <label>Course Thumbnail</label> 
                                                <div class="imagePreview"></div>
<label class="btn btn-primary">
										    			Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
				</label>
                                            </div>
                                        
                                      
                                      
                                    </div>
 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        <li><button type="button" class="btn btn-success prev-step">Back</button></li>
                                        <li><button type="button" class="btn btn-success next-step">Continue</button></li>
                                    </ul>
                                </div>




                                <div class="tab-pane" role="tabpanel" id="step6">
                                    <h4 class="text-center">Step 6</h4>
                                    <div class="row d-flex justify-content-center">
                                    <div class="col-md-12 text-right">
                                    
                                           

                                    <a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#add_section"> <i class="fa fa-plus" aria-hidden="true"></i> Add section</a>
                                    <a class="btn btn-outline-primary" href="#" role="button" data-toggle="modal" data-target="#add_lesson"> <i class="fa fa-plus" aria-hidden="true"></i> Add lesson</a>
                                        
                                      
                                      
                                    </div>

                                    <div class="col-md-12 mt-4 mb-5">
                                    
                                           

                                    <div class="card">
  <div class="card-body shadow-sm">
    <h6>Section 1: Introduction to B-Roll</h6>
  </div>
</div>
                                        
                                      
                                      
                                    </div>




 
                                   </div>
                                    <ul class="list-inline pull-right">
                                        
                                        <li><button type="button" class="btn btn-success next-step">Finish</button></li>
                                    </ul>
                                </div>


                                <div class="clearfix"></div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Add new section Modal -->
<div class="modal fade" id="add_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_sectionLabel">Add new section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
  <div class="form-group">
    <label for="exampleInputEmail1">Section Title</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">Provide a section name</small>
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


<!-- Add new lesson Modal -->
<div class="modal fade" id="add_lesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add_lessonLabel">Add new section</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form>
  <div class="form-group">
    <label for="exampleInputEmail1">Section Title</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">Provide a section name</small>
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


    <script>
    // ------------step-wizard-------------
$(document).ready(function () {
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

        var target = $(e.target);
    
        if (target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        active.next().removeClass('disabled');
        nextTab(active);

    });
    $(".prev-step").click(function (e) {

        var active = $('.wizard .nav-tabs li.active');
        prevTab(active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}


$('.nav-tabs').on('click', 'li', function() {
    $('.nav-tabs li.active').removeClass('active');
    $(this).addClass('active');
});

$(".imgAdd").click(function(){
  $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
});
$(document).on("click", "i.del" , function() {
	$(this).parent().remove();
});
$(function() {
    $(document).on("change",".uploadFile", function()
    {
    		var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
      
    });
});



    
    </script>
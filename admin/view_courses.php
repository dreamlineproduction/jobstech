<?php

@session_start();

if(!isset($_SESSION['admin_email'])){

    echo "<script>window.open('login','_self');</script>";

}else{

    $count_all_courses = $db->query("select * from courses")->rowCount();

    $count_active_courses = $db->count("courses",array("status" => "active"));
    $count_featured_courses = $db->count("courses",array("status"=>"active","featured"=>1));
    $count_pending_courses = $db->count("courses",array("status" => "pending"));
    $count_pause_courses = $db->query("select * from courses where status='paused'")->rowCount();
    $count_blocked_courses = $db->count("courses",array("status" => "blocked"));
    $count_trash_courses = $db->count("courses",array("status" => "trashed"));

    ?>

    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1><i class="menu-icon fa fa-table"></i> Courses</h1>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="page-header float-right">
                <div class="page-title">
                    <ol class="breadcrumb text-right">
                        <li class="active">Courses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row "><!--- 1 row Starts --->

            <div class="col-lg-12"><!--- col-lg-12 Starts --->

                <div class="p-3 mb-3  "><!--- p-3 mb-3 filter-form Starts --->

                    <h2 class="pb-4">Filter Courses</h2>

                    <form class="form-inline pb-2" method="get" action="filter_proposals.php">

                        <div class="form-group"><!--- form-group Starts --->

                            <label> Category : </label>

                            <select name="cat_id" required class="form-control mb-2 ml-1 mr-sm-2 mb-sm-0">

                                <option value=""> All Categories </option>

                                <?php

                                $get_categories = $db->select("categories");
                                while($row_categories = $get_categories->fetch()){
                                    $cat_id = $row_categories->cat_id;

                                    $get_meta = $db->select("cats_meta",array("cat_id" => $cat_id, "language_id" => $adminLanguage));
                                    $cat_title = $get_meta->fetch()->cat_title;

                                    echo "<option value='$cat_id'>$cat_title</option>";
                                }

                                ?>

                            </select>

                        </div><!--- form-group Ends --->


                        <div class="form-group">

                            <label> Course Level: </label>

                            <select name="level" class="form-control mb-2 ml-1 mr-sm-2 mb-sm-0">

                                <option value=""> All Course Levels </option>
                                <option value="0">Beginner</option>
                                <option value="1">Intermediate</option>
                                <option value="2">Advanced</option>
                            </select>

                        </div>


                        <div class="form-group">

                            <label> Course Language: </label>

                            <select name="level" class="form-control mb-2 ml-1 mr-sm-2 mb-sm-0">
                                <option value="">All Course Languages</option>
                                <?php
                                $course_languages = $db->select('course_languages')->fetchAll();
                                foreach ($course_languages as $language) {
                                    echo '<option value="' . $language->code . '">' . $language->name . '</option>';
                                }
                                ?>
                            </select>

                        </div>

                        <button type="submit" class="btn btn-success"> Filter</button>

                    </form>

                </div><!--- p-3 mb-3 filter-form Ends --->

            </div><!--- col-lg-12 Ends --->

        </div><!--- 1 row Ends --->


        <div class="row mt-3"><!--- 2 row mt-3 Starts --->

            <div class="col-lg-12"><!--- col-lg-12 Starts --->

                <div class="card"><!--- card Starts --->

                    <div class="card-header"><!--- card-header Starts --->

                        <h4 class="h4">Courses</h4>

                    </div><!--- card-header Ends --->

                    <div class="card-body"><!--- card-body Starts --->

                        <a href="index?view_courses" class="make-black font-weight-bold mr-2">

                            All (<?= $count_all_courses; ?>)

                        </a>

                        <span class="mr-2">|</span>

                        <a href="index?view_courses_active" class="mr-2">

                            Active (<?= $count_active_courses; ?>)

                        </a>

                        <span class="mr-2">|</span>

                        <a href="index?view_courses_featured" class="mr-2">

                            Featured (<?= $count_featured_courses; ?>)

                        </a>

                        <span class="mr-2">|</span>

                        <a href="index?view_courses_pending" class="mr-2">

                            Pending Approval (<?= $count_pending_courses; ?>)

                        </a>

                        <span class="mr-2">|</span>

                        <a href="index?view_courses_paused" class="mr-2">

                            Paused (<?= $count_pause_courses; ?>)

                        </a>

                        <span class="mr-2">|</span>

                        <a href="index?view_courses_trash" class="mr-2">

                            Trash (<?= $count_trash_courses; ?>)

                        </a>

                        <div class="table-responsive mt-4"><!--- table-responsive mt-4 Starts --->

                            <table class="table  table-bordered table-striped"><!--- table table-hover table-bordered Starts --->

                                <thead><!--- thead Starts --->

                                <tr>

                                    <th>Course's Title</th>

                                    <th>Course's Display Image</th>

                                    <th>Course's Price</th>

                                    <th>Course's Discounted Price</th>

                                    <th>Course's Category</th>

                                    <th>Course's Subcategory</th>

                                    <th>Course's Status</th>

                                    <th>Course's Action Options</th>

                                </tr>

                                </thead><!--- thead Ends --->

                                <tbody><!--- tbody Starts --->

                                <?php

                                $per_page = 10;

                                if(isset($_GET['view_courses'])){

                                    $page = $input->get('view_courses');

                                    if($page == 0){ $page = 1; }

                                }else{

                                    $page = 1;

                                }

                                /// Page will start from 0 and multiply by per page

                                $start_from = ($page-1) * $per_page;

                                $get_courses = $db->query("select * from courses order by 1 DESC LIMIT :limit OFFSET :offset","",array("limit"=>$per_page,"offset"=>$start_from));

                                while($row_courses = $get_courses->fetch()){

                                    $course_id = $row_courses->id;
                                    $course_title = $row_courses->title;
                                    $course_url = $row_courses->course_url;
                                    $course_price = $row_courses->price;
                                    $course_discounted_price = $row_courses->discounted_price;
                                    $course_img1 = getImageUrl2("proposals","proposal_img1",$row_courses->proposal_img1);
                                    $course_cat_id = $row_courses->category;
                                    $course_subcat_id = $row_courses->sub_category;
                                    $course_seller_id = $row_courses->seller_id;
                                    $course_status = $row_courses->status;
                                    $course_featured = $row_courses->featured;
                                    $course_toprated = $row_courses->toprated;

                                    /*if($proposal_price == 0){

                                        $proposal_price = "";

                                        $get_p = $db->select("proposal_packages",array("proposal_id" => $proposal_id));

                                        while($row = $get_p->fetch()){

                                            $proposal_price .=" | $s_currency" . $row->price;

                                        }

                                    }else{

                                        $proposal_price = "$s_currency" . $proposal_price;

                                    }*/
                                    $course_price = $s_currency . $course_price;

                                    $course_discounted_price = $s_currency . $course_discounted_price;


                                    $select_seller = $db->select("sellers",array("seller_id" => $course_seller_id));

                                    $seller_user_name = $select_seller->fetch()->seller_user_name;


                                    /*$select_orders = $db->query("select * from orders where proposal_id='$proposal_id' AND NOT order_status='complete' AND proposal_id='$proposal_id' AND NOT order_status='cancelled'");

                                    $proposal_order_queue = $select_orders->rowCount();*/


                                    $get_meta = $db->select("cats_meta",array("cat_id" => $course_cat_id, "language_id" => $adminLanguage));

                                    $cat_title = $get_meta->fetch()->cat_title;


                                    $get_child_meta = $db->select("child_cats_meta",array("child_id" => $course_subcat_id, "language_id" => $adminLanguage));

                                    $subcat_title = $get_child_meta->fetch()->child_title;

                                    ?>

                                    <tr>

                                        <td><?= $course_title; ?></td>

                                        <td>

                                            <img src="<?= $$course_img1; ?>" width="70" height="60">

                                        </td>

                                        <td><?= $course_price; ?></td>

                                        <td><?= $course_discounted_price; ?></td>

                                        <td><?= $cat_title; ?></td>

                                        <td><?= $subcat_title; ?></td>

                                        <td><?= ucfirst($course_status); ?></td>

                                        <?php if($course_status == "active"){ ?>

                                            <td>

                                                <a title="View Proposal" href="../proposals/<?= $seller_user_name; ?>/<?= $course_url; ?>" target="_blank">

                                                    <i class="fa fa-eye"></i>

                                                </a>

                                                <?php if($course_featured == 1){ ?>

                                                    <a class="text-success" title="Remove Proposal From Featured Listing." href="index?remove_feature_proposal=<?= $course_id; ?>&page=<?= $page; ?>"/>

                                                    <i class="fa fa-star-half-o"></i>

                                                    </a>

                                                <?php }else{ ?>

                                                    <a href="index?feature_proposal=<?= $course_id; ?>&page=<?= $page; ?>" title="Make Your Proposal Featured">
                                                        <i class="fa fa-star"></i>
                                                    </a>

                                                <?php } ?>

                                                <?php if($course_toprated == 0){ ?>
                                                    <a href="index?toprated_proposal=<?= $course_id; ?>&page=<?= $page; ?>" title="Make Your Proposal Top Rated">
                                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                                    </a>
                                                <?php }else{ ?>
                                                    <a class="text-danger" href="index?removetoprated_proposal=<?= $course_id; ?>&page=<?= $page; ?>" title="Remove Proposal From Top Rated Listing.">
                                                        <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                                    </a>
                                                <?php } ?>

                                                <a title="Pause/Deactivate Proposal" href="index?pause_proposal=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-pause-circle"></i>

                                                </a>


                                                <a title="Delete Proposal" href="index?move_to_trash=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-trash"></i>

                                                </a>


                                            </td>

                                        <?php }elseif($course_status == "paused" or $course_status == "blocked"){ ?>

                                            <td>

                                                <a title="View Proposal" href="../proposals/<?= $seller_user_name; ?>/<?= $course_url; ?>" target="_blank">

                                                    <i class="fa fa-eye"></i> Preview

                                                </a>

                                                <br>

                                                <a href="index?unpause_proposal=<?= $course_id; ?>&page=<?= $page; ?>" >

                                                    <i class="fa fa-refresh"></i> Unpause

                                                </a>

                                                <br>

                                                <a href="index?move_to_trash=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-trash"></i> Trash Proposal

                                                </a>

                                            </td>

                                        <?php }elseif($course_status == "pending"){ ?>

                                            <td>

                                                <a title="View Proposal" href="../proposals/<?= $seller_user_name; ?>/<?= $course_url; ?>" target="_blank">

                                                    <i class="fa fa-eye"></i> Preview

                                                </a>

                                                <br/>

                                                <a href="index?submit_modification=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-edit"></i> Submit For Modification

                                                </a>

                                                <br>

                                                <a href="index?approve_proposal=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-check-square-o"></i> Approve

                                                </a>

                                                <br/>

                                                <a title="Decline this Proposal" href="index?decline_proposal=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-ban"></i> Decline

                                                </a>

                                            </td>

                                        <?php }elseif($course_status == "declined"){ ?>

                                            <td>

                                                <a href="index?approve_proposal=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-check-square-o"></i> Approve

                                                </a>

                                                <br/>

                                                <a href="index?submit_modification=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-edit"></i> Submit For Modification

                                                </a>

                                                <br>

                                                <a title="View Proposal" href="../proposals/<?= $seller_user_name; ?>/<?= $course_url; ?>" target="_blank">

                                                    <i class="fa fa-eye"></i> Preview

                                                </a>

                                                <br/>

                                                <a href="index?delete_proposal=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-trash"></i> Delete Permanently

                                                </a>

                                            </td>

                                        <?php }elseif($course_status == "trash"){ ?>

                                            <td>

                                                <a href="index?restore_proposal=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-reply"></i> Restore Proposal

                                                </a>

                                                <br/>

                                                <a href="index?delete_proposal=<?= $course_id; ?>&page=<?= $page; ?>">

                                                    <i class="fa fa-trash"></i> Delete Permanently

                                                </a>

                                            </td>


                                        <?php } ?>

                                    </tr>

                                <?php } ?>

                                </tbody><!--- tbody Ends --->

                            </table><!--- table table-hover table-bordered Ends --->

                        </div><!--- table-responsive mt-4 Ends --->

                        <div class="d-flex justify-content-center"><!--- d-flex justify-content-center Starts --->

                            <ul class="pagination"><!--- pagination Starts --->

                                <?php

                                /// Now Select All From Proposals Table

                                $query = $db->query("select * from courses");

                                /// Count The Total Records

                                $total_records = $query->rowCount();

                                /// Using ceil function to divide the total records on per page

                                $total_pages = ceil($total_records / $per_page);

                                echo "<li class='page-item'><a href='index?view_proposals=1' class='page-link'> First Page </a></li>";

                                echo "<li class='page-item ".(1 == $page ? "active" : "")."'><a class='page-link' href='index?view_proposals=1'>1</a></li>";

                                $i = max(2, $page - 5);

                                if($i > 2){
                                    echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";
                                }

                                for (; $i < min($page + 6, $total_pages); $i++) {

                                    echo "<li class='page-item"; if($i == $page){ echo " active "; } echo "'><a href='index?view_proposals=".$i."' class='page-link'>".$i."</a></li>";

                                }

                                if ($i != $total_pages and $total_pages > 1){echo "<li class='page-item' href='#'><a class='page-link'>...</a></li>";}

                                if($total_pages > 1){echo "<li class='page-item ".($total_pages == $page ? "active" : "")."'><a class='page-link' href='index?view_proposals=$total_pages'>$total_pages</a></li>";}

                                echo "<li class='page-item'><a href='index?view_proposals=$total_pages' class='page-link'>Last Page </a></li>";

                                ?>

                            </ul><!--- pagination Ends --->

                        </div><!--- d-flex justify-content-center Ends --->

                    </div><!--- card-body Ends --->

                </div><!--- card Ends --->

            </div><!--- col-lg-12 Ends --->

        </div><!--- 2 row mt-3 Ends --->

    </div>

<?php } ?>
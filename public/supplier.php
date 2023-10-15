<?php
require_once("../config/grobals.php");

include("./includes/head.php");
if (isset($_GET['n'])) {
    $id = $_GET['n'];
    $idDec=input::enc_dec("d",$id);
    $database->query("DELETE FROM notifications_tb where id=$idDec");
}
?>

<div id="main-wrapper">
    <?php include("./includes/sidebar.php") ?>
    <!-- header here -->
    <?php include("./header.php") ?>
    <!-- chatbox here -->
    <div class="content-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0 d-sm-flex flex-wrap d-block">
                            <div class="mb-3">
                                <h4 class="card-title mb-1">
                                    <!-- <button class=" btn btn-outline-primary">Create Menu</button> -->
                                    <button class=" btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#basicModal">Add New</button>
                                </h4>                                   
                                <!-- <small class="mb-0"></small> -->
                            </div>
                            <div class="card-action card-tabs mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#monthly" role="tab">
                                            ALL Suppliers
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
             <div class="col-12">
             <div class=" card">
             <div class="card-body">
                    <div class="table-responsive">
                                <table id="example"  class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                        <th class=" fs-13">#</th>
                                            <th class=" fs-13">Name</th>
                                            <th class=" fs-13">TIN</th>
                                            <th class=" fs-13">Email</th>
                                            <th class=" fs-13">Phone</th>
                                            <th class=" fs-13">Place</th>
                                            <th class=" fs-13">Join Date</th>
                                            <th class="fs-13">Approved</th>
                                        </tr>
                                    </thead>
                                    <tbody class=" fs-12">
                                        <?php
                                            $cond="";
                                            if(isset($_GET['d'])){
                                                $cond="where id={$_GET['d']}";
                                            }
                                        $lists=$database->fetch("SELECT * FROM a_partner_tb $cond  order by id desc");
                                        $i=0;
                                        foreach ($lists as $key => $h) {
                                            $i++;
                                            ?>
                                            <tr>
                                            <td><?= $i?></td>
                                                <td class=" text-capitalize"><?= $h['name'] ?></td>
                                                <td class=""><?= $h['tin'] ?></td>
                                                <td class=""><?= $h['email'] ?></td>
                                                <td class=""><?= $h['phone'] ?></td>
                                                <td class=""><?= $h['place'] ?></td>
                                                <td class=""><?= date('Y-m-d',strtotime($h['created_at'])) ?></td>
                                                <td>
                                                    <select  class="approveSupplier form-control is_<?=$h['is_active']?>" data-sup="<?= $h['id']?>">
                                                       <option value="yes" <?php if($h['is_active']=="yes")echo "selected" ?>> Yes </option>
                                                       <option value="no" <?php if($h['is_active']=="no")echo "selected" ?>> No </option>
                                                </select>
                                                </td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                </div>
             </div>
             </div>
            </div>
        </div>
    </div>
        <!-- modal -->
        <div class="modal fade bd-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Supplier</h5>
                    <span class="  close"> <span class=" fa fa-times " data-bs-dismiss="modal"></span></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Name <span class="required text-danger">*</span></label>
                                <input type="text"  name="name" placeholder="Eg:TECHRWANDA" class=" form-control text-uppercase"/>
                                <input type="hidden" name="action" value="CREATE_NEW_SUPPLIER"/>
                            </div>
                        </div> 
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Contact phone <span class="required text-danger">*</span></label>
                                <input  type="number" name="phone" placeholder="Eg:0789000000" class=" form-control"/>
                            </div>
                        </div> 
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Contact Email <span class="required text-danger">*</span></label>
                                <input  type="email" name="email" placeholder="email here" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">TIN <span class="required text-danger">*</span></label>
                                <input type="number"  name="tin" placeholder="Eg:000000001" class=" form-control" onkeypress="limitKeypress(event,this.value,9)"/>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="menu_type" class="text-black form-label">Working Place <span class="required text-danger">*</span></label>
                                <input  type="text" name="place" placeholder="Eg:KIGALI-MUHIMA" class=" form-control"/>
                            </div>
                        </div> 
                        <div class="col-12">
                            <div id="ajaxresults"></div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"  onclick="onSupplierCreated(this)">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal -->
    <!-- include footer -->
    <?php include_once("./footer.php") ?>
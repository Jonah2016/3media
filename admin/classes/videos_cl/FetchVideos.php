<?php require_once("../../resources/auth.inc.php"); ?>

<table class="table table-striped table-hover display nowrap table-bordered" id="simple_table" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th> <i class="fa fa-check-square"> </i> </th>
            <th> # </th>
            <th> Thumbnail </th>
            <th> Category </th>
            <th> Title </th>
            <th> Description </th>
            <th> Youtube URL </th>
            <th> Author </th>
            <th> Date </th>
            <th> Created at </th>
            <th> Updated at </th>
            <th> Action </th>
        </tr>
    </thead>
    <tbody>
        <?php
            $stmt = $db_connect->prepare("SELECT * FROM videos WHERE vid_active_status!=3 ORDER BY vid_id DESC ");
            $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $counter = 1;
            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $vid_image = $row['vid_thumbnail'];
                $photo_directory =  UPLOADS_PATH.'videos_thumbnails/'.$vid_image;
                $vid_title = $row['vid_title'];
                $vid_description = htmlspecialchars_decode($row['vid_description']);
                ?>
        <tr>
            <td></td>
            <td><?php echo $counter++; ?></td>
            <td class="py-1">
                <?php if ($vid_image != "") : ?>
                    <img width="50px" onclick="PopUpImage(this)"  alt="<?php echo $vid_img_caption; ?>" src="<?php echo $photo_directory; ?>">
                <?php else :  ?>
                    <img width="50px" onclick="PopUpImage(this)" alt="<?php echo $vid_title; ?>" src="<?php echo UPLOADS_PATH.'templates/no_photo.png'; ?>">
                <?php endif ?>
            </td>
            <td><?php echo $row['vid_category']; ?></td>
            <td><?php echo $row['vid_title']; ?></td>
            <td><button class="btn btn-info btn-sm" data-name='<?php echo $vid_title; ?>' data-bio='<?php echo htmlentities($vid_description); ?>' onclick="PopUpVideoDesc(this)">View Body</button></td>
            <td><a href="<?php echo 'https://www.youtube.com/watch?v='.$row['vid_youtube_url']; ?>" target="__blank"><?php echo 'https://www.youtube.com/watch?v='.$row['vid_youtube_url']; ?></a></td>
            <td><?php echo $row['vid_author']; ?></td>
            <td><?php echo $row['vid_date']; ?></td>
            <td class="text-center"><?php if ($row['vid_created_at'] !== '0000-00-00 00:00:00') { echo $row['vid_created_at']; } else { echo '---'; } ?></td>
            <td class="text-center"><?php if ($row['vid_updated_at'] !== '0000-00-00 00:00:00') { echo $row['vid_updated_at']; } else { echo '---'; } ?></td>
            <!-- actions -->
            <td>
                <div class="dropdown">
                    <button class="btn btn-primary btn-sm dropdown-toggle dropdown-toggle-split px-1 py-1" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" > <i class="fa fa-ellipsis-v"> </i> <i class="caret"></i></button>
                    <ul class="dropdown-menu dropdown-menu-right p-2" style="min-width: 6rem" >
                        <!-- Update video -->
                    <?php if ($neo_med_edit == 1) : ?>
                        <li class="pb-1">
                            <button data-id="<?php echo $row['vid_hashed'];?>" class="btn btn-sm btn-info btn-block text-capitalize px-1 py-1 edit_video"><i class="fa fa-edit"> </i> Edit</button>
                        </li>
                    <?php endif ?>
                        <!-- Delete video -->
                    <?php if ($neo_med_delete == 1) : ?>
                        <li class="pb-1">
                            <button data-id="<?php echo $row['vid_hashed'];?>" class="btn btn-sm btn-danger btn-block text-capitalize px-1 py-1 delete_video"><i class="fa fa-trash"> </i> Delete </button>
                        </li>
                    <?php endif ?>
                    </ul>
                </div>
            </td>
        </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>


<!-- video pop up modal -->
<div class="modal fade popUpVideoFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-xl" role="document" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="videoDescDisplay"><p class="popUpVideoDesc"></p></div>
            </div>
            <div class="modal-footer" align="center">
                <h5 class="text-center popUpVideoTitle"></h5> <!--caption appears under the popup image-->
            </div>
        </div>
    </div>
</div>
<!-- Image pop up modal -->
<div class="modal fade popUpPhotoFrame" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document" style="width: 100%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="weight-700 text-danger">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="photoDisplay"><img class="popUpPhoto" src="" alt="video thumbnail" /></div>
            </div>
            <div class="modal-footer" align="center">
                <h5 class="text-center popUpPhotoTitle"></h5> <!--caption appears under the popup image-->
            </div>
        </div>
    </div>
</div>

<!-- Settings for tables with class=simple_table -->
<script>
    $(document).ready(function() {

        document.title='List of All Videos';
        $.fn.dataTable.ext.errMode = 'throw';
        $('#simple_table').DataTable({
            destroy: true,
            paging: true,
            "autoWidth": true,
            "fixedHeader": true,
            "info": false,
            searching: true,
            colReorder: true,
            dom: 'Blfrtip',
            buttons: [
                { extend: 'pdf' , exportOptions: {columns: ':visible', rows: ':visible'}, footer: true, orientation: 'landscape', className: 'btn btn-sm' },
                { extend: 'colvis', collectionLayout: 'three-column', prefixButtons: [{extend: 'colvisGroup', text: 'Show all', show: ':hidden'}, {extend: 'colvisRestore',text: 'Restore'}], className: 'btn btn-sm' } 
            ],
            columnDefs: [ {
                className: 'select-checkbox',
                targets:   0
            } ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },

            scrollY: "600px",
            scrollX: true,
            scrollCollapse: true,
            deferRender:    true,
            scroller:       true,
            fixedColumns:{ leftColumns: 0 },
            paging: true
        } );
 
    });

    // pop up video image
    function PopUpVideoDesc(property){
        var name = $(property).data('name');
        var video =  $(property).data('bio');
        $('.popUpVideoDesc').html(video).css({
            'min-width': '50%',
            'min-height': '300px',
            'max-height': '500px',
            'padding': '10px'
        });
        $('.videoDescDisplay').css({
            'display': 'flex',
            'justify-content': 'center',
            'align-items': 'center',
            'overflow-y': 'scroll'
        });
        $('.popUpVideoTitle').text('Title: '+name);
        $('.popUpVideoFrame').modal('show');
    }
    // pop up video image
    function PopUpImage(property){
        var img_url = property.src;
        var img_title = property.alt;
        $('.popUpPhoto').attr('src', img_url).css({
            'min-width': '50%',
            'min-height': '300px',
            'max-height': '500px'
        });
        $('.photoDisplay').css({
            'display': 'flex',
            'justify-content': 'center',
            'align-items': 'center',
            'overflow': 'hidden'
        });
        $('.popUpPhotoTitle').text(img_title);
        $('.popUpPhotoFrame').modal('show');
    }
</script>
<!-- // End Settings for tables with class=simple_table -->



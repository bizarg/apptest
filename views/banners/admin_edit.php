<?php //dd($images) ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <h3>Edit Banner</h3>
    </div>

    <div class="panel-body">
        <form action="/admin/banners/update/<?=$banner->id?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label for="name_banner">Banner Name</label>
                <input type="text" id="name_banner" name="name_banner" value="<?=$banner->name?>" class="form-control"/>
            </div>

            <div class="form-group">
                <select name="images[]" id="" multiple class="form-control">

                    <?php foreach (checkArr($images) as $image) : ?>

                        <option value="<?=$image->id?>" <?php if (in_array($image->id, $banner->images)) :?>selected<?php endif;?>><?=$image->name?></option>
                    <?php endforeach; ?>
                </select>
            </div>


            <input type="submit" class="btn btn-success" />
        </form>
    </div>
</div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-10"><h2>Images</h2></div>
                <div class="col-md-2">
                    <a class="btn btn-default" id="save">Save position</a>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <table style="width: 100%" class="table table-striped">
                <tr>
                    <th style="width: 30%;">Image</th>
                    <th style="width: 30%;">Position</th>
                    <th style="width: 40%;">Action</th>
                </tr>
                <form action="/admin/banners/position/<?=$banner->id?>" id="formpos" method="post">
                    <?php foreach (checkArr($banner->images) as $key => $image) : ?>


                        <tr class="position" id="<?=++$key?>">
                            <td><a href="/admin/images/edit/<?=$image['id']?>"><?=$image['name']?></a></td>

                            <td>
                                <input class="pos" type="hidden" name="position[]" value="<?=$image['id']?>">
                                <a href="#" class="btn btn-default up"> <span class="glyphicon glyphicon glyphicon-arrow-up"> </span></a>
                                <a href="#" class="btn btn-default down"> <span class="glyphicon glyphicon glyphicon-arrow-down"> </span></a>
                            </td>


                            <td>
                                <a href="/admin/images/edit/<?=$image['id']?>"><button class="btn btn-sm btn-primary">edit</button></a>
                                <a href="/admin/images/delete/<?=$image['id']?>" onclick="return confirmDelete();"><button class="btn btn-sm btn-warning">delete</button></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </form>
            </table>
        </div>
    </div>


    <br/>

    <div>
        <a href="/admin/images/delete/<?=$banner->id?>"><button class="btn btn-sm btn-success">Add new image</button></a>
    </div>
<style>
    td.red > a {
        color: red;
    }
</style>
    <script type="text/javascript">


            $('select').select2();

            $(document).ready(function(){

                event();

                function clickUp(elem) {
                    var currentBlock = elem.parent().parent();
                    var prevBlock = currentBlock.prev(".position");
                    if (prevBlock[0]) {
                        currentBlock.find('td').addClass('red');
                        prevBlock.find('td').addClass('red');
                        swap(prevBlock, currentBlock);
                        event();
                    }
                    return false;
                }

                function clickDown(elem) {
                    var currentBlock = elem.parent().parent();
                    var nextBlock = currentBlock.next(".position");

                    if (nextBlock[0]) {
                        currentBlock.find('td').addClass('red');
                        nextBlock.find('td').addClass('red');
                        swap(nextBlock, currentBlock);
                        event();
                    }
                    return false;
                }

                function event() {
                    $('.up').click(function (e) {
                        e.preventDefault();
                        clickUp($(this));
                    });

                    $('.down').click(function(e) {
                        e.preventDefault();
                        clickDown($(this));
                    });
                }

                function swap(n, c) {
                    nId = n.attr('id');
                    cId = c.attr('id');
                    nHtml = n.html();
                    cHtml = c.html();
                    $('tr#'+cId).html(nHtml);
                    $('tr#'+nId).html(cHtml);
                }
            });

            $('#formpos').on('submit', function (e) {
                e.preventDefault();
                var input = $("input.pos");
                var position = [];
              input.each(function(){
                  position.push($(this).val());
              })

//                console.log($(this).attr('action'))

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: 'position='+JSON.stringify(position),
                    success: function(json){
                        $('td.red').removeClass('red');
                    }
                }); //ajax
            })

            $('#save').click(function(){
                $('#formpos').submit();


//                console.log('send');
//                var data = $('#formpos');
//                console.log(data.attr('method'));
//                console.log(data.attr('action'));
//                var ser = data.serialize();

//                $.ajax({
////                    type: data.attr('method'),
////                    url: data.attr('action'),
//                    type: 'post',
//                    url: '/admin/banners/position',
//                    data: 'data='+data.serializeArray(),
//                    success: function(json){
//                        console.log(json);
//                        console.log('end');
//                    }
//                }); //ajax
            });



    </script>

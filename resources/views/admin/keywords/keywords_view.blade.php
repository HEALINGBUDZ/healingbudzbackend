<!DOCTYPE html>
<html lang="en">
<?php include resource_path('views/admin/includes/head.php'); ?>
<body>
<?php include resource_path('views/admin/includes/header.php'); ?>
<?php include resource_path('views/admin/includes/sidebar.php'); ?>
<section class="content lifeContent">

    @if(\Session::has('success'))
        <h4 class="alert alert-success fade in">
            {{\Session::get('success')}}
        </h4>
    @endif
    <a data-target="#add-modal" data-toggle="modal" class="add_s" href="#">Add New Keyword</a>

    <div class="contentPd">
        <h2 class="mainHEading">Keywords</h2>
        
        <table id="tableStyle" class="display" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Sr.</th>
                <th>Keyword</th>
                <th>Count</th>
                <th>date</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if(isset($keywords))
            <?php $i = 1; ?>
                @foreach($keywords as $keyword)
                    <tr>
                        <td><?php echo $i; $i++; ?></td>
                        <td>{{$keyword->key_word}}</td>
                        <td>{{$keyword->count}}</td>
                        <td>{{$keyword->date}}</td>
                        <td><a data-target="#price-modal-{{$keyword->id}}" data-toggle="modal">{{$keyword->price}}</a></td>
                        <td>
                            <a data-target="#modal-{{$keyword->id}}" data-toggle="modal" href="#"><i class="fa fa-trash fa-fw"></i></a>
                            @if($keyword->on_sale == 0)
                                <a data-target="#sale-modal-{{$keyword->id}}" data-toggle="modal">Put On Sale</a>
                            @else
                                <a href="{{url('/')}}/removesale/{{$keyword->id}}" data-toggle="modal">Remove From Sale</a>
                            @endif
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-{{$keyword->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete the keyword ?</p>
                                </div>
                                <div class="modal-footer">
                                    <button onlick="#"><a href="{{url('/')}}/delete_keyword/{{$keyword->id}}"> Confirm</a></button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="price-modal-{{$keyword->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <span>Update Price</span>
                                <form action="{{url('/')}}/update_keyword_price/{{$keyword->id}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <input type="text" value="{{$keyword->price}}" name="price">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default">Submit</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="sale-modal-{{$keyword->id}}" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <span>Add Price</span>
                                <form action="{{url('/')}}/onsale/{{$keyword->id}}" method="post">
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <input type="text" value="" name="price">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default">Submit</button>
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="modal fade" id="add-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <form action="{{url('/')}}/add_keyword" method="post">
                            {{csrf_field()}}
                            <div class="modal-body">
                                <input type="text" value="" name="keyword">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default">Submit</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </tbody>
        </table>


    </div>
    </div>
</section>
<?php include resource_path('views/admin/includes/footer.php'); ?>




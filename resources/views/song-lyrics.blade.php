<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Song Lyrics</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                            Songs   

                            <div class="float-right">
                                <button class="btn btn-sm btn-success" id="addSongBtn">Add Song</button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-condensed" id="song-table">
                            <thead>
                                <th>#</th>
                                <th>Title</th>
                                <th>Artist</th>
                                <th>Lyrics</th>
                                <th>Actions</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('song-modal')

    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>

    <script>

    // toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        }
    });
    

    $(function(){

        // GET ALL SONGS
        var table =  $('#song-table').DataTable({
            processing:true,
            info:true,
            ajax:"{{ route('get.song.lyrics') }}",
            columns:[
                {data:'id', name:'id'},
                {data:'title', name:'title'},
                {data:'artist', name:'artist'},
                {data:'lyrics', name:'lyrics'},
                {data:'actions', name:'actions', orderable:false, searchable:false},
            ]
        });

        // ADD SONG
        $(document).on('click','#addSongBtn', function(){
            $('.modalSong').find('form')[0].reset();
            $('.modalSong').find('input[name="id"]').val('');
            $('.modalSong').find('span.error-text').text('');
            $.post('<?= route("get.song") ?>',{}, function(data){
                $('.modalSong').modal('show');
            },'json');
        });

        // UPDATE SONG
        $(document).on('click','#editSongBtn', function(){
            var id = $(this).data('id');
            $('.modalSong').find('form')[0].reset();
            $('.modalSong').find('span.error-text').text('');
            $.post('<?= route("get.song") ?>',{id:id}, function(data){
                // alert(data.item.id);
                $('.modalSong').find('input[name="id"]').val(data.item.id);
                $('.modalSong').find('input[name="title"]').val(data.item.title);
                $('.modalSong').find('input[name="artist"]').val(data.item.artist);
                $('.modalSong').find('textarea[name="lyrics"]').val(data.item.lyrics);
                $('.modalSong').modal('show');
            },'json');
        });

        //UPDATE SONG ITEM
        $('#save-song-form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                    $(form).find('span.error-text').text('');
                },
                success: function(data){
                    if(data.code == 0){
                        $.each(data.error, function(prefix, val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
                        $('.modalSong').modal('hide');
                        $('.modalSong').find('form')[0].reset();
                        $('#song-table').DataTable().ajax.reload(null, false);
                        alert(data.msg);
                    }
                }
            });
        });

        //DELETE SONG ITEM
        $(document).on('click','#deleteSongBtn', function(){
            var id = $(this).data('id');
            var url = '<?= route("delete.song") ?>';

            swal.fire({
                title: "Are you sure?",
                html:'You want to <b>delete</b> this song',
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete",
                closeOnConfirm: false,
                allowOutsideClick:false
            }).then(function(result){
                if(result.value){
                    $.post(url,{id:id}, function(data){
                        if(data.code == 1){
                            $('#song-table').DataTable().ajax.reload(null, false);
                            alert(data.msg);
                        }else{
                            alert(data.msg);
                        }
                    },'json');
                }
            });

        });

        
    });
    </script>

</body>

</html>
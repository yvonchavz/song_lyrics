<div class="modal fade modalSong" tabindex="-1" role="dialog" aria-labelledby="songModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="songModalLabel">Edit Song</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= route('save.song') ?>" method="post" id="save-song-form">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter title">
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Artist</label>
                        <input type="text" class="form-control" name="artist" placeholder="Enter artist">
                        <span class="text-danger error-text artist_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="">Lyrics</label>
                        <textarea name="lyrics" id="" cols="30" rows="10" class="form-control"></textarea>
                        <span class="text-danger error-text lyrics_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">Save</button>
                    </div>
                </form>
                

            </div>
        </div>
    </div>
</div>
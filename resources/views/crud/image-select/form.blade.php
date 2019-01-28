<input class="form-control" type="text" value="{{$data->test->name ?? ""}}" name="name" required placeholder="Name">
<br>
<textarea required="required" name="description">{{$data->test->description ?? ""}}
    </textarea>
<br>
<div class="form-group">
    <label for="imageInput">Images</label>
    <input type="file" id="imageInput" required name="images[]" accept='image/*' multiple>
</div>

<label for="max">The maximum number of images that can be selected, leave at 0 for no limit</label>
<input type="number" min="0" step="1" name="max" id="max" value="{{$data->max ?? "0"}}" class="form-control">

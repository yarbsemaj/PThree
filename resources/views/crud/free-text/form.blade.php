<input class="form-control" type="text" value="{{$data->test->name ?? ""}}" name="name" required placeholder="Question">
<br>
<div class="form-group">
    <label>Description</label>
    <textarea required="required" name="description">{{$data->test->description ?? ""}}
    </textarea>
</div>
<br>

<input class="form-control" type="text" value="{{$data->test->name ?? ""}}" name="name" required placeholder="Question">
<br>
<textarea required="required" name="description">{{$data->test->description ?? ""}}
    </textarea>
<br>

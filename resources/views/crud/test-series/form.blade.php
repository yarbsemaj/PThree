<input class="form-control" type="text" value="{{$testseries->name ?? ""}}" name="name" required placeholder="Name">
<br>
<textarea required="required" name="description">{{$testseries->description ?? ""}}
    </textarea>

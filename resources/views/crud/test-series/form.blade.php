<input class="form-control" type="text" value="{{$testseries->name ?? ""}}" name="name" required placeholder="Name">
<br>
<div class="form-group">
    <label>Description</label>
<textarea required="required" name="description">{{$testseries->description ?? ""}}
    </textarea>
</div>

<div class="form-group">
    <label>Consent From</label>
    <input class="form-control" name="consent_form" required type="file" accept="application/pdf,.doc,.docx">
</div>
<input class="form-control" type="text" value="{{$data->test->name ?? ""}}" name="name" required placeholder="Name">
<br>
<textarea required="required" name="description">{{$data->test->description ?? ""}}
    </textarea>
<br>
<div class="form-group">
    <label for="mapInput">Words to order</label>
    <select multiple name="words[]" class="chosenMultiSelect">
        @if(isset($data))
            @foreach($data->orderTestWords as $word)
                <option value="{{$word->name}}" selected>{{$word->name}}</option>
            @endforeach
        @endif
    </select>
</div>

<script>
    $(document).ready(function () {
        $('.chosenMultiSelect').select2({
            placeholder: 'Please add some words to order',
            tags: true,
            multiple: true,
            width: '100%'
        });
    });
</script>

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

@endpush

@push("styles")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endpush()

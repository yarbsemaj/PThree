<input class="form-control" type="text" value="{{$data->test->name ?? ""}}" name="name" required placeholder="Name">
<br>
<div class="form-group">
    <label>Description</label>
    <textarea required="required" name="description">{{$testseries->description ?? ""}}
    </textarea>
</div>
<br>
<div class="form-group">
    <label for="words">Words to select from</label>
    <select multiple id="words" name="words[]" class="chosenMultiSelect">
        @if(isset($data))
            @foreach($data->wordTestWords as $word)
                <option value="{{$word->name}}" selected>{{$word->name}}</option>
            @endforeach
        @endif
    </select>
</div>

<label for="max">The maximum number of words that can be selected, leave at 0 for no limit</label>
<input type="number" min="0" step="1" name="max" id="max" value="{{$data->max ?? "0"}}" class="form-control">

<script>
    $(document).ready(function () {
        $('.chosenMultiSelect').select2({
            placeholder: 'Please add some words to select from',
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

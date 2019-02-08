<input class="form-control" type="text" value="{{$map->test->name ?? ""}}" name="name" required placeholder="Name">
<br>
<div class="form-group">
    <label>Description</label>
    <textarea required="required" name="description">{{$testseries->description ?? ""}}
    </textarea>
</div>
<br>
<div class="form-group">
    <label for="mapInput">Map Image</label>
    <input type="file" id="mapInput" required name="map" accept='image/*'>
</div>

<div class="form-group">
    <label for="mapInput">Types of Pin</label>
    <select multiple name="mapPins[]" class="chosenMultiSelect">
        @if(isset($map))
            @foreach($map->mapPins as $mapPin)
                <option value="{{$mapPin->name}}" selected>{{$mapPin->name}}</option>
            @endforeach
        @endif
    </select>
</div>

<script>
    function formatState(state) {
        if (!state.id) {
            return state.text;
        }

        var baseUrl = "/img/pins";
        var state = $(
            '<span><img src="' + baseUrl + '/' + $(".chosenMultiSelect [value='" + state.id + "']").index() + '.png" ' +
            'style="width: 20px; height: 20px" /> ' + state.text + '</span>'
        );
        return state;
    }

    $(document).ready(function () {
        $('.chosenMultiSelect').select2({
            placeholder: 'Please add a Pin',
            tags: true,
            multiple: true,
            width: '100%',
            maximumSelectionLength: 9,
            templateSelection: formatState
        });
    });
</script>

@push("scripts")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

@endpush

@push("styles")
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
@endpush()
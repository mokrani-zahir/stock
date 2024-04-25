@extends('base')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <div class="popop">
        <label>Country name</label>
        <input type="text" name="country_name" id="country_name">
        <input type="text" name="phone" id="phone">
        <hr>
        <label> Capital : <span id="capital"></span></label>
    </div>
    <script>
        aData = {}

        $("#country_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: '/search',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        term: request.term,
                        my_variable2: "variable2_data"
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token() }}'
                    },
                    success: function(data) {
                        aData = $.map(data, function(value, key) {
                            return {label:value.siege, ...value }
                        })
                        console.log(aData)
                        var results = $.ui.autocomplete.filter(aData, request.term)
                        response(results)
                    }
                })
            },
            select: function(event, ui) {
                console.log(ui)
                $("#phone").val(ui.item.telephon)
            }
        });


    </script>
@endsection

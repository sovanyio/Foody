@extends('layout.main')
@section('title')
    $title = 'Search for an Ingredient;
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <h2 {{ HTML::attributes(['class' => 'form-search-ingredient-heading']) }}>Ingredient Search</h2>
            {{ Form::label('ingredient', 'Name of Ingredient', ['class' => 'sr-only']) }}
            {{ Form::select('ingredient', $optgroups, ['class' => 'form-control typeahead', 'placeholder' => 'Name of Ingredient', 'required' => 'true', 'autofocus' => 'true', 'autocomplete' => 'off']) }}
            <br />
            {{--{{ Form::submit('Search', ['class' => 'btn btn-primary btn-block', 'id' => 'search']) }}--}}
            <div id="detail">
                <?php echo $detail ?>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function() {
        $('#ingredient').selectize({
            valueField: 'value',
            labelField: 'label',
            searchField: 'label',
            optgroupField: 'optgroup',
            optgroupLabelField: 'optgroup',
            selectOnTab: true,
            loadThrottle: 500,
            load: function(query, callback) {
                if (!query.length) return callback();

                NProgress.start();

                $.ajax({
                    url: '{{ URL::action('IngredientController@postSearch') }}',
                    type: 'post',
                    data: {
                        _token: $('input[name=_token]').val(),
                        ingredient: query
                    },
                    error: function() {
                        callback();
                    },
                    success: function(res) {
                        callback($.parseJSON(res));
                    },
                    complete: function() {
                        NProgress.done();
                    }
                });
            }
        }).change(function() {
            getDetails();
        });

        var getDetails = function() {
            var id = $('#ingredient').val();
            if(!id.length) noResult();

            $('#detail').html();
            NProgress.start();

            $.ajax({
                url: '{{ URL::action('IngredientController@postDetails') }}',
                method: 'post',
                data: {
                    ingredient: id
                },
                error: function() {
                    noResult();
                },
                success: function(res) {
                    $('#detail').html(res);
                    history.pushState(null, null, '{{ URL::action('IngredientController@getDetails') }}?ingredient='+id);
                },
                complete: function() {
                    NProgress.done();
                }
            });
        };

        var noResult = function() {
            $('#detail').html('<h2>No Results</h2>')
        }
    });
</script>
@stop
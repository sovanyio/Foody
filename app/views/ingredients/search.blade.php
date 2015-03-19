@extends('layout.main')
@section('title')
    $title = 'Search for an Ingredient;
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h2 {{ HTML::attributes(['class' => 'form-search-ingredient-heading']) }}>Ingredient Search</h2>
            {{ Form::label('ingredient', 'Name of Ingredient', ['class' => 'sr-only']) }}
            {{ Form::select('ingredient', $optgroups, ['class' => 'form-control typeahead', 'placeholder' => 'Name of Ingredient', 'autofocus' => 'true', 'autocomplete' => 'off']) }}
            <br />
            {{--{{ Form::submit('Search', ['class' => 'btn btn-primary btn-block', 'id' => 'search']) }}--}}
            <div class="detail">
                <?php echo isset($detail) ? $detail : ''?>
            </div>
        </div>
        <div class="col-md-6 hidden-xs hidden-sm">
            <h2 {{ HTML::attributes(['class' => 'form-search-ingredient-heading']) }}>Compare</h2>
            {{ Form::label('compare', 'Name of Ingredient', ['class' => 'sr-only']) }}
            {{ Form::select('compare', $optgroups, ['class' => 'form-control typeahead', 'placeholder' => 'Name of Ingredient', 'autofocus' => 'false', 'autocomplete' => 'off']) }}
            <br />
            {{--{{ Form::submit('Search', ['class' => 'btn btn-primary btn-block', 'id' => 'search']) }}--}}
            <div class="detail">
                <?php echo isset($compareDetails) ? $compareDetails: ''?>
            </div>
        </div>
    </div>
<script type="text/javascript">
    $(function() {
        $('#ingredient,#compare').selectize({
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
            getDetails(this);
        });

        var getDetails = function(element) {
            var $el = $(element),
                detail = $el.parents('.col-md-6').children('.detail'),
                id = $el.val();

            if(!id.length) {
                detail.html('<h2>No Results</h2>')
                return;
            }

            detail.html();
            NProgress.start();

            $.ajax({
                url: '{{ URL::action('IngredientController@postDetails') }}',
                method: 'post',
                data: {
                    ingredient: id
                },
                error: function() {
                    detail.html('<h2>No Results</h2>')
                },
                success: function(res) {
                    var base = '{{ URL::action('IngredientController@getDetails') }}',
                        ingredient = $('#ingredient').val(),
                        compare = $('#compare').val();

                    detail.html(res);

                    if (ingredient) {
                        base = base + '?ingredient=' + ingredient;
                    }
                    if (compare) {
                        base = base + (base.match(/\?/) === null ? '?' : '&') + 'compare=' + compare;
                    }

                    history.pushState(null, null, base);
                },
                complete: function() {
                    NProgress.done();
                }
            });
        };
    });
</script>
@stop
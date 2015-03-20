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
    var ingredientVal,
        compareVal;

    $(function() {
        // Run search on the selects on user input
        $('#ingredient,#compare').selectize({
            valueField: 'value',
            labelField: 'label',
            searchField: 'label',
            optgroupField: 'optgroup',
            optgroupLabelField: 'optgroup',
            selectOnTab: true,
            loadThrottle: 500,
            preload: true,
            load: function(query, callback) {
                // Run searches based on the URL
                // This is for sharing your lookup...
                var params = window.location.search.replace(/\?/, '');
                if (!query.length && params.length) {
                    params = params.split('&');
                    for(var i = 0; i < params.length; i++) {
                        var parts = params[i].split('=');
                        // Set value and trigger load
                        if (this.$input.attr('id') != parts[0]) continue;

                        switch(parts[0]) {
                            case 'ingredient':
                                ingredientVal = parts[1];
                                break;
                            case 'compare':
                                compareVal = parts[1];
                                break;
                        }
                        getDetails(document.getElementById(parts[0]), parts[1]);
                    }
                    return callback();
                } else if (!query.length) {
                    return callback();
                }

                NProgress.start();

                $.ajax({
                    url: '{{ URL::route('ingredientSearch') }}',
                    method: 'post',
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
            // Get details on select
            getDetails(this);
        });

        var getDetails = function(element, override) {
            var $el = $(element),
                override = override || false,
                detail = $el.parents('.col-md-6').children('.detail'),
                id = override || $el.val();

            if(!id.length) {
                detail.html('<h2>No Results</h2>');
                return;
            }

            detail.html(null);
            NProgress.start();

            $.ajax({
                url: '{{ URL::route('ingredientDetail') }}',
                method: 'post',
                data: {
                    ingredient: id
                },
                error: function() {
                    detail.html('<h2>No Results</h2>')
                },
                success: function(res) {
                    detail.html(res);

                    if (!override) {
                        var base = '{{ URL::current() }}',
                            ingredientId = $('#ingredient').val() || ingredientVal,
                            compareId = $('#compare').val() || compareVal;

                        if (ingredientId) {
                            base = base + '?ingredient=' + ingredientId;
                        }
                        if (compareId) {
                            base = base + (base.match(/\?/) === null ? '?' : '&') + 'compare=' + compareId;
                        }

                        history.pushState(null, null, base);

//                        // Clear these values so URL building works normally
//                        ingredientVal = null;
//                        compareVal = null;
                    }
                },
                complete: function() {
                    NProgress.done();
                }
            });
        };
    });
</script>
@stop
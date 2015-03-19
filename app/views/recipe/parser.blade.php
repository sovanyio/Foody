@extends('layout.main')
@section('js-include')
    <script src="/bower_components/fold-to-ascii/bundle.js"></script>
    <script src="/develop/ingreedy.js"></script>
@stop
@section('content')
    <div class="form-group">
        <div class="row">
            <div class="col-md-10">
                {{Form::label('id', 'Recipe Nutrition Estimator', ['for' => 'recipe'])}}
            </div>
            <div class="col-md-2">
                <a href="#" id="example" class="btn btn-danger btn-xs padding-left" style="float: right">Example Recipe</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{Form::textarea('recipe', null, ['class' => 'form-control', 'placeholder' => 'Paste ingredient list here'])}}
            </div>
        </div>
    </div>
    <div class="panel panel-info" id="ingreedy-results">
        <div class="panel-heading">
            <h3 class="panel-title">Paste an ingredient list to get started</h3>
        </div>
        <div class="panel-body">
            <ul id="panel-list"></ul>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var data,
                timer;

            // Simulate paste for example
            $('#example').click(function() {
                $('textarea[name=recipe]').val(
'2 thin fresh ginger slices\n\
1 teaspoon apricot jam\n\
1/4 ounce fresh lemon juice\n\
Ice\n\
2 ounces Irish whiskey\n\
1/2 ounce Grand Marnier\n\
1 lemon twist'
                ).trigger('paste');
            });

            // Process data on paste
            $('textarea[name=recipe]')
                    .on('paste', function() {handler(this);})
                    .on('keyup', function() {
                        var input = this;
                        clearTimeout(timer);
                        timer = setTimeout(function() {
                            handler(input);
                        }, 750);
                    });

            var handler = function(el) {
                var self = el;
                NProgress.start();
                setTimeout(function() {
                    // Remove commas, and common , {style} data
                    var paste = $(self).val().trim().replace(/(,\s*\w*$)|,/gim, '').split('\n'),
                            ingredients = [];

                    // Collapse unicode to ASCII for PEG.js processing
                    // Process with ingreedy-js
                    for (var i in paste) {
                        try {
                            var result = Ingreedy.parse(fold(paste[i]));
                            ingredients.push(result);
                        } catch (e) {
                            console.error(e);
                            ingredients.push(paste[i]);
                        }
                    }

                    // Send the paste data to the server
                    $.ajax({
                        url: '{{ URL::route('recipe-submit') }}',
                        method: 'post',
                        data: {
                            ingredients: ingredients
                        },
                        success: function(res) {
                            var $detail = $('#ingreedy-results'),
                                    $list = $('#panel-list');
                            // Save data
                            data = res;

                            // Change title of result container
                            $detail.children('.panel-heading').html('Ingredients found');
                            $list.html('');

                            // For now, lets just display the search results
                            // @TODO Improve ingredient detection server-side
                            // @TODO Calculate nutritional value with those better search results
                            // @TODO Build out real interface to view server results
                            for(var i in res) {
                                // This just builds a list of the results so we can see that something happened
                                var $li = $('<li></li>').html(i),
                                        $ul = $('<ul></ul>');

                                if(res[i].length) {
                                    for(var k = 0; k < res[i].length; k++) {
                                        $ul.append(
                                                $('<li></li>')
                                                        .attr('data-id', res[i][k].value)
                                                        .html(res[i][k].label + ' (' + res[i][k].optgroup + ')')
                                        )
                                    }
                                } else {
                                    $ul.append(
                                            $('<li></li>').html('Nothing found for this ingredient.')
                                    )
                                }
                                $li.append($ul);
                                $list.append($li);
                            }

                        },
                        failure: function(error) {

                        },
                        complete: function() {
                            NProgress.done();
                        }
                    });
                }, 0);
            }
        });
    </script>
@stop
@if(isset($ingredient))
<table class="table table-striped table-condensed table-hover table-responsive">
    <h3>{{{ $ingredient->long_desc }}}</h3>
    <thead>
        <tr>
            <th>Nutrient</th>
            <th class="text-right hidden-xs">100g</th>
            @foreach($servings as $serving)
                <th class="text-right">{{{ $serving->amount.' '.$serving->msre_desc }}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach ($details as $detail)
        <tr>
            <td><abbr title="{{{ $detail->help_text }}}">{{{ $detail->name  }}}</abbr></td>
            <td class="text-right hidden-xs">{{{ $detail->value.' '.$detail->units  }}}</td>
            @foreach($servings as $serving)
                <td class="text-right">{{{ number_format($serving->gm_wgt / 100 * $detail->value, 1).' '.$detail->units }}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
@endif
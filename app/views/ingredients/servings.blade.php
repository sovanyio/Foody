<table class="table table-striped table-condensed table-hover">
    <h4>Serving Information</h4>
    <thead>
    <tr>
        <th class="text-right">Measure</th>
        <th class="text-right">Weight</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($servings as $serving)
        <tr>
            <td class="text-right">{{{ $serving->amount.' '.$serving->msre_desc }}}</td>
            <td class="text-right">{{{ $serving->gm_wgt  }}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
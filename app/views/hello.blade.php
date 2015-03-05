@extends('layout.main')
@section('content')
<div class="jumbotron">
    <h1>Foody</h1>
    <p>Explore the nutritional content of your food.</p>
</div>
<div class="row">
    <div class="col-md-6">
        <h2>How healthy is mom's chicken soup?</h2>
        <p>That is a good question that we have all probably wondered at some point. Luckily you found Foody! Paste the ingredients with their amounts (like you would see above a recipe) and find out.</p>
    </div>
    <div class="col-md-6">
        <h2>Lookup individual ingredients too!</h2>
        <p>Curious about an ingredient? Easily look up its nutritional profile.  Want to compare? We've got you covered there, too.  Just head to the {{HTML::link(URL::route('ingredient-detail'), 'ingredient search')}} page.</p>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h2>That's it?</h2>
        <p>For now, yes. Be on the lookout for these features soon:</p>
        <ul>
            <li>Paste a URL to a recipe to get nutritional info</li>
            <li>Bookmarklet to show a recipe's nutritional profile without leaving the recipe.</li>
            <li>See how the nutritional profile changes with substitutions</li>
            <li>Recipe management</li>
            <li>Meal planning around nutritional goals</li>
            <li>Mobile Apps</li>
        </ul>
    </div>
</div>
@stop
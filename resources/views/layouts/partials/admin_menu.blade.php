<?php 
  use App\CreateSite; 
   // We want to get the Domain of the Current Domain the Use is ON
   $domain = new CreateSite();
   $getByDomain = $domain->getUrl();
?>

<div class="btn-group btn-block mb-3" role="group" aria-label="Basic example">
    <a href="{{ route('create.post') }}" class="btn btn-secondary">Create New Article</a>
    <a href="{{ route('dashboard') }}" class="btn btn-secondary">All Articles</a>

    @if(Auth::check() && $getByDomain->user_id == Auth::user()->id)
        <a href="{{ route('admin') }}" class="btn btn-secondary">Admins</a>
    @endif
</div>
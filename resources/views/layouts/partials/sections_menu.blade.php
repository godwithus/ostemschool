<?php use App\Department; 
    $dept = Department::all();
?>

<div class="card bg-light">
    <div class="card-body">
        @foreach($dept as $eachDept)
            <a href="{{ route('section', $eachDept->id) }}" class="btn btn-secondary"> {{ $eachDept->name }} </a>
        @endforeach
    </div>
</div>
@component('files.partials._file', ['file'=>$file] )
    @slot('links')
    <div class="level">
        <div class="level-left">
            <p class="level-item">
                <a href="{{ route('admin.files.show',$file) }}" class="has-text-primary">Preview Changes</a>
            </p>
            <p class="level-item">
                <a href="#" class="has-text-primary" onclick="event.preventDefault();document.getElementById('approve-{{ $file->id}}').submit()">Approve</a>
            </p>

            <form action="{{ route('admin.files.updated.update',$file) }}" id="approve-{{ $file->id }}" method="post" class="is-hidden">
                @csrf
                {{ method_field('PATCH') }}
            </form>

            <p class="level-item">
                <a href="#" class="has-text-primary" onclick="event.preventDefault();document.getElementById('reject-{{ $file->id}}').submit()">Reject</a>
            </p>
           
            <form action="{{ route('admin.files.updated.destroy',$file) }}" id="reject-{{ $file->id }}" method="post" class="is-hidden">
                @csrf
                {{ method_field('DELETE') }}
            </form>

        </div>
    </div>
    @endslot
@endcomponent


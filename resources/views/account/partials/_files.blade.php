@component('files.partials._file', ['file'=>$file] )
    @slot('links')
        <div class="level-left">
            <p class="level-item">
                {{ $file->isFree() ? 'Free' : 'P' . $file->price}}
            </p>
            @if(!$file->approved)
                <p class="level-item">
                    Pending approval
                </p>
            @endif
            <p class="level-item">
                {{ $file->live ? 'Live' : 'Not Live' }}
            </p>
            <a href="{{ route('account.files.edit',$file) }}" class="level-item">Make Changes</a>
        </div>
    @endslot
@endcomponent


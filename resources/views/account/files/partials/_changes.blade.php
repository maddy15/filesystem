<article class="message is-primary">
    <div class="message-header">
        <p>We're currently reviewing the following changes.</p>
    </div>

    <div class="message-body">
        <div class="content">
            @if($approval->title != $file->title)
                <strong>Title</strong>
                <p>{{ $approval->title }}</p>
            @endif

            @if($approval->overview_short != $file->overview_short)
                <strong>Overview Short</strong>
                <p>{{ $approval->overview_short }}</p>
            @endif

            @if($approval->overview != $file->overview)
                <strong>Overview</strong>
                <p>{{ $approval->overview }}</p>
            @endif


            @if($file->uploads()->hasNotApproved()->count() > 0)
                <strong>Uploads</strong>
                @foreach($file->uploads()->hasNotApproved()->get() as $upload)
                    <p>{{ $upload->filename }}</p>
                @endforeach
            @endif
        </div>
    </div>
</article>